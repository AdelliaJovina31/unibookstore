<?php

//update data buku
if(isset($_POST['updateBuku'])) {
    $id_buku_lama = $_POST['id_buku_lama'];
    $id_buku = $_POST['id_buku'];
	$kategori= $_POST['kategori'];
	$nama_buku = $_POST['nama_buku'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $penerbit = $_POST['penerbit'];
    $gambar_lama = $_POST['gambar_lama'];
    $gambar_baru = $_FILES['gambar']['name'];

    $stmt = $conn->prepare("SELECT id_penerbit FROM penerbit WHERE nama = ?");
    $stmt->bind_param("s", $penerbit);
    $stmt->execute();
    $result = $stmt->get_result();
	
    if($result->num_rows > 0) {
        $dataPenerbit = $result->fetch_assoc();
        $id_penerbit = $dataPenerbit['id_penerbit'];

        $targetDir = "assets/img/buku/";

        // Jika ada gambar baru
        if (!empty($gambar_baru)) {
            // Hapus gambar lama
            $pathGambarLama = $targetDir . $gambar_lama;
            if (file_exists($pathGambarLama)) {
                unlink($pathGambarLama);
            }

            $gambar = $gambar_baru;
            $targetPath = $targetDir . basename($gambar);

            // Upload gambar baru
            if (!move_uploaded_file($_FILES['gambar']['tmp_name'], $targetPath)) {
                echo "Gagal mengunggah gambar.";
            }
        } else {
            // Jika tidak ada gambar baru, pakai gambar lama
            $gambar = $gambar_lama;
        }

        // Update data
        $update = $conn->prepare("UPDATE buku SET id_buku = ?, kategori = ?, nama_buku = ?, harga = ?, stok = ?, id_penerbit = ?, gambar = ? WHERE id_buku = ?");
        $update->bind_param("sssiisss", $id_buku, $kategori, $nama_buku, $harga, $stok, $id_penerbit, $gambar, $id_buku_lama);

        $updateSuccess = $update->execute();

        if($updateSuccess)  {
            header('location:admin_buku.php');
        } else {
            echo "Gagal mengupdate data buku: " . $conn->error;
            header('location:admin_buku.php');
        }

        $update->close();
    } else {
        echo "Nama penerbit tidak ditemukan";
    }

    $stmt->close();
}

//update data penerbit
if(isset($_POST['updatePenerbit'])) {
    $id_penerbit = $_POST['id_penerbit'];
	$nama= $_POST['nama'];
	$alamat = $_POST['alamat'];
    $kota = $_POST['kota'];
    $no_tlpn = $_POST['no_tlpn'];

    $update = $conn->prepare("UPDATE penerbit SET nama = ?, alamat = ?, kota = ?, no_tlpn = ? WHERE id_penerbit = ?");
    $update->bind_param("sssss", $nama, $alamat, $kota, $no_tlpn, $id_penerbit);

    $updateSuccess = $update->execute();

    if($updateSuccess)  {
        header('location:admin_penerbit.php');
    } else {
        echo "Gagal mengupdate data penerbit: " . $conn->error;
        header('location:admin_penerbit.php');
    }

    $update->close();
}
?>