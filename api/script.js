document.getElementById('searchForm').addEventListener('submit', function (e) {
    e.preventDefault(); // Mencegah form dari pengiriman default
    const query = document.getElementById('searchInput').value.trim(); // Mengambil nilai input pencarian dan menghapus spasi

    if (query === '') {
        alert('Silakan masukkan kata kunci pencarian.'); // Menampilkan alert jika input kosong
        return; // Menghentikan eksekusi lebih lanjut
    }

    fetch('search.php?q=' + query) // Mengirim permintaan ke search.php dengan parameter pencarian
        .then(response => response.json()) // Mengonversi respons ke format JSON
        .then(data => {
            let resultHTML = '<ul>'; // Membuat elemen HTML untuk hasil
            if (data.length === 0) {
                resultHTML += '<li>Tidak ada barang yang ditemukan.</li>'; // Jika tidak ada hasil
            } else {
                data.forEach(item => { // Mengiterasi setiap item hasil pencarian
                    resultHTML += `<li>${item.nama_barang} - Stok: ${item.stok}</li>`; // Menampilkan item ke hasil
                });
            }
            resultHTML += '</ul>'; // Menutup elemen list
            document.getElementById('result').innerHTML = resultHTML; // Menampilkan hasil di elemen dengan id 'result'
        })
        .catch(error => console.error('Error:', error)); // Menangani kesalahan
});