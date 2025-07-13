<?php

// File: app/Http/Controllers/RacikanController.php

namespace App\Http\Controllers;

use App\Models\RacikanDetail;
use App\Models\ResepDetail;
use App\Models\Obatalkes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RacikanController extends Controller
{
    // Menampilkan detail racikan via AJAX
    public function getDetail($resepDetailId)
    {
        try {
            // Debug: Log request
            \Log::info('Getting racikan detail for ID: ' . $resepDetailId);

            // Cek apakah ResepDetail ada
            $resepDetail = ResepDetail::find($resepDetailId);
            if (!$resepDetail) {
                \Log::error('ResepDetail not found: ' . $resepDetailId);
                return response()->json([
                    'success' => false,
                    'message' => 'Resep detail tidak ditemukan'
                ], 404);
            }

            // Debug: Log resep detail
            \Log::info('ResepDetail found: ', $resepDetail->toArray());

            if (!$resepDetail->is_racikan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Item ini bukan racikan'
                ], 400);
            }

            // Cek apakah method racikanDetails ada
            if (!method_exists($resepDetail, 'racikanDetails')) {
                \Log::error('Method racikanDetails not found in ResepDetail model');
                return response()->json([
                    'success' => false,
                    'message' => 'Relasi racikanDetails belum ditambahkan ke model ResepDetail'
                ], 500);
            }

            // Load relasi dengan eager loading
            $resepDetail->load(['racikanDetails.obatalkes', 'signa']);

            $racikanDetails = $resepDetail->racikanDetails->map(function ($detail) {
                return [
                    'id' => $detail->id,
                    'obat_nama' => $detail->obatalkes->obatalkes_nama ?? 'Obat tidak ditemukan',
                    'obat_kode' => $detail->obatalkes->obatalkes_kode ?? '-',
                    'obatalkes_id' => $detail->obatalkes_id,
                    'qty' => $detail->qty,
                    'satuan' => $detail->satuan,
                    'keterangan' => $detail->keterangan,
                    'stok_tersedia' => $detail->obatalkes->stok ?? 0
                ];
            });

            return response()->json([
                'success' => true,
                'data' => [
                    'nama_racikan' => $resepDetail->nama_racikan,
                    'qty_racikan' => $resepDetail->qty,
                    'signa' => $resepDetail->signa->signa_nama ?? 'Tidak ada signa',
                    'total_obat' => $racikanDetails->count(),
                    'details' => $racikanDetails
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error('Error getting racikan detail: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    // Menyimpan atau update detail racikan
    public function storeDetail(Request $request, $resepDetailId)
    {
        $request->validate([
            'details' => 'required|array',
            'details.*.obatalkes_id' => 'required|string',
            'details.*.qty' => 'required|numeric|min:0.01',
            'details.*.satuan' => 'required|string|max:50',
            'details.*.keterangan' => 'nullable|string|max:255'
        ]);

        try {
            DB::beginTransaction();

            $resepDetail = ResepDetail::findOrFail($resepDetailId);

            if (!$resepDetail->is_racikan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Item ini bukan racikan'
                ], 400);
            }

            // Hapus detail racikan yang lama
            $resepDetail->racikanDetails()->delete();

            // Simpan detail racikan yang baru
            foreach ($request->details as $detail) {
                // Validasi apakah obatalkes_id ada
                $obat = Obatalkes::where('obatalkes_id', $detail['obatalkes_id'])->first();
                if (!$obat) {
                    throw new \Exception('Obat dengan ID ' . $detail['obatalkes_id'] . ' tidak ditemukan');
                }

                RacikanDetail::create([
                    'resep_detail_id' => $resepDetailId,
                    'obatalkes_id' => $detail['obatalkes_id'],
                    'qty' => $detail['qty'],
                    'satuan' => $detail['satuan'],
                    'keterangan' => $detail['keterangan'] ?? null
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Detail racikan berhasil disimpan'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error storing racikan detail: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan detail racikan: ' . $e->getMessage()
            ], 500);
        }
    }

    // Mendapatkan list obat untuk dropdown (AJAX)
    public function getObatList(Request $request)
    {
        try {
            $query = $request->get('q', '');

            $obats = Obatalkes::where('obatalkes_nama', 'like', "%{$query}%")
                ->orWhere('obatalkes_kode', 'like', "%{$query}%")
                ->where('is_deleted', 0)
                ->where('is_active', 1)
                ->select('obatalkes_id', 'obatalkes_nama', 'obatalkes_kode', 'stok', 'satuan')
                ->limit(50)
                ->get();

            return response()->json([
                'success' => true,
                'data' => $obats
            ]);

        } catch (\Exception $e) {
            Log::error('Error getting obat list: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data obat'
            ], 500);
        }
    }
}