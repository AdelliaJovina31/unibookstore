<?php
    header('Content-Type: application/json');
    require 'connect.php';

    $stmt = $conn->prepare("SELECT b.id_buku, b.kategori, b.nama_buku, b.harga, b.stok, p.nama, b.gambar FROM buku b
                            JOIN penerbit p ON b.id_penerbit = p.id_penerbit");
    $stmt->execute();

    $result = $stmt->get_result();

    $bukuArr = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $bukuArr[] = $row;
        }
        echo json_encode(['success' => true, 'bukuArr' => $bukuArr]);
    } else {
        echo json_encode(['error' => 'Data tidak ditemukan']);
    }
?>