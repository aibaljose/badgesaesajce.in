<!--     
        <footer class="footer mt-auto py-3">
            <div class="container">
                <div class="text-center">
                    © <?php echo date('Y'); ?> Academic Enterprise Solutions (AES)
                </div>
            </div>
        </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Sidebar toggle (works with the toggle button added to header if present)
        (function(){
            var btn = document.getElementById('sidebarToggle');
            var sidebar = document.querySelector('.sidebar');
            if (btn && sidebar) {
                btn.addEventListener('click', function(e){
                    e.preventDefault();
                    sidebar.classList.toggle('open');
                    document.body.classList.toggle('sidebar-open');
                });
            }

            // Trigger Chart.js resize if necessary on orientation/resize for compact layouts
            var resizeTimeout;
            function triggerChartResize(){
                if (typeof Chart !== 'undefined' && Chart.instances) {
                    Object.values(Chart.instances).forEach(function(chart){ try{ chart.resize(); }catch(e){} });
                }
            }
            window.addEventListener('resize', function(){
                clearTimeout(resizeTimeout);
                resizeTimeout = setTimeout(triggerChartResize, 160);
            });
        })();
    </script>
</body>
</html> -->

   <style>
       :root { --sidebar-w: 260px; }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8fafc;
            overflow-x: hidden;
        }

        /* Header Styles */
        .header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 70px;
            /* background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); */
            background: white;
            color: black;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            z-index: 1000;
            /*box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);*/
        }
        a{
  text-decoration: none; /* Removes the underline */
  color: inherit;
  /* Removes the blue color and uses the parent's color */
}

/* Optional: Make sure it doesn't change color on hover */
.no-style-link:hover {
  color: inherit; 
}
        

        .header h1 {
            font-size: 1.5rem;
            font-weight: 600;
        }
        /* header placeholder removed to avoid empty ruleset */

        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .menu-toggle {
            display: none;
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            padding: 10px;
            border-radius: 8px;
            transition: background 0.3s ease;
        }

        .menu-toggle:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            background: rgba(255, 255, 255, 0.1);
            padding: 8px 15px;
            border-radius: 25px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .user-profile:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .avatar {
            width: 32px;
            height: 32px;
            background: #ff6b6b;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: white;
        }

        /* Sidebar Styles */
        /*.sidebar {*/
        /*    position: fixed;*/
        /*    top: 70px;*/
        /*    left: 0;*/
        /*    width: 280px;*/
        /*    height: calc(100vh - 70px);*/
        /*    background: white;*/
        /*    box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);*/
        /*    transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);*/
        /*    z-index: 999;*/
        /*    overflow-y: auto;*/
        /*}*/

        /*.sidebar-content {*/
        /*    padding: 30px 0;*/
        /*}*/

        .nav-item {
            display: flex;
            align-items: center;
            padding: 15px 25px;
            color: #64748b;
            gap: 20px;
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
            position: relative;
        }

        .nav-item:hover,
        .nav-item.active {
            background: linear-gradient(90deg, rgba(102, 126, 234, 0.1) 0%, rgba(102, 126, 234, 0.05) 100%);
            color: #667eea;
            border-left-color: #667eea;
        }

        .nav-item i {
            width: 20px;
            margin-right: 15px;
            font-size: 1.1rem;
        }

        .nav-item span {
            font-weight: 500;
        }

        /* Main Content Styles */
                .main-content {
                        margin-left: var(--sidebar-w);
          /*margin-top: 70px;  */
            padding: 30px;
            min-height: calc(100vh - 70px);
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
                /* Ensure no horizontal scroll due to grid gutters/tables */
                .content-wrapper, .main-container, .container-fluid { max-width: 100%; overflow-x: hidden; }
                img, canvas, table { max-width: 100%; }

        .content-header {
            margin-bottom: 30px;
        }

        .content-header h2 {
            color: #1e293b;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .content-header p {
            color: #64748b;
            font-size: 1.1rem;
        }

        /* Dashboard Cards */
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        .dashboard-card {
            background: white;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 4px 25px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            border: 1px solid #f1f5f9;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.12);
        }

        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .card-title {
            color: #1e293b;
            font-size: 1.2rem;
            font-weight: 600;
        }

        .card-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
        }

        .card-icon.blue { background: linear-gradient(135deg, #667eea, #764ba2); }
        .card-icon.green { background: linear-gradient(135deg, #48bb78, #38a169); }
        .card-icon.orange { background: linear-gradient(135deg, #ed8936, #dd6b20); }
        .card-icon.purple { background: linear-gradient(135deg, #9f7aea, #805ad5); }

        .card-value {
            font-size: 2.5rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 5px;
        }

        .card-subtitle {
            color: #64748b;
            font-size: 0.9rem;
        }

        /* Bottom Navigation (Mobile) */
        .bottom-nav {
            display: none;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: white;
            box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            padding: 10px 0;
        }

        .bottom-nav-content {
            display: flex;
            justify-content: space-around;
            align-items: center;
        }

        .bottom-nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 8px 12px;
            color: #64748b;
            text-decoration: none;
            border-radius: 12px;
            transition: all 0.3s ease;
            min-width: 60px;
        }

        .bottom-nav-item.active,
        .bottom-nav-item:hover {
            color: #667eea;
            background: rgba(102, 126, 234, 0.1);
        }

        .bottom-nav-item i {
            font-size: 1.2rem;
            margin-bottom: 4px;
        }

        .bottom-nav-item span {
            font-size: 0.75rem;
            font-weight: 500;
        }

        /* Sidebar Overlay */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 998;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .menu-toggle {
                display: block;
            }

            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .sidebar-overlay.active {
                display: block;
                opacity: 1;
            }

            .main-content {
                margin-left: 0 !important;
                padding: 20px;
                margin-bottom: 80px;
            }

            .bottom-nav {
                display: block;
            }

            .dashboard-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .content-header h2 {
                font-size: 1.5rem;
            }

            .header h1 {
                font-size: 1.2rem;
            }

            .user-profile span {
                display: none;
            }
        }

        @media (max-width: 480px) {
            .header {
                padding: 0 15px;
            }

            .main-content {
                padding: 15px;
            }

            .dashboard-card {
                padding: 20px;
            }
        }

        /* Animation for sidebar toggle */
        @keyframes slideIn {
            from { transform: translateX(-100%); }
            to { transform: translateX(0); }
        }

        @keyframes slideOut {
            from { transform: translateX(0); }
            to { transform: translateX(-100%); }
        }
    </style>

 <nav class="bottom-nav">
        <div class="bottom-nav-content">
            <a href="/teacher" class="bottom-nav-item ">
                <i class="fas fa-home"></i>
                <span>Home</span>
            </a>
            <a href="/certificate-view" class="bottom-nav-item">
                <i class="fas fa-award"></i>
                <span>Certificates</span>
            </a>
            <a href="/view_certificates" class="bottom-nav-item">
                <i class="fas fa-certificate"></i>
                <span>Manage Badges</span>
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
        // Mobile menu toggle functionality (guarded for missing elements)
        (function(){
            const menuToggle = document.getElementById('menuToggle');
            const sidebar = document.getElementById('sidebar');
            const sidebarOverlay = document.getElementById('sidebarOverlay');

            if (sidebar) {
                function toggleSidebar() {
                    sidebar.classList.toggle('active');
                    if (sidebarOverlay) sidebarOverlay.classList.toggle('active');
                }

                function closeSidebar() {
                    sidebar.classList.remove('active');
                    if (sidebarOverlay) sidebarOverlay.classList.remove('active');
                }

                if (menuToggle) menuToggle.addEventListener('click', toggleSidebar);
                if (sidebarOverlay) sidebarOverlay.addEventListener('click', closeSidebar);

                // Close sidebar when clicking on a nav item (mobile)
                document.querySelectorAll('.nav-item').forEach(item => {
                    item.addEventListener('click', () => {
                        if (window.innerWidth <= 768) closeSidebar();
                        document.querySelectorAll('.nav-item').forEach(nav => nav.classList.remove('active'));
                        item.classList.add('active');
                    });
                });

                // Close sidebar when window is resized to desktop
                window.addEventListener('resize', () => { if (window.innerWidth > 768) closeSidebar(); });

                // Prevent body scroll when sidebar is open on mobile
                const body = document.body;
                const observer = new MutationObserver(() => {
                    if (sidebar.classList.contains('active') && window.innerWidth <= 768) {
                        body.style.overflow = 'hidden';
                    } else {
                        body.style.overflow = 'auto';
                    }
                });
                observer.observe(sidebar, { attributes: true });
            }
        })();
    </script>