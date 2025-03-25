<?php
    header('Content-Type: application/json');
    require 'connect.php';

    $stmt = $conn->prepare("SELECT * FROM penerbit");
    $stmt->execute();

    $result = $stmt->get_result();

    $arrPenerbit = [];
    if ($result->num_rows > 0) {
        while ($data = $result->fetch_assoc()) {
            $arrPenerbit[] = $data;
        }

        // Ambil max_id penerbit
        $lastID = $conn->prepare("SELECT id_penerbit FROM penerbit ORDER BY id_penerbit DESC LIMIT 1");
        $lastID->execute();
        $resultID = $lastID->get_result();
        $penerbitLast = $resultID->fetch_assoc();

        if($penerbitLast) {
            // Ambil angka terakhir id_penerbit (SPxx)
            $number = (int)substr($penerbitLast['id_penerbit'], 2);
            $new_id = 'SP' . str_pad($number+1, 2, '0', STR_PAD_LEFT);
        } else {
            // Jika belum ada data
            $new_id = 'SP01';
        }

        echo json_encode(['success' => true, 'arrPenerbit' => $arrPenerbit, 'new_id' => $new_id]);
    } else {
        echo json_encode(['error' => 'Data tidak ditemukan']);
    }
?>