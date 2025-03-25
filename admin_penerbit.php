<?php
include 'backend/connect.php';
include 'backend/deleteData.php';
include 'backend/updateData.php';
include 'backend/addData.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="assets/logo.ico">

    <title>Kelola Data Penerbit</title>

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet" />

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="d-flex flex-column min-vh-100">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="index.php#page-top">UniBookStore</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php#katalog">Katalog</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="kelolaDataDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Kelola Data</a>
                        <ul class="dropdown-menu" aria-labelledby="kelolaDataDropdown">
                            <li><a href="admin_buku.php" class="dropdown-item">Buku</a></li>
                            <li><a href="admin_penerbit.php" class="dropdown-item">Penerbit</a></li>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="pengadaan.php">Pengadaan</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Konten Utama -->
    <div class="flex-grow-1 container-fluid my-4" style="padding-top: 8rem; background-color: #000; margin-top: 0 !important;">
        <h3 class="p-4 font-weight-bold text-white-50 text-center" style="background-color: #000;">Data Penerbit</h3>

        <!--Button tambah penerbit-->
        <div class="d-flex flex-row-reverse">
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#tambahPenerbit"><i class="fas fa-plus fa-sm text-white-50"></i>Tambah Penerbit</a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr style="text-align: center;">
                        <!--Kolom-->
                        <th>ID Penerbit</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Kota</th>
                        <th>No. Telepon</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stmt = $conn->prepare("SELECT * FROM penerbit");
                    $stmt->execute();
                    $result = $stmt->get_result();

                    while($penerbit = $result->fetch_assoc()){
                        $id_penerbit = $penerbit['id_penerbit'];
                        $nama = $penerbit['nama'];
                        $alamat = $penerbit['alamat'];
                        $kota = $penerbit['kota'];
                        $no_tlpn = $penerbit['no_tlpn'];
                    ?>
                        <tr>
                            <td style="text-align: center;"><?=$id_penerbit;?></td>
                            <td style="text-align: center;"><?=$nama;?></td>                 
                            <td style="text-align: center;"><?=$alamat;?></td>
                            <td style="text-align: center;"><?=$kota;?></td>
                            <td style="text-align: center;"><?=$no_tlpn;?></td>
                            <td style="text-align: center;">
                                <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#edit<?=$id_penerbit;?>"><span></span>Edit</button>
                                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?=$id_penerbit;?>"><span></span>Hapus</button>
                            </td>
                        </tr>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="edit<?=$id_penerbit;?>">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Edit Data Penerbit</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <!-- Modal body -->
                                    <form method="post" enctype="multipart/form-data">
                                        <div class="modal-body">
                                            <script>
                                                var initialData<?=$id_penerbit;?> = {
                                                    id_penerbit: "<?=$id_penerbit;?>",
                                                    nama: "<?=$nama;?>",
                                                    alamat: "<?=$alamat;?>",
                                                    kota: "<?=$kota;?>",
                                                    no_tlpn: "<?=$no_tlpn;?>"
                                                };

                                                function restoreInitialData<?=$id_penerbit?>() {
                                                    document.getElementById('id_penerbit<?= $id_penerbit ?>').value = initialData<?=$id_penerbit;?>.id_penerbit;
                                                    document.getElementById('nama<?= $id_penerbit ?>').value = initialData<?=$id_penerbit;?>.nama;
                                                    document.getElementById('alamat<?= $id_penerbit ?>').value = initialData<?=$id_penerbit;?>.alamat;
                                                    document.getElementById('kota<?= $id_penerbit ?>').value = initialData<?=$id_penerbit;?>.kota;
                                                    document.getElementById('no_tlpn<?= $id_penerbit ?>').value = initialData<?=$id_penerbit;?>.no_tlpn;
                                                }
                                                document.addEventListener("DOMContentLoaded", function() {
                                                    // Ambil tombol Reset
                                                    var clearButton = document.getElementById("resetButton<?= $id_penerbit ?>");

                                                    // Fungsi untuk membersihkan semua data
                                                    clearButton.addEventListener("click", function() {
                                                        // Semua elemen input yang ingin direset
                                                        var idPenerbitInput = document.getElementById("id_penerbit<?= $id_penerbit ?>");
                                                        var namaInput = document.getElementById("nama<?= $id_penerbit ?>");
                                                        var alamatInput = document.getElementById("alamat<?= $id_penerbit ?>");
                                                        var kotaInput = document.getElementById("kota<?= $id_penerbit ?>");
                                                        var no_tlpnInput = document.getElementById("no_tlpn<?= $id_penerbit ?>");

                                                        idPenerbitInput.value = "";
                                                        namaInput.value = "";
                                                        alamatInput.value = "";
                                                        kotaInput.value = "";
                                                        no_tlpnInput.value = "";
                                                    });
                                                });
                                            </script> 

                                            <!-- ID Penerbit -->
                                            <div class="form-group">
                                                <div class="form-label">ID Penerbit: </div>
                                                <input class="form-control" type="text" id="id_penerbit<?= $id_penerbit ?>" name="id_penerbit" value="<?php echo $id_penerbit ?>" readonly />
                                            </div>

                                             <!-- Nama -->
                                             <div class="form-group">
                                                <div class="form-label">Nama Penerbit: </div>
                                                <input class="form-control" type="text" id="nama<?= $id_penerbit ?>" name="nama" value="<?php echo $nama ?>" required />
                                            </div>

                                            <!-- Alamat -->
                                            <div class="form-group">
                                                <div class="form-label">Alamat: </div>
                                                <input class="form-control" type="text" id="alamat<?= $id_penerbit ?>" name="alamat" value="<?php echo $alamat ?>" required />
                                            </div>

                                            <!-- Kota -->
                                            <div class="form-group">
                                                <div class="form-label">Kota: </div>
                                                <input class="form-control" type="text" id="kota<?= $id_penerbit ?>" name="kota" value="<?php echo $kota ?>" required />
                                            </div>

                                            <!-- No. Telepon -->
                                            <div class="form-group">
                                                <div class="form-label">No. Telepon: </div>
                                                <input class="form-control" type="text" id="no_tlpn<?= $id_penerbit ?>" name="no_tlpn" value="<?php echo $no_tlpn ?>" required />
                                            </div>

                                            <!-- Button -->
                                            <div class="container">
                                                <div class="row justify-content-end">
                                                    <div class="col-auto">
                                                        <button type="submit" class="btn btn-primary" name="updatePenerbit"><span></span>Simpan</button>
                                                    </div>
                                                    <div class="col-auto">
                                                        <button type="button" class="btn btn-warning" id="resetButton<?= $id_penerbit ?>"><span class="icon text-white-50"></span>Reset Data</button>
                                                    </div>
                                                    <div class="col-auto">
                                                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal" onclick="restoreInitialData<?=$id_penerbit?>()">Batal</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Delete Modal -->
                        <div class="modal fade" id="delete<?=$id_penerbit;?>">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Hapus Data Penerbit</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <!-- Modal body -->
                                    <form method="post">
                                        <div class="modal-body">
                                            Apakah Anda yakin ingin menghapus: <?=$id_penerbit;?>?
                                            <input type="hidden" name="id_penerbit" value="<?= $id_penerbit; ?>">
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-danger" name="deletePenerbit"><span></span>Hapus</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Footer Sticky -->
    <footer class="sticky-footer bg-white">
        <div class="container my-auto">
            <div class="copyright text-center my-auto">
                <span>Copyright &copy; UniBookStore 2025</span>
            </div>
        </div>
    </footer>
                <!-- End of Footer -->
                <!-- /.container-fluid -->

            <!-- </div> -->
            <!-- End of Main Content -->
        <!-- </div> -->
        <!-- End of Content Wrapper -->

    <!-- </div> -->
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Tambah Penerbit Modal -->
    <div class="modal fade" id="tambahPenerbit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Data Penerbit</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- Modal body -->
                <form method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <!-- ID Penerbit -->
                        <div class="form-group">
                            <div class="form-label">ID Penerbit: </div>
                            <input class="form-control" type="text" id="id_penerbit" name="id_penerbit" readonly />
                        </div>

                            <!-- Nama -->
                            <div class="form-group">
                            <div class="form-label">Nama Penerbit: </div>
                            <input class="form-control" type="text" id="nama" name="nama" required />
                        </div>

                        <!-- Alamat -->
                        <div class="form-group">
                            <div class="form-label">Alamat: </div>
                            <input class="form-control" type="text" id="alamat" name="alamat" required />
                        </div>

                        <!-- Kota -->
                        <div class="form-group">
                            <div class="form-label">Kota: </div>
                            <input class="form-control" type="text" id="kota" name="kota" required />
                        </div>

                        <!-- No. Telepon -->
                        <div class="form-group">
                            <div class="form-label">No. Telepon: </div>
                            <input class="form-control" type="text" id="no_tlpn" name="no_tlpn" required />
                        </div>

                        <!-- Button -->
                        <div class="container">
                            <div class="row justify-content-end">
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary" name="tambahPenerbit"><span></span>Simpan</button>
                                </div>
                                <div class="col-auto">
                                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Batal</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>
    <script src="js/scripts.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Ambil max_id dari getPenerbit.php
            fetch('backend/getPenerbit.php')
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        document.getElementById("id_penerbit").value = data.new_id;
                    } else {
                        alert("Gagal mendapatkan new_id");
                    }
                })
                .catch(error => console.error("Terjadi kesalahan: ", error));
        });
    </script>
</body>

</html>