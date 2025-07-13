@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="max-w-6xl mx-auto">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <!-- Header -->
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                        <h4 class="text-xl font-semibold text-white mb-3 sm:mb-0">Detail Resep</h4>
                        <div class="flex flex-wrap gap-2">
                            <button type="button" data-resep-id="{{ $resep->id }}"
                                class="delete-resep-btn inline-flex items-center px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white text-sm font-medium rounded-md transition-colors duration-200">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                    </path>
                                </svg>
                                Hapus
                            </button>
                            <a href="{{ route('reseps.index') }}"
                                class="inline-flex items-center px-3 py-1.5 bg-gray-500 hover:bg-gray-600 text-white text-sm font-medium rounded-md transition-colors duration-200">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                Kembali
                            </a>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <!-- Alert Messages -->
                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-md">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-md">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Informasi Pasien -->
                    <div class="mb-8">
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h6 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Informasi Pasien
                            </h6>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="space-y-3">
                                    <div class="flex">
                                        <span class="w-32 text-gray-600 font-medium">Nama Pasien</span>
                                        <span class="text-gray-800">: {{ $resep->nama_pasien }}</span>
                                    </div>
                                    <div class="flex">
                                        <span class="w-32 text-gray-600 font-medium">Tanggal Resep</span>
                                        <span class="text-gray-800">: {{ $resep->created_at->format('d/m/Y H:i') }}</span>
                                    </div>
                                    <div class="flex">
                                        <span class="w-32 text-gray-600 font-medium">ID Resep</span>
                                        <span class="text-gray-800">: #{{ $resep->id }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Detail Obat -->
                    <div class="mb-8">
                        <h6 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 7.172V5L8 4z">
                                </path>
                            </svg>
                            Detail Obat
                        </h6>
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-gray-200 rounded-lg overflow-hidden">
                                <thead class="bg-gray-50 border-b border-gray-200">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama Obat/Racikan</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Jenis</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Qty</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Signa</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Detail Racikan</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @forelse($resep->details as $index => $detail)
                                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                                            <td class="px-4 py-3 text-sm text-gray-900">{{ $index + 1 }}</td>
                                            <td class="px-4 py-3">
                                                @if($detail->is_racikan)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mb-2">
                                                        Racikan
                                                    </span>
                                                    <div class="text-sm text-gray-900 font-medium">{{ $detail->nama_racikan }}</div>
                                                @else
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 mb-2">
                                                        Non-Racikan
                                                    </span>
                                                    <div class="text-sm text-gray-900 font-medium">
                                                        {{ $detail->obatalkes->obatalkes_nama ?? 'Obat tidak ditemukan' }}
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="px-4 py-3">
                                                @if($detail->is_racikan)
                                                    <span class="text-sm text-blue-600 font-medium">Racikan</span>
                                                @else
                                                    <span class="text-sm text-green-600 font-medium">Obat Tunggal</span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-3 text-sm text-gray-900">{{ $detail->qty }}</td>
                                            <td class="px-4 py-3 text-sm text-gray-900">
                                                {{ $detail->signa->signa_nama ?? 'Signa tidak ditemukan' }}
                                            </td>
                                            <td class="px-4 py-3">
                                                @if($detail->is_racikan)
                                                    <button type="button" data-detail-id="{{ $detail->id }}"
                                                        data-racikan-name="{{ $detail->nama_racikan }}"
                                                        class="racikan-detail-btn px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-600 text-sm font-medium rounded-md transition-colors duration-200">
                                                        Lihat Detail
                                                    </button>
                                                @else
                                                    <span class="text-sm text-gray-400">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                                                Tidak ada detail obat
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Ringkasan -->
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg border border-blue-200 overflow-hidden">
                        <div class="bg-blue-500 px-6 py-4">
                            <h6 class="text-white font-semibold">Ringkasan Resep</h6>
                        </div>
                        <div class="p-6 space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-700 font-medium">Total Item:</span>
                                <span class="text-gray-900 font-semibold">{{ $resep->details->count() }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-700 font-medium">Jumlah Racikan:</span>
                                <span class="text-blue-600 font-semibold">{{ $resep->details->where('is_racikan', true)->count() }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-700 font-medium">Jumlah Non-Racikan:</span>
                                <span class="text-green-600 font-semibold">{{ $resep->details->where('is_racikan', false)->count() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk Detail Racikan -->
    <div id="racikanDetailModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg max-w-4xl w-full mx-4 max-h-[80vh] overflow-y-auto">
            <div class="flex justify-between items-center p-6 border-b border-gray-200">
                <h5 class="text-xl font-semibold text-gray-900" id="racikanModalTitle">Detail Racikan</h5>
                <button type="button" onclick="closeRacikanModal()" class="text-gray-400 hover:text-gray-600">
                    ✕
                </button>
            </div>
            <div class="p-6">
                <div id="racikanDetailContent">
                    <!-- Konten detail racikan akan diisi oleh JavaScript -->
                </div>
            </div>
        </div>
    </div>

    <!-- Form untuk hapus resep -->
    <form id="deleteForm" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>
@endsection

@section('scripts')
    <script>
    function confirmDelete(id) {
        if (confirm('Yakin hapus resep ini? Stok obat akan dikembalikan.')) {
            document.getElementById('deleteForm').action = `/reseps/${id}`;
            document.getElementById('deleteForm').submit();
        }
    }

    async function showRacikanDetail(detailId, namaRacikan) {
        try {
            showLoading('racikanDetailContent');
            document.getElementById('racikanModalTitle').textContent = `Detail Racikan: ${namaRacikan}`;
            document.getElementById('racikanDetailModal').classList.remove('hidden');
            document.getElementById('racikanDetailModal').classList.add('flex');

            const response = await fetch(`/racikan/detail/${detailId}`);
            const result = await response.json();

            if (result.success) {
                const data = result.data;
                let content = `
                    <div class="mb-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div><span class="text-sm font-medium text-blue-700">Nama Racikan:</span>
                                <div class="text-blue-900 font-semibold">${data.nama_racikan}</div></div>
                            <div><span class="text-sm font-medium text-blue-700">Quantity:</span>
                                <div class="text-blue-900 font-semibold">${data.qty_racikan}</div></div>
                            <div><span class="text-sm font-medium text-blue-700">Signa:</span>
                                <div class="text-blue-900 font-semibold">${data.signa}</div></div>
                        </div>
                    </div>
                `;

                if (data.details && data.details.length > 0) {
                    content += `
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">No</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Kode</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Nama Obat</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Qty</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Satuan</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Stok</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                    `;

                    data.details.forEach((detail, index) => {
                        const stokStatus = detail.stok_tersedia > 0 ? 'text-green-600' : 'text-red-600';
                        content += `
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-sm">${index + 1}</td>
                                <td class="px-4 py-3 text-sm font-mono">${detail.obat_kode}</td>
                                <td class="px-4 py-3 text-sm font-medium">${detail.obat_nama}</td>
                                <td class="px-4 py-3 text-sm">${detail.qty}</td>
                                <td class="px-4 py-3 text-sm">${detail.satuan}</td>
                                <td class="px-4 py-3 text-sm ${stokStatus} font-medium">${detail.stok_tersedia}</td>
                                <td class="px-4 py-3 text-sm">${detail.keterangan || '-'}</td>
                            </tr>
                        `;
                    });

                    content += `
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4 bg-gray-50 rounded-lg p-4">
                            <strong>Total obat dalam racikan:</strong> ${data.total_obat} jenis obat
                        </div>
                    `;
                } else {
                    content += '<div class="text-center py-8 text-gray-500">Belum ada detail obat dalam racikan ini</div>';
                }

                document.getElementById('racikanDetailContent').innerHTML = content;
            } else {
                showError('racikanDetailContent', result.message);
            }
        } catch (error) {
            showError('racikanDetailContent', 'Terjadi kesalahan saat mengambil data racikan');
        }
    }

    function closeRacikanModal() {
        document.getElementById('racikanDetailModal').classList.add('hidden');
        document.getElementById('racikanDetailModal').classList.remove('flex');
    }

    function showLoading(containerId) {
        document.getElementById(containerId).innerHTML = '<div class="text-center py-8">Memuat data...</div>';
    }

    function showError(containerId, message) {
        document.getElementById(containerId).innerHTML = `<div class="text-center py-8 text-red-500">${message}</div>`;
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Event delegation untuk button racikan detail
        document.addEventListener('click', function(e) {
            if (e.target.closest('.racikan-detail-btn')) {
                const btn = e.target.closest('.racikan-detail-btn');
                const detailId = btn.getAttribute('data-detail-id');
                const namaRacikan = btn.getAttribute('data-racikan-name');
                showRacikanDetail(detailId, namaRacikan);
            }

            if (e.target.closest('.delete-resep-btn')) {
                const btn = e.target.closest('.delete-resep-btn');
                const resepId = btn.getAttribute('data-resep-id');
                confirmDelete(resepId);
            }
        });

        // Close modal when clicking outside
        const detailModal = document.getElementById('racikanDetailModal');
        if (detailModal) {
            detailModal.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeRacikanModal();
                }
            });
        }

        // Close modal dengan ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeRacikanModal();
            }
        });
    });
    </script>
@endsection