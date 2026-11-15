/**
 * Admin Detail Pengajuan Script
 * Handles UI interactions (sidebar toggle, dropdowns)
 * Form submissions are processed server-side via Laravel routes.
 */

document.addEventListener("DOMContentLoaded", function () {
    // Dropdown Notifikasi
    const notificationBtn = document.getElementById("notificationBtn");
    const notificationDropdown = document.getElementById("notificationDropdown");

    if (notificationBtn && notificationDropdown) {
        notificationBtn.addEventListener("click", function (e) {
            e.stopPropagation();
            notificationDropdown.classList.toggle("show");
            if (profileDropdown) profileDropdown.classList.remove("show");
        });
    }

    // Dropdown Profil
    const profileBtn = document.getElementById("profileBtn");
    const profileDropdown = document.getElementById("profileDropdown");

    if (profileBtn && profileDropdown) {
        profileBtn.addEventListener("click", function (e) {
            e.stopPropagation();
            profileDropdown.classList.toggle("show");
            if (notificationDropdown) notificationDropdown.classList.remove("show");
        });
    }

    // Tutup dropdown jika klik di luar
    document.addEventListener("click", function () {
        if (notificationDropdown) notificationDropdown.classList.remove("show");
        if (profileDropdown) profileDropdown.classList.remove("show");
    });

    // Mobile sidebar toggle
    const mobileMenuBtn = document.getElementById("mobileMenuBtn");
    const sidebar = document.querySelector(".sidebar");
    const sidebarCloseBtn = document.getElementById("sidebarCloseBtn");
    const menuIcon = document.getElementById("menuIcon");

    if (mobileMenuBtn && sidebar) {
        mobileMenuBtn.addEventListener("click", function (event) {
            event.stopPropagation();
            sidebar.classList.toggle("mobile-open");
            if (menuIcon) {
                if (sidebar.classList.contains("mobile-open")) {
                    menuIcon.classList.remove("bi-list");
                    menuIcon.classList.add("bi-x-lg");
                } else {
                    menuIcon.classList.remove("bi-x-lg");
                    menuIcon.classList.add("bi-list");
                }
            }
        });
    }

    if (sidebarCloseBtn && sidebar) {
        sidebarCloseBtn.addEventListener("click", function (event) {
            event.stopPropagation();
            sidebar.classList.remove("mobile-open");
            if (menuIcon) {
                menuIcon.classList.remove("bi-x-lg");
                menuIcon.classList.add("bi-list");
            }
        });
    }

    document.addEventListener("click", function (event) {
        if (
            sidebar &&
            sidebar.classList.contains("mobile-open") &&
            !sidebar.contains(event.target) &&
            mobileMenuBtn &&
            !mobileMenuBtn.contains(event.target)
        ) {
            sidebar.classList.remove("mobile-open");
            if (menuIcon) {
                menuIcon.classList.remove("bi-x-lg");
                menuIcon.classList.add("bi-list");
            }
        }
    });
});
