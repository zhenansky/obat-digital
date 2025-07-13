<div class="max-w-2xl mx-auto">
    <h3 class="text-lg font-semibold mb-4">Tambah Racikan</h3>

    <form method="POST" action="{{ route('reseps.storeRacikan') }}">
        @csrf

        <div class="mb-4">
            <label class="block mb-1 font-medium text-gray-700">Nama Racikan</label>
            <input type="text" name="nama_racikan"
                class="w-full border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        </div>

        <div id="racikan-obats">
            <div class="racikan-item mb-4 border p-4 rounded-lg" data-index="0">
                <div class="flex justify-between items-center mb-3">
                    <label class="block font-medium text-gray-900">Obat #1</label>
                    <button type="button" onclick="hapusObat(0)"
                        class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600 hidden">
                        Hapus
                    </button>
                </div>

                <div class="mb-3">
                    <label class="block mb-1 text-sm font-medium text-gray-700">Pilih Obat</label>
                    <div class="searchable-select relative" data-name="obats[0][obatalkes_id]">
                        <input type="text"
                            class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Cari obat..." autocomplete="off">
                        <div
                            class="dropdown absolute z-10 w-full bg-white border rounded shadow-lg hidden searchable-dropdown">
                            @foreach($obatalkes as $obat)
                                @if($obat->stok > 0)
                                    <div class="dropdown-item px-3 py-2 cursor-pointer border-b"
                                        data-value="{{ $obat->obatalkes_id }}">
                                        {{ $obat->obatalkes_nama }} (Stok: {{ $obat->stok }})
                                    </div>
                                @endif
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
            class="bg-blue-400 text-white px-4 py-2 rounded mb-4 hover:bg-blue-500">+ Tambah Obat</button>

        <div class="mb-4">
            <label class="block mb-1 font-medium text-gray-700">Signa</label>
            <div class="searchable-select relative" data-name="signa_id">
                <input type="text"
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Cari signa..." autocomplete="off">
                <div class="dropdown absolute z-10 w-full bg-white border rounded shadow-lg hidden searchable-dropdown">
                    @foreach($signas as $signa)
                        <div class="dropdown-item px-3 py-2 cursor-pointer border-b" data-value="{{ $signa->signa_id }}">
                            {{ $signa->signa_nama }}
                        </div>
                    @endforeach
                </div>
                <input type="hidden" name="signa_id" required>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Tambah ke
                Draft</button>
        </div>
    </form>

    {{-- Template input obat, disembunyikan --}}
    <div id="template-obat" class="hidden">
        <div class="racikan-item mb-4 border p-4 rounded-lg" data-index="__INDEX__">
            <div class="flex justify-between items-center mb-3">
                <label class="block font-medium text-gray-900">Obat #__LABEL_NUMBER__</label>
                <button type="button" onclick="hapusObat(__INDEX__)"
                    class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600">
                    Hapus
                </button>
            </div>

            <div class="mb-3">
                <label class="block mb-1 text-sm font-medium text-gray-700">Pilih Obat</label>
                <div class="searchable-select relative" data-name="__NAME_OBAT__">
                    <input type="text"
                        class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Cari obat..." autocomplete="off">
                    <div
                        class="dropdown absolute z-10 w-full bg-white border rounded shadow-lg hidden searchable-dropdown">
                        @foreach($obatalkes as $obat)
                            @if($obat->stok > 0)
                                <div class="dropdown-item px-3 py-2 cursor-pointer border-b"
                                    data-value="{{ $obat->obatalkes_id }}">
                                    {{ $obat->obatalkes_nama }} (Stok: {{ $obat->stok }})
                                </div>
                            @endif
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

    <script>
        // Function untuk tambah obat di racikan
        function tambahObatRacikan() {
            console.log('tambahObatRacikan called');

            const template = document.getElementById('template-obat');
            const container = document.getElementById('racikan-obats');

            if (!template || !container) {
                console.error('Template or container not found');
                return;
            }

            const currentObatCount = document.querySelectorAll('.racikan-item').length;
            const nextIndex = currentObatCount;
            const labelNumber = currentObatCount + 1;

            const html = template.innerHTML
                .replace(/__NAME_OBAT__/g, `obats[${nextIndex}][obatalkes_id]`)
                .replace(/__NAME_QTY__/g, `obats[${nextIndex}][qty]`)
                .replace(/__INDEX__/g, nextIndex)
                .replace(/__LABEL_NUMBER__/g, labelNumber);

            container.insertAdjacentHTML('beforeend', html);

            // Initialize searchable select untuk item baru
            const newItem = container.lastElementChild;
            const newSearchableSelect = newItem.querySelector('.searchable-select');
            new SearchableSelect(newSearchableSelect);

            updateObatLabelsAndIndexes();
            updateHapusButtons();

            // Animate new item
            const newItemElement = container.lastElementChild;
            newItemElement.style.opacity = '0';
            newItemElement.style.transform = 'translateY(20px)';
            setTimeout(() => {
                newItemElement.style.transition = 'all 0.3s ease';
                newItemElement.style.opacity = '1';
                newItemElement.style.transform = 'translateY(0)';
            }, 10);
        }

        // Initialize searchable selects saat form racikan dimuat
        document.addEventListener('DOMContentLoaded', function () {
            initSearchableSelects();
        });

        // Juga dipanggil dari window.initRacikanForm
        window.initRacikanForm = function () {
            console.log('Initializing racikan form');
            setTimeout(() => {
                initSearchableSelects();
                updateObatLabelsAndIndexes();
                updateHapusButtons();
            }, 100);
        };
    </script>
</div>