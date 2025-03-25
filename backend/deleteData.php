<?php
// Hapus data buku
if(isset($_POST['deleteBuku'])){ 
	$id_buku = $_POST['id_buku'];

	$hapus = $conn->prepare("DELETE FROM buku WHERE id_buku = ?");
	$hapus->bind_param("s", $id_buku);
	$hapus_berhasil = $hapus->execute();

	if($hapus_berhasil) { 
		header('location:admin_buku.php'); 
	} else { 
		echo 'Gagal menghapus buku'; 
		header('location:admin_buku.php'); 
	}

	$hapus->close();
}

// Hapus data penerbit
if(isset($_POST['deletePenerbit'])){ 
	$id_penerbit = $_POST['id_penerbit'];

	$hapus = $conn->prepare("DELETE FROM penerbit WHERE id_penerbit = ?");
	$hapus->bind_param("s", $id_penerbit);
	$hapus_berhasil = $hapus->execute();

	if($hapus_berhasil) { 
		header('location:admin_penerbit.php'); 
	} else { 
		echo 'Gagal menghapus penerbit'; 
		header('location:admin_penerbit.php'); 
	}

	$hapus->close();
}
?>