@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 py-6">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Buat Resep Baru</h1>
                        <p class="text-gray-600 mt-1">Tambahkan obat racikan dan non-racikan untuk resep pasien</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('reseps.index') }}"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Kembali
                        </a>
                    </div>
                </div>
            </div>

            <!-- Alert Messages -->
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 rounded-md p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 border border-red-200 rounded-md p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Form Input Section -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-6">Tambah Obat ke Resep</h2>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-3 mb-6">
                            <button type="button" id="btn-nonracikan"
                                class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Tambah Non-Racikan
                            </button>
                            <button type="button" id="btn-racikan"
                                class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                    </path>
                                </svg>
                                Tambah Racikan
                            </button>
                        </div>

                        <!-- Dynamic Form Container -->
                        <div id="form-container"
                            class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center text-gray-500 min-h-[200px] flex items-center justify-center">
                            <div>
                                <svg class="w-12 h-12 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                <p class="text-sm">Pilih jenis obat yang ingin ditambahkan</p>
                            </div>
                        </div>

                        <!-- Loading State -->
                        <div id="loading-state" class="hidden">
                            <div class="flex items-center justify-center p-8">
                                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
                                <span class="ml-2 text-gray-600">Memuat form...</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Draft Summary Section -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-sm p-6 sticky top-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Ringkasan Resep</h3>

                        @if(session('resep_draft') && count(session('resep_draft')) > 0)
                            <div class="space-y-3 mb-6">
                                @foreach(session('resep_draft') as $index => $item)
                                    <div class="bg-gray-50 rounded-lg p-3 border border-gray-200">
                                        <div class="flex items-start justify-between">
                                            <div class="flex-1">
                                                <div class="flex items-center mb-2">
                                                    @if($item['is_racikan'])
                                                        <span
                                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                            Racikan
                                                        </span>
                                                    @else
                                                        <span
                                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                            Non-Racikan
                                                        </span>
                                                    @endif
                                                </div>
                                                <h4 class="font-medium text-gray-900 text-sm">{{ $item['nama'] }}</h4>

                                                @if($item['is_racikan'])
                                                    <ul class="mt-2 text-xs text-gray-600 space-y-1">
                                                        @foreach($item['obats'] as $obat)
                                                            <li class="flex justify-between">
                                                                <span>{{ $obat['nama'] }}</span>
                                                                <span class="font-medium">{{ $obat['qty'] }}</span>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    <p class="text-xs text-gray-600 mt-1">Qty: {{ $item['qty'] }}</p>
                                                @endif

                                                <p class="text-xs text-gray-600 mt-1">Signa: {{ $item['signa'] }}</p>
                                            </div>
                                            <button type="button" class="text-red-500 hover:text-red-700 ml-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="border-t pt-4">
                                <div class="flex items-center justify-between mb-4">
                                    <span class="text-sm font-medium text-gray-900">Total Item:</span>
                                    <span class="text-sm font-bold text-gray-900">{{ count(session('resep_draft')) }}</span>
                                </div>

                                <div class="flex flex-col gap-2">
                                    <form action="{{ route('reseps.batal') }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="w-full inline-flex justify-center items-center px-4 py-2 border border-red-300 text-sm font-medium rounded-md text-red-700 bg-red-50 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                            Batal Resep
                                        </button>
                                    </form>

                                    <button type="button" id="btn-simpan-resep"
                                        class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Simpan Resep
                                    </button>
                                </div>
                            </div>
                        @else
                            <div class="text-center text-gray-500 py-8">
                                <svg class="w-12 h-12 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                <p class="text-sm">Belum ada obat ditambahkan</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Modal Simpan Resep -->
            <div id="modal-simpan-resep"
                class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
                <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                    <div class="mt-3">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Simpan Resep</h3>
                            <button type="button" id="btn-close-modal" class="text-gray-400 hover:text-gray-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>

                        <form action="{{ route('reseps.simpan') }}" method="POST" id="form-simpan-resep">
                            @csrf
                            <div class="mb-4">
                                <label for="nama_pasien" class="block text-sm font-medium text-gray-700 mb-2">Nama
                                    Pasien</label>
                                <input type="text" name="nama_pasien" id="nama_pasien" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <div class="mb-4">
                                <label for="tanggal_resep" class="block text-sm font-medium text-gray-700 mb-2">Tanggal
                                    Resep</label>
                                <input type="date" name="tanggal_resep" id="tanggal_resep" value="{{ date('Y-m-d') }}"
                                    required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <div class="mb-6">
                                <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-2">Keterangan
                                    (Opsional)</label>
                                <textarea name="keterangan" id="keterangan" rows="3"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                            </div>

                            <div class="flex justify-end gap-3">
                                <button type="button" id="btn-batal-simpan"
                                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500">
                                    Batal
                                </button>
                                <button type="submit"
                                    class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                                    Simpan Resep
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

    <style>
        .searchable-dropdown {
            max-height: 200px;
            overflow-y: auto;
        }

        .dropdown-item:hover {
            background-color: #f3f4f6;
        }

        .dropdown-item.selected {
            background-color: #3b82f6;
            color: white;
        }
    </style>
    <script>
        class SearchableSelect {
            constructor(container) {
                this.container = container;
                this.input = container.querySelector('input[type="text"]');
                this.hiddenInput = container.querySelector('input[type="hidden"]');
                this.dropdown = container.querySelector('.dropdown');
                this.items = container.querySelectorAll('.dropdown-item');
                this.selectedIndex = -1;

                this.init();
            }

            init() {
                this.input.addEventListener('input', (e) => this.handleInput(e));
                this.input.addEventListener('focus', () => this.showDropdown());
                this.input.addEventListener('keydown', (e) => this.handleKeydown(e));

                this.items.forEach((item, index) => {
                    item.addEventListener('click', () => this.selectItem(item, index));
                });

                document.addEventListener('click', (e) => {
                    if (!this.container.contains(e.target)) {
                        this.hideDropdown();
                    }
                });
            }

            handleInput(e) {
                const query = e.target.value.toLowerCase();
                let hasVisibleItems = false;

                this.items.forEach((item, index) => {
                    const text = item.textContent.toLowerCase();
                    const isVisible = text.includes(query);

                    item.style.display = isVisible ? 'block' : 'none';
                    if (isVisible) hasVisibleItems = true;
                });

                this.selectedIndex = -1;
                this.updateSelection();

                if (hasVisibleItems) {
                    this.showDropdown();
                } else {
                    this.hideDropdown();
                }

                if (!this.findExactMatch(e.target.value)) {
                    this.hiddenInput.value = '';
                }
            }

            handleKeydown(e) {
                const visibleItems = Array.from(this.items).filter(item =>
                    item.style.display !== 'none'
                );

                switch (e.key) {
                    case 'ArrowDown':
                        e.preventDefault();
                        this.selectedIndex = Math.min(this.selectedIndex + 1, visibleItems.length - 1);
                        this.updateSelection();
                        break;

                    case 'ArrowUp':
                        e.preventDefault();
                        this.selectedIndex = Math.max(this.selectedIndex - 1, -1);
                        this.updateSelection();
                        break;

                    case 'Enter':
                        e.preventDefault();
                        if (this.selectedIndex >= 0 && visibleItems[this.selectedIndex]) {
                            this.selectItem(visibleItems[this.selectedIndex], this.selectedIndex);
                        }
                        break;

                    case 'Escape':
                        this.hideDropdown();
                        this.input.blur();
                        break;
                }
            }

            updateSelection() {
                this.items.forEach(item => item.classList.remove('selected'));

                const visibleItems = Array.from(this.items).filter(item =>
                    item.style.display !== 'none'
                );

                if (this.selectedIndex >= 0 && visibleItems[this.selectedIndex]) {
                    visibleItems[this.selectedIndex].classList.add('selected');
                }
            }

            selectItem(item, index) {
                const value = item.dataset.value;
                const text = item.textContent;

                this.input.value = text;
                this.hiddenInput.value = value;
                this.hideDropdown();

                this.hiddenInput.dispatchEvent(new Event('change'));
            }

            findExactMatch(text) {
                return Array.from(this.items).find(item =>
                    item.textContent === text
                );
            }

            showDropdown() {
                this.dropdown.classList.remove('hidden');
                this.items.forEach(item => {
                    item.style.display = 'block';
                });
            }

            hideDropdown() {
                this.dropdown.classList.add('hidden');
                this.selectedIndex = -1;
                this.items.forEach(item => item.classList.remove('selected'));
            }
        }

        // Initialize searchable selects
        function initSearchableSelects() {
            const searchableSelects = document.querySelectorAll('.searchable-select');
            searchableSelects.forEach(container => {
                new SearchableSelect(container);
            });
        }
        // Global functions untuk form racikan
        window.tambahObat = function () {
            console.log('tambahObat called');

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

            window.updateObatLabelsAndIndexes();
            window.updateHapusButtons();

            // Animate new item
            const newItem = container.lastElementChild;
            newItem.style.opacity = '0';
            newItem.style.transform = 'translateY(20px)';
            setTimeout(() => {
                newItem.style.transition = 'all 0.3s ease';
                newItem.style.opacity = '1';
                newItem.style.transform = 'translateY(0)';
            }, 10);
        };

        window.hapusObat = function (indexToDelete) {
            const items = document.querySelectorAll('.racikan-item');
            if (items.length <= 1) {
                showNotification('Minimal harus ada 1 obat dalam racikan!', 'error');
                return;
            }

            const itemToDelete = document.querySelector(`[data-index="${indexToDelete}"]`);
            if (itemToDelete) {
                // Animate removal
                itemToDelete.style.transition = 'all 0.3s ease';
                itemToDelete.style.opacity = '0';
                itemToDelete.style.transform = 'translateY(-20px)';

                setTimeout(() => {
                    itemToDelete.remove();
                    window.updateObatLabelsAndIndexes();
                    window.updateHapusButtons();
                }, 300);
            }
        };

        window.updateHapusButtons = function () {
            const items = document.querySelectorAll('.racikan-item');
            const hapusButtons = document.querySelectorAll('.racikan-item button[onclick*="hapusObat"]');

            hapusButtons.forEach(button => {
                button.style.display = items.length > 1 ? 'inline-flex' : 'none';
            });
        };

        window.updateObatLabelsAndIndexes = function () {
            const items = document.querySelectorAll('.racikan-item');
            items.forEach((item, index) => {
                const label = item.querySelector('label.font-medium');
                if (label) {
                    label.textContent = `Obat #${index + 1}`;
                }

                const selectObat = item.querySelector('select[name*="obatalkes_id"]');
                const inputQty = item.querySelector('input[name*="qty"]');

                if (selectObat) selectObat.name = `obats[${index}][obatalkes_id]`;
                if (inputQty) inputQty.name = `obats[${index}][qty]`;

                item.setAttribute('data-index', index);

                const hapusButton = item.querySelector('button[onclick*="hapusObat"]');
                if (hapusButton) {
                    hapusButton.setAttribute('onclick', `hapusObat(${index})`);
                }
            });
        };

        window.initRacikanForm = function () {
            console.log('Initializing racikan form');
            window.updateObatLabelsAndIndexes();
            window.updateHapusButtons();
        };

        // Notification system
        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg transform transition-all duration-300 translate-x-full ${type === 'error' ? 'bg-red-50 text-red-800 border border-red-200' :
                type === 'success' ? 'bg-green-50 text-green-800 border border-green-200' :
                    'bg-blue-50 text-blue-800 border border-blue-200'
                }`;

            notification.innerHTML = `
                            <div class="flex items-center">
                                <span class="flex-1">${message}</span>
                                <button onclick="this.parentElement.parentElement.remove()" class="ml-2 text-gray-500 hover:text-gray-700">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        `;

            document.body.appendChild(notification);

            setTimeout(() => {
                notification.style.transform = 'translateX(0)';
            }, 100);

            setTimeout(() => {
                notification.style.transform = 'translateX(full)';
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }

        // Enhanced form loading
        function loadForm(url, buttonEl) {
            const container = document.getElementById('form-container');
            const loadingState = document.getElementById('loading-state');

            container.style.display = 'none';
            loadingState.classList.remove('hidden');

            buttonEl.disabled = true;
            buttonEl.querySelector('svg').classList.add('animate-spin');

            fetch(url)
                .then(res => {
                    if (!res.ok) throw new Error('Network response was not ok');
                    return res.text();
                })
                .then(html => {
                    container.innerHTML = html;
                    container.style.display = 'block';
                    loadingState.classList.add('hidden');

                    container.style.opacity = '0';
                    setTimeout(() => {
                        container.style.transition = 'opacity 0.3s ease';
                        container.style.opacity = '1';
                    }, 10);

                    // Initialize searchable selects untuk form yang baru dimuat
                    setTimeout(() => {
                        initSearchableSelects();
                        if (url.includes('racikan')) {
                            window.initRacikanForm();
                        }
                    }, 100);
                })
                .catch(error => {
                    console.error('Error:', error);
                    container.innerHTML = `
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-red-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-red-800">Error loading form. Please try again.</span>
                        </div>
                    </div>
                `;
                    container.style.display = 'block';
                    loadingState.classList.add('hidden');
                })
                .finally(() => {
                    buttonEl.disabled = false;
                    buttonEl.querySelector('svg').classList.remove('animate-spin');
                });
        }

        document.addEventListener('DOMContentLoaded', function () {
            const container = document.getElementById('form-container');
            const btnNonRacikan = document.getElementById('btn-nonracikan');
            const btnRacikan = document.getElementById('btn-racikan');
            const btnSimpanResep = document.getElementById('btn-simpan-resep');
            const modal = document.getElementById('modal-simpan-resep');
            const btnCloseModal = document.getElementById('btn-close-modal');
            const btnBatalSimpan = document.getElementById('btn-batal-simpan');

            // Enhanced button event listeners
            btnNonRacikan?.addEventListener('click', function (e) {
                e.preventDefault();
                loadForm('/reseps/form/nonracikan', this);
            });

            btnRacikan?.addEventListener('click', function (e) {
                e.preventDefault();
                loadForm('/reseps/form/racikan', this);
            });

            // Modal functionality
            btnSimpanResep?.addEventListener('click', function (e) {
                e.preventDefault();
                modal.classList.remove('hidden');
                document.getElementById('nama_pasien').focus();
            });

            btnCloseModal?.addEventListener('click', function () {
                modal.classList.add('hidden');
            });

            btnBatalSimpan?.addEventListener('click', function () {
                modal.classList.add('hidden');
            });

            // Close modal on outside click
            modal?.addEventListener('click', function (e) {
                if (e.target === modal) {
                    modal.classList.add('hidden');
                }
            });

            // Enhanced form validation
            const formSimpanResep = document.getElementById('form-simpan-resep');
            formSimpanResep?.addEventListener('submit', function (e) {
                const namaPasien = document.getElementById('nama_pasien').value.trim();
                if (!namaPasien) {
                    e.preventDefault();
                    showNotification('Nama pasien harus diisi!', 'error');
                    document.getElementById('nama_pasien').focus();
                    return;
                }

                // Show loading on submit button
                const submitBtn = this.querySelector('button[type="submit"]');
                submitBtn.disabled = true;
                submitBtn.innerHTML = `
                                <svg class="animate-spin -ml-1 mr-3 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Menyimpan...
                            `;
            });

            // Auto-save draft functionality (optional)
            let saveTimer;
            function autoSaveDraft() {
                clearTimeout(saveTimer);
                saveTimer = setTimeout(() => {
                    // Implementation for auto-save if needed
                }, 2000);
            }

            // Keyboard shortcuts
            document.addEventListener('keydown', function (e) {
                if (e.ctrlKey || e.metaKey) {
                    switch (e.key) {
                        case '1':
                            e.preventDefault();
                            btnNonRacikan.click();
                            break;
                        case '2':
                            e.preventDefault();
                            btnRacikan.click();
                            break;
                        case 's':
                            e.preventDefault();
                            btnSimpanResep?.click();
                            break;
                        case 'Escape':
                            modal.classList.add('hidden');
                            break;
                    }
                }
            });

            // Initialize tooltips or additional UI enhancements
            initializeTooltips();

            // Form validation enhancements
            addFormValidation();
        });

        // Additional utility functions
        function initializeTooltips() {
            // Add tooltip functionality if needed
            const tooltipElements = document.querySelectorAll('[data-tooltip]');
            tooltipElements.forEach(element => {
                element.addEventListener('mouseenter', showTooltip);
                element.addEventListener('mouseleave', hideTooltip);
            });
        }

        function showTooltip(e) {
            const tooltip = document.createElement('div');
            tooltip.className = 'absolute z-50 px-2 py-1 text-sm text-white bg-gray-800 rounded shadow-lg';
            tooltip.textContent = e.target.getAttribute('data-tooltip');
            document.body.appendChild(tooltip);

            const rect = e.target.getBoundingClientRect();
            tooltip.style.left = rect.left + 'px';
            tooltip.style.top = (rect.top - tooltip.offsetHeight - 5) + 'px';

            e.target._tooltip = tooltip;
        }

        function hideTooltip(e) {
            if (e.target._tooltip) {
                e.target._tooltip.remove();
                delete e.target._tooltip;
            }
        }

        function addFormValidation() {
            // Add real-time validation for form fields
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                const inputs = form.querySelectorAll('input, select, textarea');
                inputs.forEach(input => {
                    input.addEventListener('blur', validateField);
                    input.addEventListener('input', clearFieldError);
                });
            });
        }

        function validateField(e) {
            const field = e.target;
            const value = field.value.trim();

            // Remove existing error styling
            field.classList.remove('border-red-500', 'focus:ring-red-500');
            const existingError = field.parentNode.querySelector('.text-red-500');
            if (existingError) existingError.remove();

            let isValid = true;
            let errorMessage = '';

            // Field-specific validation
            if (field.hasAttribute('required') && !value) {
                isValid = false;
                errorMessage = 'Field ini wajib diisi';
            } else if (field.type === 'number' && value && (isNaN(value) || parseInt(value) <= 0)) {
                isValid = false;
                errorMessage = 'Masukkan angka yang valid';
            } else if (field.name === 'nama_pasien' && value && value.length < 2) {
                isValid = false;
                errorMessage = 'Nama pasien minimal 2 karakter';
            }

            if (!isValid) {
                field.classList.add('border-red-500', 'focus:ring-red-500');
                const error = document.createElement('p');
                error.className = 'text-red-500 text-xs mt-1';
                error.textContent = errorMessage;
                field.parentNode.appendChild(error);
            }

            return isValid;
        }

        function clearFieldError(e) {
            const field = e.target;
            if (field.classList.contains('border-red-500')) {
                field.classList.remove('border-red-500', 'focus:ring-red-500');
                const error = field.parentNode.querySelector('.text-red-500');
                if (error) error.remove();
            }
        }

        // Enhanced search functionality for select fields
        function enhanceSelectFields() {
            const selectFields = document.querySelectorAll('select[data-searchable]');
            selectFields.forEach(select => {
                // Convert to searchable dropdown
                createSearchableDropdown(select);
            });
        }

        function createSearchableDropdown(select) {
            const wrapper = document.createElement('div');
            wrapper.className = 'relative';

            const searchInput = document.createElement('input');
            searchInput.type = 'text';
            searchInput.className = select.className;
            searchInput.placeholder = 'Cari obat...';

            const dropdown = document.createElement('div');
            dropdown.className = 'absolute z-10 w-full bg-white border border-gray-300 rounded-md shadow-lg max-h-60 overflow-y-auto hidden';

            // Populate dropdown with options
            Array.from(select.options).forEach(option => {
                if (option.value) {
                    const item = document.createElement('div');
                    item.className = 'px-3 py-2 hover:bg-gray-100 cursor-pointer';
                    item.textContent = option.textContent;
                    item.addEventListener('click', () => {
                        select.value = option.value;
                        searchInput.value = option.textContent;
                        dropdown.classList.add('hidden');
                        select.dispatchEvent(new Event('change'));
                    });
                    dropdown.appendChild(item);
                }
            });

            searchInput.addEventListener('input', (e) => {
                const query = e.target.value.toLowerCase();
                const items = dropdown.querySelectorAll('div');
                let hasVisible = false;

                items.forEach(item => {
                    const text = item.textContent.toLowerCase();
                    if (text.includes(query)) {
                        item.style.display = 'block';
                        hasVisible = true;
                    } else {
                        item.style.display = 'none';
                    }
                });

                dropdown.classList.toggle('hidden', !hasVisible);
            });

            searchInput.addEventListener('focus', () => {
                dropdown.classList.remove('hidden');
            });

            document.addEventListener('click', (e) => {
                if (!wrapper.contains(e.target)) {
                    dropdown.classList.add('hidden');
                }
            });

            select.style.display = 'none';
            select.parentNode.insertBefore(wrapper, select);
            wrapper.appendChild(searchInput);
            wrapper.appendChild(dropdown);
            wrapper.appendChild(select);
        }

        // Progress indicator for multi-step forms
        function showProgress(currentStep, totalSteps) {
            const progressBar = document.getElementById('progress-bar');
            if (progressBar) {
                const percentage = (currentStep / totalSteps) * 100;
                progressBar.style.width = percentage + '%';
            }
        }

        // Data persistence in session storage alternative (using variables)
        let formData = {
            draft: [],
            currentForm: null,
            patientName: '',
            notes: ''
        };

        function saveDraftToMemory(data) {
            formData.draft = data;
        }

        function loadDraftFromMemory() {
            return formData.draft;
        }

        // Export functionality for printing
        function printResep() {
            const printContent = document.getElementById('resep-summary').innerHTML;
            const printWindow = window.open('', '_blank');
            printWindow.document.write(`
                            <html>
                                <head>
                                    <title>Resep Obat</title>
                                    <style>
                                        body { font-family: Arial, sans-serif; margin: 20px; }
                                        .header { text-align: center; margin-bottom: 30px; }
                                        .content { margin-bottom: 20px; }
                                        table { width: 100%; border-collapse: collapse; }
                                        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                                        th { background-color: #f2f2f2; }
                                        @media print { .no-print { display: none; } }
                                    </style>
                                </head>
                                <body>
                                    <div class="header">
                                        <h1>RESEP OBAT</h1>
                                        <p>Tanggal: ${new Date().toLocaleDateString('id-ID')}</p>
                                    </div>
                                    <div class="content">
                                        ${printContent}
                                    </div>
                                </body>
                            </html>
                        `);
            printWindow.document.close();
            printWindow.print();
        }
    </script>
@endsection