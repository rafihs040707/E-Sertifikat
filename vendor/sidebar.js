document.addEventListener('DOMContentLoaded', function () {

    const sidebar   = document.getElementById('sidebar');
    const overlay   = document.getElementById('sidebarOverlay');
    const openBtn   = document.getElementById('openSidebar') || document.getElementById('toggleSidebar');
    const closeBtn  = document.getElementById('closeSidebar');
    const navLinks  = document.querySelectorAll('#sidebar .nav-link');

    function isMobile() {
        return window.innerWidth <= 768;
    }

    function openSidebar() {
        if (!sidebar) return;
        sidebar.classList.add('show');
        overlay?.classList.add('show');
        document.body.style.overflow = 'hidden'; // lock scroll
    }

    function closeSidebar() {
        if (!sidebar) return;
        sidebar.classList.remove('show');
        overlay?.classList.remove('show');
        document.body.style.overflow = ''; // unlock scroll
    }

    // ===== OPEN =====
    openBtn?.addEventListener('click', openSidebar);

    // ===== CLOSE ICON =====
    closeBtn?.addEventListener('click', closeSidebar);

    // ===== OVERLAY CLICK =====
    overlay?.addEventListener('click', closeSidebar);

    // ===== AUTO CLOSE SAAT KLIK MENU (mobile UX GitHub) =====
    navLinks.forEach(link => {
        link.addEventListener('click', () => {
            if (isMobile()) closeSidebar();
        });
    });

    // ===== ESC KEY CLOSE =====
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeSidebar();
    });

    // ===== RESET SAAT RESIZE KE DESKTOP =====
    window.addEventListener('resize', () => {
        if (!isMobile()) {
            closeSidebar();
        }
    });

});