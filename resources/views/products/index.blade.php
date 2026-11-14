<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tabel Item</title>
    @vite(['resources/css/app.css'])
</head>
<body class="p-4">
    @php $isUpdateError = $errors->hasBag('update'); @endphp

    <h1 class="text-2xl font-bold">Tabel Item MyFlorist</h1>

    <button type="button" onclick="openModal()"
        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-full my-4">
        + Tambah Item
    </button>

    @if (session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <table class="w-full border-collapse border border-gray-300">
        <thead class="bg-gray-200">
            <tr>
                <th class="p-2 border border-gray-300">Nama Item</th>
                <th class="p-2 border border-gray-300">Harga</th>
                <th class="p-2 border border-gray-300">Stok</th>
                <th class="p-2 border border-gray-300">Deskripsi</th>
                <th class="p-2 border border-gray-300">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $p)
                <tr class="text-center">
                    <td class="p-2 border border-gray-300">{{ $p->nama_item }}</td>
                    <td class="p-2 border border-gray-300">Rp {{ number_format($p->harga, 0, ',', '.') }}</td>
                    <td class="p-2 border border-gray-300">{{ $p->stok }}</td>
                    <td class="p-2 border border-gray-300">{{ $p->deskripsi }}</td>
                    <td class="p-2 border border-gray-300">
                        <div class="flex items-center justify-center gap-2">

                            {{-- Tombol Edit (ikon pensil) --}}
                            <button type="button" title="Edit"
                                onclick="openEditModal({{ $p->id }}, @js($p->nama_item), {{ $p->harga }}, {{ $p->stok }}, @js($p->deskripsi))"
                                class="bg-yellow-500 hover:bg-yellow-600 text-white p-2 rounded">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                </svg>
                            </button>

                            {{-- Tombol Hapus (ikon tempat sampah) --}}
                            <form action="/products/{{ $p->id }}" method="POST"
                                onsubmit="return confirm('Hapus produk ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" title="Hapus"
                                    class="bg-red-500 hover:bg-red-600 text-white p-2 rounded">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                    </svg>
                                </button>
                            </form>

                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="p-4 text-center text-gray-500 border border-gray-300">
                        Belum ada item.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- ===================== MODAL TAMBAH ===================== --}}
    <div id="modal" class="hidden fixed inset-0 bg-black/50 items-center justify-center p-4">
        <div class="bg-white rounded-xl p-6 w-full max-w-md">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h2 class="text-lg font-bold">Tambah Item</h2>
                    <p class="text-sm text-gray-500">Masukkan informasi produk baru.</p>
                </div>
                <button type="button" onclick="closeModal()" class="text-gray-400 text-2xl leading-none">&times;</button>
            </div>

            @if (!$isUpdateError && $errors->any())
                <div class="bg-red-100 text-red-800 p-2 rounded mb-3 text-sm">
                    Data belum lengkap atau salah. Periksa lagi isian kamu.
                </div>
            @endif

            <form action="/products" method="POST" class="space-y-3">
                @csrf
                <div>
                    <label class="block text-sm font-medium">Nama Produk</label>
                    <input type="text" name="nama_item"
                        value="{{ $isUpdateError ? '' : old('nama_item') }}"
                        placeholder="Masukkan nama produk" class="border border-gray-300 p-2 w-full rounded">
                    @if (!$isUpdateError) @error('nama_item') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror @endif
                </div>

                <div>
                    <label class="block text-sm font-medium">Harga</label>
                    <input type="number" name="harga" min="0"
                        value="{{ $isUpdateError ? '' : old('harga') }}"
                        placeholder="Masukkan harga" class="border border-gray-300 p-2 w-full rounded">
                    @if (!$isUpdateError) @error('harga') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror @endif
                </div>

                <div>
                    <label class="block text-sm font-medium">Stok</label>
                    <input type="number" name="stok" min="0"
                        value="{{ $isUpdateError ? '' : old('stok') }}"
                        placeholder="Masukkan jumlah stok" class="border border-gray-300 p-2 w-full rounded">
                    @if (!$isUpdateError) @error('stok') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror @endif
                </div>

                <div>
                    <label class="block text-sm font-medium">Deskripsi</label>
                    <textarea name="deskripsi" placeholder="Masukkan deskripsi produk"
                        class="border border-gray-300 p-2 w-full rounded">{{ $isUpdateError ? '' : old('deskripsi') }}</textarea>
                </div>

                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" onclick="closeModal()" class="bg-gray-200 px-4 py-2 rounded">Batal</button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan Item</button>
                </div>
            </form>
        </div>
    </div>

    {{-- ===================== MODAL EDIT ===================== --}}
    <div id="editModal" class="hidden fixed inset-0 bg-black/50 items-center justify-center p-4">
        <div class="bg-white rounded-xl p-6 w-full max-w-md">
            <div class="flex justify-between items-start mb-4">
                <h2 class="text-lg font-bold">Edit Item</h2>
                <button type="button" onclick="closeEditModal()" class="text-gray-400 text-2xl leading-none">&times;</button>
            </div>

            @if ($isUpdateError)
                <div class="bg-red-100 text-red-800 p-2 rounded mb-3 text-sm">
                    Data belum lengkap atau salah. Periksa lagi isian kamu.
                </div>
            @endif

            <form id="editForm" method="POST" class="space-y-3">
                @csrf
                @method('PUT')
                <input type="hidden" name="edit_id" id="edit_id">

                <div>
                    <label class="block text-sm font-medium">Nama Produk</label>
                    <input type="text" name="nama_item" id="edit_nama" class="border border-gray-300 p-2 w-full rounded">
                    @if ($isUpdateError && $errors->update->has('nama_item'))
                        <p class="text-red-500 text-xs mt-1">{{ $errors->update->first('nama_item') }}</p>
                    @endif
                </div>

                <div>
                    <label class="block text-sm font-medium">Harga</label>
                    <input type="number" name="harga" id="edit_harga" min="0" class="border border-gray-300 p-2 w-full rounded">
                    @if ($isUpdateError && $errors->update->has('harga'))
                        <p class="text-red-500 text-xs mt-1">{{ $errors->update->first('harga') }}</p>
                    @endif
                </div>

                <div>
                    <label class="block text-sm font-medium">Stok</label>
                    <input type="number" name="stok" id="edit_stok" min="0" class="border border-gray-300 p-2 w-full rounded">
                    @if ($isUpdateError && $errors->update->has('stok'))
                        <p class="text-red-500 text-xs mt-1">{{ $errors->update->first('stok') }}</p>
                    @endif
                </div>

                <div>
                    <label class="block text-sm font-medium">Deskripsi</label>
                    <textarea name="deskripsi" id="edit_deskripsi" class="border border-gray-300 p-2 w-full rounded"></textarea>
                </div>

                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" onclick="closeEditModal()" class="bg-gray-200 px-4 py-2 rounded">Batal</button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const modal = document.getElementById('modal');
        const editModal = document.getElementById('editModal');

        function openModal() {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
        function closeModal() {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function openEditModal(id, nama, harga, stok, deskripsi) {
            document.getElementById('editForm').action = '/products/' + id;
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_nama').value = nama ?? '';
            document.getElementById('edit_harga').value = harga ?? '';
            document.getElementById('edit_stok').value = stok ?? '';
            document.getElementById('edit_deskripsi').value = deskripsi ?? '';
            editModal.classList.remove('hidden');
            editModal.classList.add('flex');
        }
        function closeEditModal() {
            editModal.classList.add('hidden');
            editModal.classList.remove('flex');
        }

        @if ($isUpdateError)
            openEditModal(
                {{ (int) old('edit_id') }},
                @js(old('nama_item')),
                @js(old('harga')),
                @js(old('stok')),
                @js(old('deskripsi'))
            );
        @elseif ($errors->any())
            openModal();
        @endif
    </script>
</body>
</html>