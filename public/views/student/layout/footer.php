




 <nav class="bottom-nav">
        <div class="bottom-nav-content">
            <a href="/" class="bottom-nav-item ">
                <i class="fas fa-home"></i>
                <span>Home</span>
            </a>
            <a href="/badges" class="bottom-nav-item">
                <i class="fas fa-award"></i>
                <span>Badges</span>
            </a>
            <a href="/view_certificates" class="bottom-nav-item">
                <i class="fas fa-certificate"></i>
                <span>Certificates</span>
            </a>
            <a href="/upload_certificate" class="bottom-nav-item">
                <i class="fas fa-cloud-upload-alt"></i>
                <span>Upload</span>
            </a>
            <a href="/logout" class="bottom-nav-item">
                <i class="fas fa-user"></i>
                <span>Profile</span>
            </a>
        </div>
    </nav>
    
      <script>
        // This script makes the sidebar navigation active state dynamic
        document.addEventListener("DOMContentLoaded", function() {
            const navLinks = document.querySelectorAll('.bottom-nav-item');
            const currentPath = window.location.pathname;

            // --- Part 1: Set active link on page load ---
            // This ensures the correct link is active when the page is loaded/reloaded.
            navLinks.forEach(link => {
                if (link.getAttribute('href') === currentPath) {
                    link.classList.add('active');
                }
            });

            // --- Part 2: Set active link on click ---
            // This provides immediate visual feedback to the user.
            navLinks.forEach(link => {
                link.addEventListener('click', function() {
                    // Remove 'active' class from all links
                    navLinks.forEach(nav => nav.classList.remove('active'));
                    
                    // Add 'active' class to the clicked link
                    this.classList.add('active');
                });
            });
        });
    </script>

    <script>
        // Mobile menu toggle functionality
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        function toggleSidebar() {
            sidebar.classList.toggle('active');
            sidebarOverlay.classList.toggle('active');
        }

        function closeSidebar() {
            sidebar.classList.remove('active');
            sidebarOverlay.classList.remove('active');
        }

        menuToggle.addEventListener('click', toggleSidebar);
        sidebarOverlay.addEventListener('click', closeSidebar);

        // Close sidebar when clicking on a nav item (mobile)
        document.querySelectorAll('.nav-item').forEach(item => {
            item.addEventListener('click', (e) => {
                if (window.innerWidth <= 768) {
                    closeSidebar();
                }
                
                // Update active state
                document.querySelectorAll('.nav-item').forEach(nav => nav.classList.remove('active'));
                item.classList.add('active');
            });
        });

        // Update bottom nav active state
        document.querySelectorAll('.bottom-nav-item').forEach(item => {
            item.addEventListener('click', (e) => {
                // e.preventDefault();
                document.querySelectorAll('.bottom-nav-item').forEach(nav => nav.classList.remove('active'));
                item.classList.add('active');
            });
        });

        // Close sidebar when window is resized to desktop
        window.addEventListener('resize', () => {
            if (window.innerWidth > 768) {
                closeSidebar();
            }
        });

        // Prevent body scroll when sidebar is open on mobile
        const body = document.body;
        const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                if (mutation.attributeName === 'class') {
                    if (sidebar.classList.contains('active') && window.innerWidth <= 768) {
                        body.style.overflow = 'hidden';
                    } else {
                        body.style.overflow = 'auto';
                    }
                }
            });
        });

        observer.observe(sidebar, { attributes: true });
    </script>