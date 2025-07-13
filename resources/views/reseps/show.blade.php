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
                            <a href="{{ route('reseps.edit', $resep->id) }}" 
                               class="inline-flex items-center px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white text-sm font-medium rounded-md transition-colors duration-200">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Edit
                            </a>
                            <button type="button" 
                                    data-resep-id="{{ $resep->id }}"
                                    class="delete-resep-btn inline-flex items-center px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white text-sm font-medium rounded-md transition-colors duration-200">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Hapus
                            </button>
                            <a href="{{ route('reseps.index') }}" 
                               class="inline-flex items-center px-3 py-1.5 bg-gray-500 hover:bg-gray-600 text-white text-sm font-medium rounded-md transition-colors duration-200">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
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
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 7.172V5L8 4z"></path>
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
                                                    <div class="text-sm text-gray-900 font-medium">{{ $detail->obatalkes->obatalkes_nama ?? 'Obat tidak ditemukan' }}</div>
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
                                            <td class="px-4 py-3 text-sm text-gray-900">{{ $detail->signa->signa_nama ?? 'Signa tidak ditemukan' }}</td>
                                            <td class="px-4 py-3">
                                                @if($detail->is_racikan)
                                                    <button type="button" 
                                                            data-racikan-name="{{ $detail->nama_racikan }}"
                                                            class="racikan-detail-btn inline-flex items-center px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-600 text-sm font-medium rounded-md transition-colors duration-200">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                        </svg>
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
                                                <div class="flex flex-col items-center">
                                                    <svg class="w-12 h-12 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                    </svg>
                                                    Tidak ada detail obat
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Ringkasan -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg border border-blue-200 overflow-hidden">
                            <div class="bg-blue-500 px-6 py-4">
                                <h6 class="text-white font-semibold flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                    Ringkasan Resep
                                </h6>
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
                                <div class="flex justify-between items-center pt-2 border-t border-blue-200">
                                    <span class="text-gray-700 font-medium">Status:</span>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Selesai
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk Detail Racikan -->
    <div id="racikanDetailModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg max-w-2xl w-full mx-4 max-h-96 overflow-y-auto">
            <div class="flex justify-between items-center p-6 border-b border-gray-200">
                <h5 class="text-xl font-semibold text-gray-900">Detail Racikan</h5>
                <button type="button" onclick="closeRacikanModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
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

<script>
    // Definisikan fungsi dalam global scope
    function confirmDelete(id) {
        if (confirm('Apakah Anda yakin ingin menghapus resep ini? Stok obat akan dikembalikan.')) {
            const form = document.getElementById('deleteForm');
            form.action = `/reseps/${id}`;
            form.submit();
        }
    }

    function showRacikanDetail(namaRacikan) {
        const content = `
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <h6 class="text-lg font-semibold text-blue-800 mb-2">${namaRacikan}</h6>
                <p class="text-blue-700 mb-3">Detail komposisi racikan tidak tersedia dalam sistem saat ini.</p>
                <p class="text-sm text-blue-600">
                    <em>Catatan: Untuk menampilkan detail racikan, perlu implementasi penyimpanan komposisi racikan di database.</em>
                </p>
            </div>
        `;

        document.getElementById('racikanDetailContent').innerHTML = content;
        document.getElementById('racikanDetailModal').classList.remove('hidden');
        document.getElementById('racikanDetailModal').classList.add('flex');
    }

    function closeRacikanModal() {
        document.getElementById('racikanDetailModal').classList.add('hidden');
        document.getElementById('racikanDetailModal').classList.remove('flex');
    }

    // Jalankan setelah DOM loaded
    document.addEventListener('DOMContentLoaded', function() {
        // Event delegation untuk button racikan detail
        document.addEventListener('click', function(e) {
            if (e.target.closest('.racikan-detail-btn')) {
                const btn = e.target.closest('.racikan-detail-btn');
                const namaRacikan = btn.getAttribute('data-racikan-name');
                showRacikanDetail(namaRacikan);
            }
            
            // Handle delete button
            if (e.target.closest('.delete-resep-btn')) {
                const btn = e.target.closest('.delete-resep-btn');
                const resepId = btn.getAttribute('data-resep-id');
                confirmDelete(resepId);
            }
        });

        // Close modal when clicking outside
        const modal = document.getElementById('racikanDetailModal');
        if (modal) {
            modal.addEventListener('click', function(e) {
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