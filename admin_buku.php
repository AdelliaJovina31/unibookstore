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
       <h3 class="p-4 font-weight-bold text-white-50 text-center" style="background-color: #000;">Data Buku</h3>

       <!--Button tambah buku-->
       <div class="d-flex flex-row-reverse">
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#tambahBuku"><i class="fas fa-plus fa-sm text-white-50"></i>Tambah Buku</a>
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
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stmt = $conn->prepare("SELECT b.id_buku, b.kategori, b.nama_buku, b.harga, b.stok, p.nama, b.gambar FROM buku b
                                                            JOIN penerbit p ON b.id_penerbit = p.id_penerbit");
                    $stmt->execute();
                    $result = $stmt->get_result();

                    while($buku = $result->fetch_assoc()){
                        $id_buku = $buku['id_buku'];
                        $kategori = $buku['kategori'];
                        $nama_buku = $buku['nama_buku'];
                        $harga = $buku['harga'];
                        $stok = $buku['stok'];
                        $penerbit = $buku['nama'];
                        $gambar = $buku['gambar'];
                    ?>
                        <tr>
                            <td style="text-align: center;"><?=$id_buku;?></td>
                            <td style="text-align: center;"><?=$kategori;?></td>                 
                            <td style="text-align: center;"><?=$nama_buku;?></td>
                            <td style="text-align: center;"><?=$harga;?></td>
                            <td style="text-align: center;"><?=$stok;?></td>
                            <td style="text-align: center;"><?=$penerbit;?></td>
                            <td style="text-align: center;">
                                <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#edit<?=$id_buku;?>"><span></span>Edit</button>
                                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?=$id_buku;?>"><span></span>Hapus</button>
                            </td>
                        </tr>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="edit<?=$id_buku;?>">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Edit Data Buku</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <!-- Modal body -->
                                    <form method="post" enctype="multipart/form-data">
                                        <div class="modal-body">
                                            <script>
                                                var initialData<?=$id_buku;?> = {
                                                    id_buku: "<?=$id_buku;?>",
                                                    kategori: "<?=$kategori;?>",
                                                    nama_buku: "<?=$nama_buku;?>",
                                                    harga: "<?=$harga;?>",
                                                    stok: "<?=$stok;?>",
                                                    penerbit: "<?=$penerbit;?>"
                                                    gambar: "<?=$gambar;?>",
                                                };

                                                function restoreInitialData<?=$id_buku?>() {
                                                    document.getElementById('id_buku<?= $id_buku ?>').value = initialData<?=$id_buku;?>.id_buku;
                                                    document.getElementById('kategori<?= $id_buku ?>').value = initialData<?=$id_buku;?>.kategori;
                                                    document.getElementById('nama_buku<?= $id_buku ?>').value = initialData<?=$id_buku;?>.nama_buku;
                                                    document.getElementById('harga<?= $id_buku ?>').value = initialData<?=$id_buku;?>.harga;
                                                    document.getElementById('stok<?= $id_buku ?>').value = initialData<?=$id_buku;?>.stok;
                                                    document.getElementById('penerbit<?= $id_buku ?>').value = initialData<?=$id_buku;?>.penerbit;
                                                    document.getElementById('formfile').value = '';
                                                    var frame<?= $id_buku ?> = document.getElementById('frame');
                                                    frame<?= $id_buku ?>.src = initialData<?=$id_buku;?>.gambar;
                                                }
                                                document.addEventListener("DOMContentLoaded", function() {
                                                    // Ambil tombol Reset
                                                    var clearButton = document.getElementById("resetButton<?= $id_buku ?>");

                                                    // Fungsi untuk membersihkan semua data
                                                    clearButton.addEventListener("click", function() {
                                                        // Semua elemen input yang ingin direset
                                                        var idBukuInput = document.getElementById("id_buku<?= $id_buku ?>");
                                                        var kategoriInput = document.getElementById("kategori<?= $id_buku ?>");
                                                        var namaBukuInput = document.getElementById("nama_buku<?= $id_buku ?>");
                                                        var hargaInput = document.getElementById("harga<?= $id_buku ?>");
                                                        var stokInput = document.getElementById("stok<?= $id_buku ?>");
                                                        var penerbitInput = document.getElementById("penerbit<?= $id_buku ?>");

                                                        idBukuInput.value = "";
                                                        kategoriInput.value = "";
                                                        namaBukuInput.value = "";
                                                        hargaInput.value = "";
                                                        stokInput.value = "";
                                                        penerbitInput.value = "";
                                                    });
                                                });
                                            </script>

                                            <?php
                                            $selectedKategori = $buku['kategori'];

                                            // Ambil kategori yang tidak terpilih
                                            $stmt = $conn->prepare("SELECT DISTINCT kategori FROM buku WHERE kategori != ?");
                                            $stmt->bind_param("s", $selectedKategori);
                                            $stmt->execute();
                                            $resultKategori = $stmt->get_result();

                                            // Simpan hasil di array
                                            $kategoriOptions = [$selectedKategori];

                                            while ($kategori = $resultKategori->fetch_assoc()) {
                                                $kategoriOptions[] = $kategori['kategori'];
                                            }

                                            $stmt->close();
                                            ?>
                                            
                                            <!-- Kategori -->
                                            <div class="form-group">
                                                <div class="form-label">Kategori</div>
                                                <div class="form-input" style="padding: 4px;">
                                                    <select id="kategori<?= $id_buku ?>" name="kategori" class="form-select">
                                                        <?php foreach ($kategoriOptions as $option): ?>
                                                            <option value="<?= htmlspecialchars($option) ?>" <?= $option == $selectedKategori ? 'selected' : '' ?>>
                                                                <?= htmlspecialchars($option) ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Ambil id_buku sebelum diubah -->
                                            <input type="hidden" name="id_buku_lama" value="<?= $id_buku; ?>"> 

                                            <!-- ID Buku -->
                                            <div class="form-group">
                                                <div class="form-label">ID Buku: </div>
                                                <input class="form-control" type="text" id="id_buku<?= $id_buku ?>" name="id_buku" value="<?php echo $id_buku ?>" required />
                                            </div>

                                            <!-- Nama Buku -->
                                            <div class="form-group">
                                                <div class="form-label">Judul Buku: </div>
                                                <input class="form-control" type="text" id="nama_buku<?= $id_buku ?>" name="nama_buku" value="<?php echo $nama_buku ?>" required />
                                            </div>

                                            <!-- Penerbit -->
                                            <div class="form-group">
                                                <div class="form-label">Penerbit:</div>
                                                <div class="form-input" style="padding: 4px;">
                                                    <select class="form-select" id="penerbit<?= $id_buku ?>" name="penerbit" required></select>
                                                </div>
                                            </div>

                                            <script>
                                                document.addEventListener("DOMContentLoaded", function() {
                                                    const dropdown = document.getElementById("penerbit<?= $id_buku ?>");
                                                    const selectedPenerbit = "<?=$penerbit;?>";

                                                    // AJAX request
                                                    fetch('backend/getPenerbit.php')
                                                        .then(response => response.json())
                                                        .then(data => {
                                                            if(data.success) {
                                                                data.arrPenerbit.forEach(item => {
                                                                    let option = document.createElement("option");
                                                                    option.value = item.nama;
                                                                    option.text = item.nama;

                                                                    // Data awal yang terpilih
                                                                    if(item.nama === selectedPenerbit) {
                                                                        option.selected = true;
                                                                    }

                                                                    dropdown.appendChild(option);
                                                                });
                                                            } else {
                                                                alert("Data penerbit tidak ditemukan!");
                                                            }
                                                        })
                                                        .catch(error => console.error("Terjadi kesalahan: ", error));
                                                });
                                            </script>
                                            
                                            <!-- Harga -->
                                            <div class="form-group">
                                                <div class="form-label">Harga (Rp): </div>
                                                <input class="form-control" type="number" id="harga<?= $id_buku ?>" name="harga" value="<?php echo $harga ?>" required />
                                            </div>

                                            <!-- Stok -->
                                            <div class="form-group">
                                                <div class="form-label">Stok: </div>
                                                <input class="form-control" type="number" id="stok<?= $id_buku ?>" name="stok" value="<?php echo $stok ?>" required />
                                            </div>

                                            <div class="d-sm-flex align-items-start">
                                                <div>
                                                    <label style="padding: 15px;">Foto:</label>
                                                </div>

                                                <!-- Ambil gambar lama -->
                                                <input type="hidden" name="gambar_lama" value="<?=$gambar;?>">

                                                <div>
                                                    <!-- Gambar Foto -->
                                                    <img id="frame<?= $id_buku ?>" src="assets/img/buku/<?=$gambar;?>" style="float:left; width: 150px; height: 150px;" class = "mb-4">
                                                </div>
                                                
                                                <div class="col-sm">
                                                    <input class="form-control" type="file" name="gambar" id="formfile" onchange="preview<?=$id_buku?>(event)">
                                                </div>
                                            </div>

                                            <script>
                                                function preview<?=$id_buku?>(event) {
                                                    var frame = document.getElementById('frame<?=$id_buku?>');
                                                    if (event.target.files.length > 0) {
                                                        frame.src = URL.createObjectURL(event.target.files[0]);
                                                    }
                                                }
                                            </script>

                                            <!-- Button -->
                                            <div class="container">
                                                <div class="row justify-content-end">
                                                    <div class="col-auto">
                                                        <button type="submit" class="btn btn-primary" name="updateBuku"><span></span>Simpan</button>
                                                    </div>
                                                    <div class="col-auto">
                                                        <button type="button" class="btn btn-warning" id="resetButton<?= $id_buku ?>"><span class="icon text-white-50"></span>Reset Data</button>
                                                    </div>
                                                    <div class="col-auto">
                                                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal" onclick="restoreInitialData<?=$id_buku?>()">Batal</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Delete Modal -->
                        <div class="modal fade" id="delete<?=$id_buku;?>">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Hapus Data Buku</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <!-- Modal body -->
                                    <form method="post">
                                        <div class="modal-body">
                                            Apakah Anda yakin ingin menghapus: <?=$id_buku;?>?
                                            <input type="hidden" name="id_buku" value="<?= $id_buku; ?>">
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-danger" name="deleteBuku"><span></span>Hapus</button>
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

    <!-- Tambah Buku Modal -->
    <div class="modal fade" id="tambahBuku" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Data Buku</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- Modal body -->
                <form method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <!-- Kategori -->
                        <div class="form-group">
                            <div class="form-label">Kategori</div>
                            <div class="form-input" style="padding: 4px;">
                                <select id="kategori<?= $id_buku ?>" name="kategori" class="form-select">
                                    <option value="">- Pilih -</option>
                                    <?php foreach ($kategoriOptions as $option): ?>
                                        <option value="<?= htmlspecialchars($option) ?>">
                                            <?= htmlspecialchars($option) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <!-- ID Buku -->
                        <div class="form-group">
                            <div class="form-label">ID Buku: </div>
                            <input class="form-control" type="text" id="id_buku" name="id_buku" required />
                        </div>

                        <!-- Nama Buku -->
                        <div class="form-group">
                            <div class="form-label">Judul Buku: </div>
                            <input class="form-control" type="text" id="nama_buku" name="nama_buku" required />
                        </div>

                        <!-- Penerbit -->
                        <div class="form-group">
                            <div class="form-label">Penerbit:</div>
                            <div class="form-input" style="padding: 4px;">
                                <select class="form-select" id="penerbit" name="penerbit" required>
                                    <option value="">- Pilih -</option>
                                </select>
                            </div>
                        </div>

                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                const dropdown = document.getElementById("penerbit");
                                const selectedPenerbit = "<?=$penerbit;?>";

                                // AJAX request
                                fetch('backend/getPenerbit.php')
                                    .then(response => response.json())
                                    .then(data => {
                                        if(data.success) {
                                            data.arrPenerbit.forEach(item => {
                                                let option = document.createElement("option");
                                                option.value = item.nama;
                                                option.text = item.nama;

                                                dropdown.appendChild(option);
                                            });
                                        } else {
                                            alert("Data penerbit tidak ditemukan!");
                                        }
                                    })
                                    .catch(error => console.error("Terjadi kesalahan: ", error));
                            });
                        </script>
                        
                        <!-- Harga -->
                        <div class="form-group">
                            <div class="form-label">Harga (Rp): </div>
                            <input class="form-control" type="number" id="harga" name="harga" required />
                        </div>

                        <!-- Stok -->
                        <div class="form-group">
                            <div class="form-label">Stok: </div>
                            <input class="form-control" type="number" id="stok" name="stok" required />
                        </div>

                        <div class="d-flex align-items-start">
                            <div>
                                <label style="padding: 15px;">Foto:</label>
                            </div>
                            <div>
                                <!-- Gambar Foto -->
                                <img id="framez" width="100px" height="100px" class="mb-4">
                            </div>
                            <div class="col-sm">
                                <input class="form-control" type="file" name="gambar" id="formfile" onchange="preview(event)" required />
                            </div>
                        </div>

                        <script>
                            function preview(event) {
                                var framez = document.getElementById('framez');
                                framez.src = URL.createObjectURL(event.target.files[0]);
                            }              
                        </script>

                        <!-- Button -->
                        <div class="container">
                            <div class="row justify-content-end">
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary" name="tambahBuku"><span></span>Simpan</button>
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

</body>

</html>