<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>UniBookStore</title>
        <!-- Favicon -->
        <link rel="icon" type="image/x-icon" href="assets/logo.ico">

        <!-- Font Awesome icons (free version)-->
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet" />

        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
        <link href="css/custom.css" rel="stylesheet" />
    </head>
    <body id="page-top">
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand" href="index.php#page-top">UniBookStore</a>
                <button class="navbar-toggler navbar-toggler-right" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    Menu
                    <i class="fas fa-bars"></i>
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
        <!-- Masthead-->
        <header class="masthead">
            <div class="container px-4 px-lg-5 d-flex h-100 align-items-center justify-content-center">
                <div class="d-flex justify-content-center">
                    <div class="text-center">
                        <h1 class="mx-auto my-0 text-uppercase">UniBookStore</h1>
                        <h2 class="text-white-50 mx-auto mt-2 mb-5">Tempat terbaik untuk menemukan dan menjelajahi koleksi buku dari berbagai kategori dan penerbit terpercaya.</h2>
                        <a class="btn btn-primary" href="#katalog">Lihat Katalog</a>
                    </div>
                </div>
            </div>
        </header>
        <!-- Katalog-->
        <section class="projects-section bg-light" id="katalog">
            <div class="container px-4 px-lg-5">
                <h2 class="text-black mb-5 text-center">Katalog Buku</h2>
                <!--Search Bar-->
                <div class="container mt-3">
                    <div class="row">
                        <div class="col-md-4 ms-auto">
                            <div class="input-group input-group-sm" style="flex-wrap: nowrap;">
                                <input id="search" type="text" class="form-control form-control-sm" placeholder="Cari buku..."></input>
                                <button id="search-icon" class="btn btn-primary" type="button" style="cursor: default; pointer-events: none;"><i class="fa-solid fa-magnifying-glass" style="color: white;"></i></button>
                            </div>
                        </div>
                    </div>
                </div>

                <!--Daftar Buku-->
                <div class="container mt-4">
                    <div class="row" id="katalogBuku"></div>
                </div>
            </div>
        </section>
        <!-- Footer-->
        <footer class="footer bg-black small text-center text-white-50">
            <div class="container px-4 px-lg-5">Copyright &copy; UniBookStore 2025</div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <!-- * *                               SB Forms JS                               * *-->
        <!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>

        <!--jQuery-->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <script>
            $(document).ready(function() {
                $.ajax({
                    url: 'backend/getKatalog.php',
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            let dataBuku = response.bukuArr;
                            let output = '';

                            dataBuku.forEach(function(buku) {
                                output += `
                                    <div class="col-md-3 mb-3 book-card">
                                        <div class="card h-100">
                                            <img src="assets/img/buku/${buku.gambar}" class="card-img-top" alt="${buku.nama_buku}">
                                            <div class="card-body text-center">
                                                <h5 class="card-title">${buku.nama_buku}</h5>
                                                <p class="card-text">${buku.nama}</p>
                                                <p class="card-text">Rp${buku.harga}</p>
                                                <p class="card-text">Stok: ${buku.stok}</p>
                                            </div>
                                        </div>
                                    </div>
                                `;
                            });

                            // Tampil hanya jika hasil search tidak ada
                            output += `<p id="noResult" class="text-center" style="display: none;">Buku yang Anda cari tidak ada</p>`;
                            $('#katalogBuku').html(output);

                            // Search Buku
                            $('#search').on('input', function() {
                                const keyword = $(this).val().toLowerCase();
                                let isFound = false;

                                $('.book-card').each(function() {
                                    const namaBuku = $(this).find('.card-title').text().toLowerCase();

                                    if(namaBuku.includes(keyword)) {
                                        $(this).show();
                                        isFound = true;
                                    } else {
                                        $(this).hide();
                                    }
                                    
                                    if(!isFound) {
                                        $('#noResult').show();
                                    } else {
                                        $('#noResult').hide();
                                    }
                                });
                            });
                        } else {
                            $('#katalogBuku').html("<p class='text-center'>Data tidak ditemukan</p>");
                        }
                    },
                    error: function() {
                        $('#katalogBuku').html("<p class='text-center'>Gagal mengambil data</p>");
                    }
                });
            });
        </script>
    </body>
</html>
