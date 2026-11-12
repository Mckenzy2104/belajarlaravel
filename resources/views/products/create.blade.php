<!DOCTYPE html>
<html>
<head>
    <title>Tambah Item</title>
    @vite(['resources/css/app.css'])
</head>
<body class="p-4">
    <h1 class="text-2xl font-bold mb-4">Tambah Item</h1>

    <form action="/products" method="POST" class="space-y-3">
        @csrf
        <input type="text" name="nama_item" placeholder="Nama item" class="border p-2 w-full">
        <input type="number" name="harga" placeholder="Harga" class="border p-2 w-full">
        <input type="number" name="stok" placeholder="Stok" class="border p-2 w-full">
        <textarea name="deskripsi" placeholder="Deskripsi" class="border p-2 w-full"></textarea>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-full">Simpan</button>
    </form>
</body>
</html>