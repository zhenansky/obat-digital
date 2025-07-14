@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto mt-10">
        <form method="POST" action="{{ route('reseps.storeNonRacikan') }}">
            @csrf

            <div class="mb-4">
                <label class="block mb-2 font-medium text-gray-700">Pilih Obat</label>
                <div class="searchable-select">
                    <input type="text"
                        class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Ketik untuk mencari obat..." autocomplete="off">
                    <div class="dropdown absolute z-50 w-full bg-white border rounded shadow-lg hidden searchable-dropdown">
                        @foreach($obatalkes as $obat)
                            @php
                                $terpakai = session('stok_terpakai')[$obat->obatalkes_id] ?? 0;
                                $tersedia = $obat->stok - $terpakai;
                                $isAvailable = $tersedia > 0;
                            @endphp
                            <div class="dropdown-item px-3 py-2 border-b {{ $isAvailable ? 'cursor-pointer hover:bg-gray-50' : 'cursor-not-allowed text-gray-400 bg-gray-100 disabled' }}"
                                data-value="{{ $obat->obatalkes_id }}" data-available="{{ $isAvailable ? 'true' : 'false' }}">
                                {{ $obat->obatalkes_nama }}
                                @if($isAvailable)
                                    (Stok: {{ $tersedia }})
                                @else
                                    (Stok: 0 - Habis)
                                @endif
                            </div>
                        @endforeach
                    </div>
                    <input type="hidden" name="obatalkes_id" required>
                </div>
            </div>

            <div class="mb-4">
                <label class="block mb-2 font-medium text-gray-700">Qty</label>
                <input type="number" name="qty"
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" min="1"
                    required>
            </div>

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

            <div class="flex justify-between mt-6">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition-colors">
                    Tambah ke Draft
                </button>
                <button type="button" onclick="closeForm()"
                    class="bg-gray-400 text-white px-6 py-2 rounded hover:bg-gray-500 transition-colors">
                    Batal
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            console.log('DOM loaded, initializing searchable selects');
            initSearchableSelects();
        });

        function closeForm() {
            const container = document.getElementById('form-container');
            container.innerHTML = `
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center text-gray-500 min-h-[200px] flex items-center justify-center">
                        <div>
                            <svg class="w-12 h-12 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <p class="text-sm">Pilih jenis obat yang ingin ditambahkan</p>
                        </div>
                    </div>
                `;
        }
    </script>
@endsection