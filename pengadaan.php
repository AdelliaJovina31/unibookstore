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
    <link rel="icon" type="image/x-icon" href="src/images/favicon.ico">

    <title>Kelola Data Buku</title>

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
    <h3 class="p-4 font-weight-bold text-white-50 text-center" style="background-color: #000;">Pengadaan Buku</h3>

    <!-- Input minimal buku -->
    <div class="form-group d-flex align-items-center justify-content-end" style="margin-right: 70px;">
        <label class="mr-2 mb-0">Minimal buku:</label>
        <div class="form-input" style="padding: 4px;">
            <select class="form-select" id="min_buku" name="min_buku" required onchange="window.location.href='pengadaan.php?min_buku=' + this.value;">
                <option value="5" selected>5</option>
                <option value="10">10</option>
                <option value="15">15</option>
                <option value="20">20</option>
                <option value="25">25</option>
            </select>
        </div>
    </div>

        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr style="text-align: center;">
                        <!--Kolom-->
                        <th>ID Buku</th>
                        <th>Kategori</th>
                        <th>Nama Buku</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Penerbit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $min_buku = isset($_GET['min_buku']) ? (int)$_GET['min_buku'] : 5;

                    $stmt = $conn->prepare("SELECT b.id_buku, b.kategori, b.nama_buku, b.harga, b.stok, p.nama 
                                                        FROM buku b
                                                        JOIN penerbit p ON b.id_penerbit = p.id_penerbit
                                                        WHERE b.stok <= ?");
                    $stmt->bind_param("i", $min_buku);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    while($buku = $result->fetch_assoc()){
                        $id_buku = $buku['id_buku'];
                        $kategori = $buku['kategori'];
                        $nama_buku = $buku['nama_buku'];
                        $harga = $buku['harga'];
                        $stok = $buku['stok'];
                        $penerbit = $buku['nama'];
                    ?>
                        <tr>
                            <td style="text-align: center;"><?=$id_buku;?></td>
                            <td style="text-align: center;"><?=$kategori;?></td>                 
                            <td style="text-align: center;"><?=$nama_buku;?></td>
                            <td style="text-align: center;"><?=$harga;?></td>
                            <td style="text-align: center;"><?=$stok;?></td>
                            <td style="text-align: center;"><?=$penerbit;?></td>
                        </tr>
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
        const selectMinBuku = document.getElementById("min_buku");

        // Ambil nilai dari localStorage jika ada
        const savedValue = localStorage.getItem("min_buku");
        if (savedValue) {
            selectMinBuku.value = savedValue;

            // Cek apakah URL sudah ada parameter min_buku, jika belum tambahkan
            const urlParams = new URLSearchParams(window.location.search);
            if (!urlParams.has("min_buku")) {
                window.location.href = window.location.pathname + "?min_buku=" + savedValue;
            }
        }

        // Simpan pilihan user ke localStorage
        selectMinBuku.addEventListener("change", function() {
            localStorage.setItem("min_buku", selectMinBuku.value);
            window.location.href = window.location.pathname + "?min_buku=" + selectMinBuku.value;
        });
    });
    </script>
                    
</body>

</html>