<?php
// Tambah buku
if(isset($_POST['tambahBuku'])){
	$id_buku = $_POST['id_buku'];
	$kategori= $_POST['kategori'];
	$nama_buku = $_POST['nama_buku'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $penerbit = $_POST['penerbit'];
    $gambar = $_FILES['gambar']['name'];

    $stmt = $conn->prepare("SELECT id_penerbit FROM penerbit WHERE nama = ?");
    $stmt->bind_param("s", $penerbit);
    $stmt->execute();
    $result = $stmt->get_result();
	
    if($result->num_rows > 0) {
        $dataPenerbit = $result->fetch_assoc();
        $id_penerbit = $dataPenerbit['id_penerbit'];

        $addBuku = $conn->prepare("INSERT INTO buku (id_buku, kategori, nama_buku, harga, stok, id_penerbit, gambar)	VALUES (?, ?, ?, ?, ?, ?, ?)");
        $addBuku->bind_param("sssiiss", $id_buku, $kategori, $nama_buku, $harga, $stok, $id_penerbit, $gambar);

        $addSuccess = $addBuku->execute();

        if($addSuccess)  {
            // Simpan gambar di folder proyek
            $targetDir = "assets/img/buku/";
            $fileName = basename($gambar);
            $targetPath = $targetDir . $fileName;

            // Cek folder tujuan; buat folder jika belum ada
            if(!file_exists($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            if(move_uploaded_file($_FILES['gambar']['tmp_name'], $targetPath)) {
                echo "Gambar berhasil diunggah: " . $fileName;
            } else {
                echo "Gagal mengunggah gambar.";
            }

            header('location:admin_buku.php');
        } else {
            echo "Gagal menambah data buku: " . $conn->error;
            header('location:admin_buku.php');
        }
        $update->close();
    } else {
        echo "Nama penerbit tidak ditemukan (add)";
    }

    $stmt->close();
}

// Tambah data penerbit
if(isset($_POST['tambahPenerbit'])) {
    $id_penerbit = $_POST['id_penerbit'];
	$nama= $_POST['nama'];
	$alamat = $_POST['alamat'];
    $kota = $_POST['kota'];
    $no_tlpn = $_POST['no_tlpn'];

    $addPenerbit = $conn->prepare("INSERT INTO penerbit(id_penerbit, nama, alamat, kota, no_tlpn) VALUES (?, ?, ?, ?, ?)");
    $addPenerbit->bind_param("sssss", $id_penerbit, $nama, $alamat, $kota, $no_tlpn);

    $addSuccess = $addPenerbit->execute();

    if($addSuccess)  {
        header('location:admin_penerbit.php');
    } else {
        echo "Gagal mengupdate data penerbit: " . $conn->error;
        header('location:admin_penerbit.php');
    }

    $update->close();
}
?>