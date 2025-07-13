@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto mt-10">
        <form method="POST" action="{{ route('reseps.storeNonRacikan') }}">
            @csrf

            <div class="mb-4">
                <label class="block mb-1">Pilih Obat</label>
                <select name="obatalkes_id" class="w-full border rounded px-2 py-1" required>
                    <option value="">-- Pilih Obat --</option>
                    @foreach($obatalkes as $obat)
                        @php
                            $terpakai = session('stok_terpakai')[$obat->obatalkes_id] ?? 0;
                            $tersedia = $obat->stok - $terpakai;
                        @endphp
                        @if ($tersedia > 0)
                            <option value="{{ $obat->obatalkes_id }}">
                                {{ $obat->obatalkes_nama }} (Stok: {{ $tersedia }})
                            </option>
                        @endif
                    @endforeach
                </select>

            </div>

            <div class="mb-4">
                <label class="block mb-1">Qty</label>
                <input type="number" name="qty" class="w-full border rounded px-2 py-1" min="1" required>
            </div>

            <div class="mb-4">
                <label class="block mb-1">Signa</label>
                <select name="signa_id" class="w-full border rounded px-2 py-1" required>
                    <option value="">-- Pilih Signa --</option>
                    @foreach($signas as $signa)
                        <option value="{{ $signa->signa_id }}">{{ $signa->signa_nama }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-between mt-4">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Tambah ke Draft</button>
                <button type="button" onclick="closeForm()" class="bg-gray-400 text-white px-4 py-2 rounded">Batal</button>
            </div>
        </form>
    </div>
@endsection