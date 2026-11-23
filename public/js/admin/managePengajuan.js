const applications = (typeof window.appData !== 'undefined' && Array.isArray(window.appData))
    ? window.appData.map(item => ({
        id: "PGJ-" + String(item.id).padStart(3, '0'),
        rawId: item.id,
        pemohon: item.nama_lengkap || (item.user ? item.user.name : '-'),
        judul: item.judul_kerjasama || item.judul_kegiatan || item.jenis_kegiatan || 'Pengajuan #' + item.id,
        instansi: item.nama_instansi || item.universitas || '-',
        tanggal: item.created_at ? new Date(item.created_at).toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' }) : '-',
        status: item.status || 'Menunggu Verifikasi',
        layanan: item.jenis_kegiatan || item.jenis_permohonan || 'KKN'
    }))
    : [];

let currentPage = 1;

const rowsPerPage = 5;


/* Status badge */

function getStatusClass(status) {

    if (status === "Menunggu Verifikasi") {
        return "waiting";
    }

    if (status === "Sedang Diproses") {
        return "process";
    }

    if (status === "Ditolak") {
        return "rejected";
    }

    return "completed";
}


/* Render table */

function renderTable() {

    const table = document.getElementById("applicationTable");

    const searchValue =
        document
            .getElementById("searchInput")
            .value
            .toLowerCase();

    const statusValue =
        document.getElementById("statusFilter").value;

    const serviceValue =
        document.getElementById("serviceFilter").value;


    const filteredData = applications.filter(item => {

        const searchMatch =
            item.id.toLowerCase().includes(searchValue) ||
            item.pemohon.toLowerCase().includes(searchValue) ||
            item.judul.toLowerCase().includes(searchValue) ||
            item.instansi.toLowerCase().includes(searchValue);

        const statusMatch =
            statusValue === "" ||
            item.status === statusValue;

        const serviceMatch =
            serviceValue === "" ||
            item.layanan === serviceValue;

        return searchMatch && statusMatch && serviceMatch;

    });


    const totalPages =
        Math.ceil(filteredData.length / rowsPerPage);


    if (currentPage > totalPages && totalPages > 0) {
        currentPage = totalPages;
    }


    const start =
        (currentPage - 1) * rowsPerPage;

    const end =
        start + rowsPerPage;

    const pageData =
        filteredData.slice(start, end);


    table.innerHTML = "";


    pageData.forEach(item => {

        const statusClass =
            getStatusClass(item.status);


        table.innerHTML += `

            <tr>

                <td>
                    <span class="table-id">
                        ${item.id}
                    </span>
                </td>

                <td>
                    <span class="table-name">
                        ${item.pemohon}
                    </span>
                </td>

                <td>
                    <span class="table-title">
                        ${item.judul}
                    </span>
                </td>

                <td>
                    <span class="table-institution">
                        ${item.instansi}
                    </span>
                </td>

                <td>
                    <span class="table-date">
                        ${item.tanggal}
                    </span>
                </td>

                <td>

                    <span class="status-badge ${statusClass}">

                        <i class="bi bi-circle-fill"></i>

                        ${item.status}

                    </span>

                </td>

                <td class="text-center">

                    <a
                        href="/admin/pengajuan/${item.rawId || item.id.replace('PGJ-', '').replace(/^0+/, '')}"
                        class="detail-btn"
                    >

                        Detail

                        <i class="bi bi-arrow-right"></i>

                    </a>

                </td>

            </tr>

        `;

    });


    if (pageData.length === 0) {

        table.innerHTML = `

            <tr>

                <td
                    colspan="7"
                    class="text-center py-5"
                >

                    <i
                        class="bi bi-inbox"
                        style="font-size: 30px; color: #A7B998;"
                    ></i>

                    <div class="mt-2">
                        Tidak ada pengajuan ditemukan
                    </div>

                </td>

            </tr>

        `;

    }


    const firstData =
        filteredData.length === 0
            ? 0
            : start + 1;

    const lastData =
        Math.min(end, filteredData.length);


    document.getElementById("dataInfo").textContent =
        `Menampilkan ${firstData}-${lastData} dari ${filteredData.length} pengajuan`;


    renderPagination(totalPages);

}


/* Pagination */

function renderPagination(totalPages) {

    const pagination =
        document.getElementById("pagination");

    pagination.innerHTML = "";


    if (totalPages <= 1) {
        return;
    }


    if (currentPage > 1) {

        pagination.innerHTML += `

            <li class="page-item">

                <button
                    class="page-link"
                    onclick="changePage(${currentPage - 1})"
                >

                    <i class="bi bi-chevron-left"></i>

                </button>

            </li>

        `;

    }


    for (let page = 1; page <= totalPages; page++) {

        pagination.innerHTML += `

            <li
                class="page-item
                ${page === currentPage ? "active" : ""}"
            >

                <button
                    class="page-link"
                    onclick="changePage(${page})"
                >

                    ${page}

                </button>

            </li>

        `;

    }


    if (currentPage < totalPages) {

        pagination.innerHTML += `

            <li class="page-item">

                <button
                    class="page-link"
                    onclick="changePage(${currentPage + 1})"
                >

                    <i class="bi bi-chevron-right"></i>

                </button>

            </li>

        `;

    }

}



/* ---- Server-side search & filter ---- */

function submitFilters() {
    const url = new URL(window.location.href);
    const search  = document.getElementById('searchInput').value.trim();
    const status  = document.getElementById('statusFilter').value;
    const service = document.getElementById('serviceFilter').value;

    url.searchParams.delete('page');

    if (search)  { url.searchParams.set('search', search); }
    else         { url.searchParams.delete('search'); }

    if (status)  { url.searchParams.set('status', status); }
    else         { url.searchParams.delete('status'); }

    if (service) { url.searchParams.set('layanan', service); }
    else         { url.searchParams.delete('layanan'); }

    window.location.href = url.toString();
}

/* Search — debounce 500ms */
let searchTimer;
document.getElementById('searchInput')?.addEventListener('input', () => {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(submitFilters, 500);
    });

document.getElementById('searchInput')?.addEventListener('keydown', (e) => {
        if (e.key === 'Enter') { clearTimeout(searchTimer); submitFilters(); }
    });

/* Status filter */
document.getElementById('statusFilter')?.addEventListener('change', submitFilters);

/* Service filter */
document.getElementById('serviceFilter')?.addEventListener('change', submitFilters);


/* Notification dropdown */

const notificationBtn =
    document.getElementById("notificationBtn");

const notificationDropdown =
    document.getElementById("notificationDropdown");

notificationBtn.addEventListener("click", event => {

    event.stopPropagation();

    notificationDropdown.classList.toggle("show");

    profileDropdown.classList.remove("show");

});


/* Profile dropdown */

const profileBtn =
    document.getElementById("profileBtn");

const profileDropdown =
    document.getElementById("profileDropdown");

profileBtn.addEventListener("click", event => {

    event.stopPropagation();

    profileDropdown.classList.toggle("show");

    notificationDropdown.classList.remove("show");

});


/* Close dropdown */

document.addEventListener("click", () => {

    notificationDropdown.classList.remove("show");

    profileDropdown.classList.remove("show");

});


/* Mobile sidebar */
(function initMobileSidebar() {
    const setup = () => {
        const mobileMenuBtn = document.getElementById("mobileMenuBtn");
        const sidebar = document.querySelector(".sidebar");
        const sidebarCloseBtn = document.getElementById("sidebarCloseBtn");
        const menuIcon = document.getElementById("menuIcon");
        if (!mobileMenuBtn || !sidebar) return;

        mobileMenuBtn.addEventListener("click", (event) => {
            event.stopPropagation();
            sidebar.classList.toggle("mobile-open");
            if (menuIcon) {
                menuIcon.classList.toggle("bi-x-lg", sidebar.classList.contains("mobile-open"));
                menuIcon.classList.toggle("bi-list", !sidebar.classList.contains("mobile-open"));
            }
        });

        if (sidebarCloseBtn) {
            sidebarCloseBtn.addEventListener("click", (event) => {
                event.stopPropagation();
                sidebar.classList.remove("mobile-open");
                if (menuIcon) {
                    menuIcon.classList.remove("bi-x-lg");
                    menuIcon.classList.add("bi-list");
                }
            });
        }

        document.addEventListener("click", (event) => {
            if (sidebar.classList.contains("mobile-open") && !sidebar.contains(event.target) && !mobileMenuBtn.contains(event.target)) {
                sidebar.classList.remove("mobile-open");
                if (menuIcon) {
                    menuIcon.classList.remove("bi-x-lg");
                    menuIcon.classList.add("bi-list");
                }
            }
        });
    };
    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", setup);
    } else {
        setup();
    }
})();