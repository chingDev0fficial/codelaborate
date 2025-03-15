document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.querySelector('.left-nav');
    const toggleBtn = document.getElementById('sidebarToggle');
    const overlay = document.querySelector('.sidebar-overlay');
    
    function toggleSidebar(force) {
        const isOpen = force !== undefined ? force : !sidebar.classList.contains('show-sidebar');
        sidebar.classList.toggle('show-sidebar', isOpen);
        overlay.classList.toggle('show', isOpen);
        document.body.style.overflow = isOpen ? 'hidden' : '';
    }

    if (toggleBtn && sidebar) {
        // Toggle button click
        toggleBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            toggleSidebar();
        });
    }

    if (overlay) {
        // Close on overlay click
        overlay.addEventListener('click', () => toggleSidebar(false));
    }

    // Close on ESC key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && sidebar.classList.contains('show-sidebar')) {
            toggleSidebar(false);
        }
    });

    // Close when clicking outside
    document.addEventListener('click', (e) => {
        if (!sidebar.contains(e.target) && !toggleBtn.contains(e.target)) {
            if (sidebar.classList.contains('show-sidebar')) {
                toggleSidebar(false);
            }
        }
    });

    // Handle mobile navigation
    const navLinks = document.querySelectorAll('.nav-link');
    navLinks.forEach(link => {
        if (link) {
            link.addEventListener('click', function() {
                if (window.innerWidth <= 768) {
                    sidebar.classList.add('collapsed');
                    if (overlay) {
                        overlay.classList.remove('show');
                    }
                }
            });
        }
    });
});
