<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Obatalkes;
use App\Models\Signa;
use App\Models\Resep;
use App\Models\ResepDetail;
use Illuminate\Support\Facades\DB;

class ResepController extends Controller
{
    // ... method yang sudah ada sebelumnya tetap sama ...

    public function index()
    {
        $reseps = Resep::with('details')->orderBy('created_at', 'desc')->get();
        return view('reseps.index', compact('reseps'));
    }

    public function create()
    {
        $obatalkes = Obatalkes::where('is_deleted', 0)->where('is_active', 1)->get();
        $signas = Signa::where('is_deleted', 0)->where('is_active', 1)->get();

        return view('reseps.create', compact('obatalkes', 'signas'));
    }

    // METHOD BARU: Show detail resep
    public function show($id)
    {
        $resep = Resep::with([
            'details' => function ($query) {
                $query->with(['obatalkes', 'signa']);
            }
        ])->findOrFail($id);

        return view('reseps.show', compact('resep'));
    }



    // METHOD BARU: Hapus resep
    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $resep = Resep::with('details')->findOrFail($id);

            // Kembalikan stok obat sebelum menghapus resep
            foreach ($resep->details as $detail) {
                if ($detail->is_racikan) {
                    // Untuk racikan, perlu implementasi khusus karena detail obat tidak tersimpan
                    // Skip untuk sementara atau implementasi jika ada tabel detail obat racikan
                } else {
                    if ($detail->obatalkes_id) {
                        $obat = Obatalkes::find($detail->obatalkes_id);
                        if ($obat) {
                            $obat->stok += $detail->qty;
                            $obat->save();
                        }
                    }
                }
            }

            // Hapus detail resep
            $resep->details()->delete();

            // Hapus resep
            $resep->delete();

            DB::commit();
            return redirect()->route('reseps.index')->with('success', 'Resep berhasil dihapus dan stok obat dikembalikan.');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Gagal menghapus resep: ' . $e->getMessage());
        }
    }

    // METHOD BARU: Hapus detail resep (untuk AJAX)
    public function destroyDetail($id)
    {
        try {
            $detail = ResepDetail::findOrFail($id);

            // Kembalikan stok obat
            if (!$detail->is_racikan && $detail->obatalkes_id) {
                $obat = Obatalkes::find($detail->obatalkes_id);
                if ($obat) {
                    $obat->stok += $detail->qty;
                    $obat->save();
                }
            }

            $detail->delete();

            return response()->json(['success' => true, 'message' => 'Detail resep berhasil dihapus.']);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal menghapus detail resep: ' . $e->getMessage()]);
        }
    }

    // ... method yang sudah ada sebelumnya tetap sama ...

    public function store(Request $request)
    {
        $validated = $request->validate([
            'details.*.obatalkes_id' => 'nullable|exists:obatalkes_m,obatalkes_id',
            'details.*.signa_id' => 'nullable|exists:signa_m,signa_id',
            'details.*.qty' => 'required|integer|min:1',
            'details.*.is_racikan' => 'required|boolean',
            'details.*.nama_racikan' => 'nullable|string',
        ]);

        // Simpan resep utama
        $resep = Resep::create([]); // tambahkan field jika ada

        // Simpan resep detail
        foreach ($request->details as $detail) {
            $resep->details()->create([
                'obatalkes_id' => $detail['obatalkes_id'] ?? null,
                'signa_id' => $detail['signa_id'] ?? null,
                'qty' => $detail['qty'],
                'is_racikan' => $detail['is_racikan'],
                'nama_racikan' => $detail['nama_racikan'] ?? null,
            ]);
        }

        return redirect()->route('reseps.create')->with('success', 'Resep berhasil disimpan');
    }

    public function formNonracikan()
    {
        $obatalkes = Obatalkes::where('is_deleted', 0)->where('is_active', 1)->get();
        $signas = Signa::where('is_deleted', 0)->where('is_active', 1)->get();

        return view('reseps.form.nonracikan', compact('obatalkes', 'signas'));
    }

    public function formRacikan()
    {
        $obatalkes = Obatalkes::where('is_deleted', 0)->where('is_active', 1)->get();
        $signas = Signa::where('is_deleted', 0)->where('is_active', 1)->get();

        return view('reseps.form.racikan', compact('obatalkes', 'signas'));
    }

    public function storeNonracikan(Request $request)
    {
        $request->validate([
            'obatalkes_id' => 'required|integer',
            'qty' => 'required|integer|min:1',
            'signa_id' => 'required|integer',
        ]);

        $obat = Obatalkes::where('obatalkes_id', $request->obatalkes_id)
            ->where('is_deleted', 0)
            ->where('is_active', 1)
            ->first();

        if (!$obat) {
            return redirect()->back()->with('error', 'Obat tidak ditemukan.');
        }

        // Ambil stok terpakai dari session
        $stokTerpakai = session()->get('stok_terpakai', []);
        $terpakai = $stokTerpakai[$obat->obatalkes_id] ?? 0;

        $stokTersedia = $obat->stok - $terpakai;

        if ($stokTersedia < $request->qty) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi.');
        }

        $signa = Signa::where('signa_id', $request->signa_id)
            ->where('is_deleted', 0)
            ->where('is_active', 1)
            ->first();

        if (!$signa) {
            return redirect()->back()->with('error', 'Signa tidak ditemukan.');
        }

        // Simpan ke draft resep
        $draft = session()->get('resep_draft', []);
        $draft[] = [
            'nama' => $obat->obatalkes_nama,
            'qty' => $request->qty,
            'signa' => $signa->signa_nama,
            'is_racikan' => false,
            'obatalkes_id' => $obat->obatalkes_id,
            'signa_id' => $signa->signa_id,
        ];
        session(['resep_draft' => $draft]);

        // Tambahkan ke stok terpakai
        $stokTerpakai[$obat->obatalkes_id] = $terpakai + $request->qty;
        session(['stok_terpakai' => $stokTerpakai]);

        return redirect()->route('reseps.create')->with('success', 'Resep berhasil ditambahkan ke draft.');
    }

    public function removeDraft($index)
    {
        $draft = session()->get('resep_draft', []);
        unset($draft[$index]); // hapus berdasarkan index
        session(['resep_draft' => array_values($draft)]); // reset index
        return redirect()->back()->with('success', 'Item dihapus dari draft.');
    }

    public function simpanDraft(Request $request)
    {
        $draft = session('resep_draft', []);

        if (empty($draft)) {
            return redirect()->route('reseps.create')->with('error', 'Tidak ada data dalam draft resep.');
        }

        $request->validate([
            'nama_pasien' => 'required|string|max:255',
        ]);

        $resep = Resep::create([
            'nama_pasien' => $request->nama_pasien,
        ]);

        foreach ($draft as $item) {
            if ($item['is_racikan']) {
                // Untuk item racikan
                $resepDetail = ResepDetail::create([
                    'resep_id' => $resep->id,
                    'obatalkes_id' => null, // Racikan tidak memiliki obatalkes_id tunggal
                    'nama_racikan' => $item['nama'],
                    'is_racikan' => true,
                    'qty' => 1, // Racikan biasanya qty = 1 bungkus/pot
                    'signa_id' => $item['signa_id'],
                ]);

                // Proses setiap obat dalam racikan
                foreach ($item['obats'] as $obat) {
                    // Kurangi stok untuk setiap obat dalam racikan
                    $obatalkes = Obatalkes::where('obatalkes_id', $obat['obatalkes_id'])->first();
                    if ($obatalkes) {
                        $obatalkes->stok -= $obat['qty'];
                        $obatalkes->save();
                    }
                }
            } else {
                // Untuk item non-racikan
                ResepDetail::create([
                    'resep_id' => $resep->id,
                    'obatalkes_id' => $item['obatalkes_id'],
                    'nama_racikan' => null,
                    'is_racikan' => false,
                    'qty' => $item['qty'],
                    'signa_id' => $item['signa_id'],
                ]);

                // Kurangi stok obat non-racikan
                $obat = Obatalkes::where('obatalkes_id', $item['obatalkes_id'])->first();
                if ($obat) {
                    $obat->stok -= $item['qty'];
                    $obat->save();
                }
            }
        }

        // Hapus session
        session()->forget('resep_draft');
        session()->forget('stok_terpakai');

        return redirect()->route('reseps.show', $resep->id)->with('success', 'Resep berhasil disimpan ke database.');
    }

    public function batal()
    {
        session()->forget('resep_draft');
        session()->forget('stok_terpakai');

        return redirect()->route('reseps.create')->with('success', 'Draft resep dibatalkan.');
    }

    public function storeRacikan(Request $request)
    {
        $request->validate([
            'nama_racikan' => 'required|string|max:255',
            'signa_id' => 'required|integer',
            'obats' => 'required|array|min:1',
            'obats.*.obatalkes_id' => 'required|integer',
            'obats.*.qty' => 'required|integer|min:1',
        ]);

        $signa = Signa::where('signa_id', $request->signa_id)
            ->where('is_deleted', 0)->where('is_active', 1)->first();

        if (!$signa) {
            return back()->with('error', 'Signa tidak ditemukan.');
        }

        // Ambil stok terpakai dari session untuk validasi
        $stokTerpakai = session()->get('stok_terpakai', []);

        $obatList = [];
        foreach ($request->obats as $item) {
            $obat = Obatalkes::where('obatalkes_id', $item['obatalkes_id'])
                ->where('is_deleted', 0)
                ->where('is_active', 1)
                ->first();

            if (!$obat) {
                return back()->with('error', 'Obat dengan ID ' . $item['obatalkes_id'] . ' tidak ditemukan.');
            }

            // Cek stok tersedia dengan mempertimbangkan stok yang sudah terpakai
            $terpakai = $stokTerpakai[$obat->obatalkes_id] ?? 0;
            $stokTersedia = $obat->stok - $terpakai;

            if ($stokTersedia < $item['qty']) {
                return back()->with('error', 'Stok obat ' . $obat->obatalkes_nama . ' tidak mencukupi. Tersedia: ' . $stokTersedia);
            }

            $obatList[] = [
                'obatalkes_id' => $obat->obatalkes_id,
                'nama' => $obat->obatalkes_nama,
                'qty' => $item['qty'],
            ];

            // Update stok terpakai
            $stokTerpakai[$obat->obatalkes_id] = $terpakai + $item['qty'];
        }

        $draft = session()->get('resep_draft', []);

        $draft[] = [
            'nama' => $request->nama_racikan,
            'signa' => $signa->signa_nama,
            'signa_id' => $signa->signa_id,
            'is_racikan' => true,
            'obats' => $obatList,
        ];

        session(['resep_draft' => $draft]);
        session(['stok_terpakai' => $stokTerpakai]);

        return redirect()->route('reseps.create')->with('success', 'Racikan berhasil ditambahkan ke draft.');
    }


}