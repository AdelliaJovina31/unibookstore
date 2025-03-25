/*!
* Start Bootstrap - Grayscale v7.0.6 (https://startbootstrap.com/theme/grayscale)
* Copyright 2013-2023 Start Bootstrap
* Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-grayscale/blob/master/LICENSE)
*/
//
// Scripts
// 

window.addEventListener('DOMContentLoaded', event => {

    // Navbar shrink function
    var navbarShrink = function () {
        const navbarCollapsible = document.body.querySelector('#mainNav');
        if (!navbarCollapsible) {
            return;
        }
        if (window.scrollY === 0) {
            navbarCollapsible.classList.remove('navbar-shrink');
            removeActiveNav();
        } else {
            navbarCollapsible.classList.add('navbar-shrink');
            setActiveNav();
        }

    };

    const setActiveNav = () => {
        const currentPage = window.location.pathname.split("/").pop();
        const navLinks = document.querySelectorAll('.navbar-nav .nav-link');

        navLinks.forEach(link => {
            const href = link.getAttribute('href');

            // Class active hanya ditambahkan jika sudah scroll
            if (href.includes(currentPage) || 
                (currentPage === 'index.php' && href.includes('index.php#katalog'))
            ) {
                link.classList.add('active');
            }
        });

        // Menambahkan class active pada dropdown menu 'Kelola Data'
        const kelolaDataDropdown = document.querySelector('#kelolaDataDropdown');
        if (['admin_buku.php', 'admin_penerbit.php'].includes(currentPage) && kelolaDataDropdown) {
            kelolaDataDropdown.classList.add('active');
        }
    };

    // Hapus class active jika belum scroll
    const removeActiveNav = () => {
        const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
        navLinks.forEach(link => link.classList.remove('active'));
    };

    // Shrink the navbar 
    navbarShrink();

    // Shrink the navbar when page is scrolled
    document.addEventListener('scroll', navbarShrink);

    // Activate Bootstrap scrollspy on the main nav element
    const mainNav = document.body.querySelector('#mainNav');
    if (mainNav) {
        new bootstrap.ScrollSpy(document.body, {
            target: '#mainNav',
            rootMargin: '0px 0px -40%',
        });
    };

    // Collapse responsive navbar when toggler is visible
    const navbarToggler = document.body.querySelector('.navbar-toggler');

    const navItems = document.querySelectorAll('#navbarResponsive .nav-link');

    navItems.forEach(item => {
        item.addEventListener('click', () => {
            if (window.getComputedStyle(navbarToggler).display !== 'none') {
                navbarToggler.click();
            }
        });
    });
    
    // const responsiveNavItems = [].slice.call(
    //     document.querySelectorAll('#navbarResponsive .nav-link')
    // );
    // responsiveNavItems.map(function (responsiveNavItem) {
    //     responsiveNavItem.addEventListener('click', () => {
    //         if (window.getComputedStyle(navbarToggler).display !== 'none') {
    //             navbarToggler.click();
    //         }
    //     });
    // });

    // // Highlight active menu based on the current URL
    // const currentURL = window.location.pathname;

    // responsiveNavItems.forEach(navItem => {
    //     const linkHref = navItem.getAttribute('href');
    //     if(currentURL.includes(linkHref) || (linkHref === '#' && window.location.hash === linkHref)) {
    //         navItem.classList.add('active');
    //     }
    // });

    // const currentPage = window.location.pathname.split("/").pop();

    // // Menentukan elemen-elemen link pada navbar
    // const navLinks = document.querySelectorAll('.navbar-nav .nav-link');

    // // Loop untuk menambahkan class 'active' berdasarkan halaman saat ini
    // navLinks.forEach(link => {
    //     const href = link.getAttribute('href');
        
    //     // Cek apakah href cocok dengan currentPage
    //     if (href.includes(currentPage) || (currentPage === 'index.php' && href.includes('index.php#katalog'))) {
    //         link.classList.add('active');
    //     } else {
    //         link.classList.remove('active');
    //     }
    // });
});