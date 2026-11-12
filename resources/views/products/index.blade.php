<!DOCTYPE html>
<html>
<head>
    <title>Tabel Item</title>
    @vite(['resources/css/app.css'])
</head>
<body>
    <h1 class="text-2xl font-bold">Tabel Item MyFlorist</h1>

    <a href="/products/create" class="inline-block bg-blue-500 text-white px-4 py-2 rounded-full my-4">
        + Tambah Item
    </a>

    <table class="w-full">
        <thead class="bg-gray-200">
            <tr>
                <th class="p-2">Nama Item</th>
                <th class="p-2">Harga</th>
                <th class="p-2">Stok</th>
                <th class="p-2">Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $p)
            <tr class="text-center">
                <td class="p-2">{{ $p->nama_item }}</td>
                <td class="p-2">{{ $p->harga }}</td>
                <td class="p-2">{{ $p->stok }}</td>
                <td class="p-2">{{ $p->deskripsi }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>