@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <!-- Header -->
                <div class="bg-gradient-to-r from-amber-500 to-amber-600 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <h4 class="text-xl font-semibold text-white">Edit Resep</h4>
                        <a href="{{ route('reseps.show', $resep->id) }}" 
                           class="inline-flex items-center px-3 py-1.5 bg-white bg-opacity-20 hover:bg-opacity-30 text-white text-sm font-medium rounded-md transition-colors duration-200">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Kembali
                        </a>
                    </div>
                </div>

                <div class="p-6">
                    <!-- Alert Messages -->
                    @if($errors->any())
                        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-md">
                            <ul class="list-disc list-inside">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('reseps.update', $resep->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <!-- Informasi Pasien -->
                        <div class="mb-6">
                            <div class="bg-gray-50 rounded-lg p-6">
                                <h6 class="text-lg font-semibold text-gray-800 mb-4">Informasi Pasien</h6>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="nama_pasien" class="block text-sm font-medium text-gray-700 mb-2">Nama Pasien</label>
                                        <input type="text" 
                                               id="nama_pasien" 
                                               name="nama_pasien" 
                                               value="{{ old('nama_pasien', $resep->nama_pasien) }}"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent"
                                               required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">ID Resep</label>
                                        <input type="text" 
                                               value="#{{ $resep->id }}"
                                               class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md"
                                               readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Detail Obat -->
                        <div class="mb-6">
                            <h6 class="text-lg font-semibold text-gray-800 mb-4">Detail Obat</h6>
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
                                <p class="text-yellow-800 text-sm">
                                    <strong>Perhatian:</strong> Editing detail obat akan mempengaruhi stok. Pastikan perubahan sudah sesuai.
                                </p>
                            </div>
                            
                            <div class="space-y-4">
                                @foreach($resep->details as $index => $detail)
                                    <div class="bg-white border border-gray-200 rounded-lg p-4">
                                        <div class="flex justify-between items-start mb-3">
                                            <h6 class="font-semibold text-gray-800">Item {{ $index + 1 }}</h6>
                                            @if($detail->is_racikan)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    Racikan
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    Non-Racikan
                                                </span>
                                            @endif
                                        </div>
                                        
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                            @if($detail->is_racikan)
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Racikan</label>
                                                    <input type="text" 
                                                           name="details[{{ $index }}][nama_racikan]"
                                                           value="{{ old('details.' . $index . '.nama_racikan', $detail->nama_racikan) }}"
                                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-amber-500">
                                                </div>
                                            @else
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Obat</label>
                                                    <input type="text" 
                                                           value="{{ $detail->obatalkes->obatalkes_nama ?? 'Obat tidak ditemukan' }}"
                                                           class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md"
                                                           readonly>
                                                </div>
                                            @endif
                                            
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">Quantity</label>
                                                <input type="number" 
                                                       name="details[{{ $index }}][qty]"
                                                       value="{{ old('details.' . $index . '.qty', $detail->qty) }}"
                                                       min="1"
                                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-amber-500">
                                            </div>
                                            
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">Signa</label>
                                                <input type="text" 
                                                       value="{{ $detail->signa->signa_nama ?? 'Signa tidak ditemukan' }}"
                                                       class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md"
                                                       readonly>
                                            </div>
                                        </div>
                                        
                                        <input type="hidden" name="details[{{ $index }}][id]" value="{{ $detail->id }}">
                                        <input type="hidden" name="details[{{ $index }}][is_racikan]" value="{{ $detail->is_racikan }}">
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex justify-end gap-2 space-x-3">
                            <a href="{{ route('reseps.show', $resep->id) }}" 
                               class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-md transition-colors duration-200">
                                Batal
                            </a>
                            <button type="submit" 
                                    class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white font-medium rounded-md transition-colors duration-200">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection