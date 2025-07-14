<div class="max-w-2xl mx-auto">
    <h3 class="text-lg font-semibold mb-4">Tambah Racikan</h3>

    <form method="POST" action="{{ route('reseps.storeRacikan') }}">
        @csrf

        <div class="mb-4">
            <label class="block mb-2 font-medium text-gray-700">Nama Racikan</label>
            <input type="text" name="nama_racikan"
                class="w-full border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        </div>

        <div id="racikan-obats">
            <div class="racikan-item mb-4 border p-4 rounded-lg bg-gray-50" data-index="0">
                <div class="flex justify-between items-center mb-3">
                    <label class="block font-medium text-gray-900">Obat #1</label>
                    <button type="button" onclick="hapusObat(0)"
                        class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600 hidden hapus-btn">
                        Hapus
                    </button>
                </div>

                <div class="mb-3">
                    <label class="block mb-1 text-sm font-medium text-gray-700">Pilih Obat</label>
                    <div class="searchable-select">
                        <input type="text"
                            class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Ketik untuk mencari obat..." autocomplete="off">
                        <div
                            class="dropdown absolute z-50 w-full bg-white border rounded shadow-lg hidden searchable-dropdown">
                            @foreach($obatalkes as $obat)
                                @php
                                    $isAvailable = $obat->stok > 0;
                                @endphp
                                <div class="dropdown-item px-3 py-2 border-b {{ $isAvailable ? 'cursor-pointer hover:bg-gray-50' : 'cursor-not-allowed text-gray-400 bg-gray-100 disabled' }}"
                                    data-value="{{ $obat->obatalkes_id }}"
                                    data-available="{{ $isAvailable ? 'true' : 'false' }}">
                                    {{ $obat->obatalkes_nama }}
                                    @if($isAvailable)
                                        (Stok: {{ $obat->stok }})
                                    @else
                                        (Stok: 0 - Habis)
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        <input type="hidden" name="obats[0][obatalkes_id]" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="block mb-1 text-sm font-medium text-gray-700">Qty</label>
                    <input type="number" name="obats[0][qty]"
                        class="w-full border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                        min="1" required>
                </div>
            </div>
        </div>

        <button type="button" onclick="tambahObatRacikan(); return false;"
            class="bg-blue-400 text-white px-4 py-2 rounded mb-4 hover:bg-blue-500 transition-colors">+ Tambah
            Obat</button>

        <div class="mb-4">
            <label class="block mb-2 font-medium text-gray-700">Signa</label>
            <div class="searchable-select">
                <input type="text"
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Ketik untuk mencari signa..." autocomplete="off">
                <div class="dropdown absolute z-50 w-full bg-white border rounded shadow-lg hidden searchable-dropdown">
                    @foreach($signas as $signa)
                        <div class="dropdown-item px-3 py-2 cursor-pointer border-b hover:bg-gray-50"
                            data-value="{{ $signa->signa_id }}" data-available="true">
                            {{ $signa->signa_nama }}
                        </div>
                    @endforeach
                </div>
                <input type="hidden" name="signa_id" required>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit"
                class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition-colors">
                Tambah ke Draft
            </button>
        </div>
    </form>

    {{-- Template input obat, disembunyikan --}}
    <div id="template-obat" class="hidden">
        <div class="racikan-item mb-4 border p-4 rounded-lg bg-gray-50" data-index="__INDEX__">
            <div class="flex justify-between items-center mb-3">
                <label class="block font-medium text-gray-900">Obat #__LABEL_NUMBER__</label>
                <button type="button" onclick="hapusObat(__INDEX__)"
                    class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600 hapus-btn">
                    Hapus
                </button>
            </div>

            <div class="mb-3">
                <label class="block mb-1 text-sm font-medium text-gray-700">Pilih Obat</label>
                <div class="searchable-select">
                    <input type="text"
                        class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Ketik untuk mencari obat..." autocomplete="off">
                    <div
                        class="dropdown absolute z-50 w-full bg-white border rounded shadow-lg hidden searchable-dropdown">
                        @foreach($obatalkes as $obat)
                            @php
                                $isAvailable = $obat->stok > 0;
                            @endphp
                            <div class="dropdown-item px-3 py-2 border-b {{ $isAvailable ? 'cursor-pointer hover:bg-gray-50' : 'cursor-not-allowed text-gray-400 bg-gray-100 disabled' }}"
                                data-value="{{ $obat->obatalkes_id }}"
                                data-available="{{ $isAvailable ? 'true' : 'false' }}">
                                {{ $obat->obatalkes_nama }}
                                @if($isAvailable)
                                    (Stok: {{ $obat->stok }})
                                @else
                                    (Stok: 0 - Habis)
                                @endif
                            </div>
                        @endforeach
                    </div>
                    <input type="hidden" name="__NAME_OBAT__" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="block mb-1 text-sm font-medium text-gray-700">Qty</label>
                <input type="number" name="__NAME_QTY__"
                    class="w-full border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" min="1"
                    required>
            </div>
        </div>
    </div>
</div>