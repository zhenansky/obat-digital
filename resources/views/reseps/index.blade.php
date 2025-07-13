@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto mt-10">
        <div class="mb-6">
            <h2 class="text-2xl font-bold mb-4">Daftar Resep Tersimpan</h2>
            <a href="{{ route('reseps.create') }}"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                <i class="fas fa-plus"></i> Tambah Resep
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4 border border-green-300">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 text-red-800 p-3 rounded mb-4 border border-red-300">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif

        @if ($reseps->count())
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="table-auto w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama
                                Pasien</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah
                                Item</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($reseps as $index => $resep)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $index + 1 }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $resep->nama_pasien }}</div>
                                    <div class="text-sm text-gray-500">ID: #{{ $resep->id }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $resep->details->count() }} item</div>
                                    <div class="text-sm text-gray-500">
                                        {{ $resep->details->where('is_racikan', true)->count() }} racikan,
                                        {{ $resep->details->where('is_racikan', false)->count() }} non-racikan
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $resep->created_at->format('d/m/Y') }}
                                    <br>
                                    <span class="text-gray-500 text-xs">{{ $resep->created_at->format('H:i') }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('reseps.show', $resep->id) }}"
                                            class="bg-blue-500 text-white px-3 py-1 rounded text-xs hover:bg-blue-600 transition">
                                            <i class="fas fa-eye"></i> Detail
                                        </a>
                                        <a href="{{ route('reseps.edit', $resep->id) }}"
                                            class="bg-yellow-500 text-white px-3 py-1 rounded text-xs hover:bg-yellow-600 transition">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <button type="button" onclick="confirmDelete({{ $resep->id }})"
                                            class="bg-red-500 text-white px-3 py-1 rounded text-xs hover:bg-red-600 transition">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="bg-white rounded-lg shadow p-8 text-center">
                <div class="text-gray-400 text-6xl mb-4">
                    <i class="fas fa-prescription-bottle-alt"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada resep</h3>
                <p class="text-gray-500 mb-4">Mulai dengan membuat resep pertama Anda.</p>
                <a href="{{ route('reseps.create') }}"
                    class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
                    <i class="fas fa-plus"></i> Buat Resep
                </a>
            </div>
        @endif
    </div>

    <!-- Form untuk hapus resep -->
    <form id="deleteForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    <!-- Modal Konfirmasi Hapus -->
    <div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                    <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mt-5">Hapus Resep?</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500">
                        Apakah Anda yakin ingin menghapus resep ini?
                        Stok obat akan dikembalikan dan tindakan ini tidak dapat dibatalkan.
                    </p>
                </div>
                <div class="items-center px-4 py-3">
                    <button id="confirmDelete"
                        class="px-4 py-2 bg-red-500 text-white text-base font-medium rounded-md w-24 hover:bg-red-600 transition mr-2">
                        Hapus
                    </button>
                    <button id="cancelDelete"
                        class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-24 hover:bg-gray-600 transition">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let deleteId = null;

        function confirmDelete(id) {
            deleteId = id;
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        document.getElementById('confirmDelete').addEventListener('click', function () {
            if (deleteId) {
                const form = document.getElementById('deleteForm');
                form.action = `/reseps/${deleteId}`;
                form.submit();
            }
        });

        document.getElementById('cancelDelete').addEventListener('click', function () {
            document.getElementById('deleteModal').classList.add('hidden');
            deleteId = null;
        });

        // Tutup modal jika diklik di luar
        document.getElementById('deleteModal').addEventListener('click', function (e) {
            if (e.target === this) {
                this.classList.add('hidden');
                deleteId = null;
            }
        });
    </script>
@endsection