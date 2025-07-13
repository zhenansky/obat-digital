<div class="max-w-2xl mx-auto">
    <h3 class="text-lg font-semibold mb-4">Tambah Racikan</h3>

    <form method="POST" action="{{ route('reseps.storeRacikan') }}">
        @csrf

        <div class="mb-4">
            <label class="block mb-1">Nama Racikan</label>
            <input type="text" name="nama_racikan" class="w-full border px-2 py-1 rounded" required>
        </div>

        <div id="racikan-obats">
            <div class="racikan-item mb-4 border p-3 rounded" data-index="0">
                <div class="flex justify-between items-center mb-2">
                    <label class="block font-medium">Obat #1</label>
                    <button type="button" onclick="hapusObat(0)"
                        class="bg-red-500 text-white px-2 py-1 rounded text-sm hover:bg-red-600" style="display: none;">
                        Hapus
                    </button>
                </div>

                <label class="block mb-1">Pilih Obat</label>
                <select name="obats[0][obatalkes_id]" class="w-full border px-2 py-1 rounded mb-2" required>
                    <option value="">-- Pilih Obat --</option>
                    @foreach($obatalkes as $obat)
                        @if($obat->stok > 0)
                            <option value="{{ $obat->obatalkes_id }}">{{ $obat->obatalkes_nama }} (Stok: {{ $obat->stok }})
                            </option>
                        @endif
                    @endforeach
                </select>

                <label class="block mb-1">Qty</label>
                <input type="number" name="obats[0][qty]" class="w-full border px-2 py-1 rounded" min="1" required>
            </div>
        </div>

        <button type="button" onclick="tambahObat(); return false;"
            class="bg-blue-400 text-white px-3 py-1 rounded mb-4">+ Tambah Obat</button>

        <div class="mb-4">
            <label class="block mb-1">Signa</label>
            <select name="signa_id" class="w-full border px-2 py-1 rounded" required>
                <option value="">-- Pilih Signa --</option>
                @foreach($signas as $signa)
                    <option value="{{ $signa->signa_id }}">{{ $signa->signa_nama }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Tambah ke Draft</button>
        </div>
    </form>

    {{-- Template input obat, disembunyikan --}}
    <div id="template-obat" class="hidden">
        <div class="racikan-item mb-4 border p-3 rounded" data-index="__INDEX__">
            <div class="flex justify-between items-center mb-2">
                <label class="block font-medium">Obat #__LABEL_NUMBER__</label>
                <button type="button" onclick="hapusObat(__INDEX__)"
                    class="bg-red-500 text-white px-2 py-1 rounded text-sm hover:bg-red-600">
                    Hapus
                </button>
            </div>

            <label class="block mb-1">Pilih Obat</label>
            <select name="__NAME_OBAT__" class="w-full border px-2 py-1 rounded mb-2" required>
                <option value="">-- Pilih Obat --</option>
                @foreach($obatalkes as $obat)
                    @if($obat->stok > 0)
                        <option value="{{ $obat->obatalkes_id }}">{{ $obat->obatalkes_nama }} (Stok: {{ $obat->stok }})</option>
                    @endif
                @endforeach
            </select>

            <label class="block mb-1">Qty</label>
            <input type="number" name="__NAME_QTY__" class="w-full border px-2 py-1 rounded" min="1" required>
        </div>
    </div>
</div>