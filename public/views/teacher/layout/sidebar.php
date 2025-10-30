<!-- <div class="sidebar">
    <div class="sidebar-header">
        <img src="<?=$user['staff_photo']?>" alt="Teacher Avatar" class="avatar" style="width:48px;height:48px;border-radius:6px;object-fit:cover;">
        <h5 style="font-size:1rem;margin:0;"><?=$user['staff_name']?></h5>
    </div>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link <?php echo ($currentPage == 'home') ? 'active' : ''; ?>" href="/teacher/" style="padding:.45rem .6rem; font-size:.94rem;">
                <i class="fas fa-home"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo ($currentPage == 'certificates') ? 'active' : ''; ?>" href="/certificate-view/" style="padding:.45rem .6rem; font-size:.94rem;">
                <i class="fas fa-certificate"></i> Student Certificates
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo ($currentPage == 'badges') ? 'active' : ''; ?>" href="/teacher/badges/" style="padding:.45rem .6rem; font-size:.94rem;">
                <i class="fas fa-award"></i> Badges Management
            </a>
        </li>
    </ul>
</div>

<style>
    .sidebar { width: 220px; padding: .75rem; }
    .sidebar .nav-link { color: #333; border-radius: .35rem; }
    .sidebar .nav-link.active { background: rgba(108,66,152,0.08); color:#3b2a5a; }

    /* Mobile: hide sidebar off-canvas; toggle by adding .open */
    @media (max-width: 991px) {
        .sidebar { position: fixed; top: 56px; left: -260px; height: calc(100% - 56px); background: #fff; z-index: 1050; box-shadow: 0 8px 30px rgba(0,0,0,0.08); transition: left .28s ease; }
        .sidebar.open { left: 0; }
        body.sidebar-open { overflow: hidden; }
    }
</style> -->


<style>
    
    
    /* Sidebar container */
.sidebar {
  width: 280px;
  background: #fff;

  box-shadow: 0 2px 12px rgba(0,0,0,0.1);
  padding: 20px 0;
  font-family: 'Inter', sans-serif;
  color: #4a4a4a;
  display: flex;
  flex-direction: column;
  height: 100vh;
  position: fixed;
  overflow-y: auto;
  z-index:1200;
  /*padding-top:70px;*/
}

/* Navigation container */
.sidebar-content {
  display: flex;
  flex-direction: column;
  gap: 12px;
  padding: 0 16px;
}

/* Each nav link */
.nav-item {
  display: flex;
  align-items: center;
  gap: 14px;
  padding: 10px 16px;
  border-radius: 8px;
  color: #6b7280; /* neutral gray */
  font-weight: 500;
  font-size: 15px;
  text-decoration: none;
  transition: background-color 0.3s, color 0.3s;
  cursor: pointer;
}

/* Icons style (assuming FontAwesome) */
.nav-item i {
  font-size: 18px;
  color: #9ca3af;
  min-width: 20px;
  text-align: center;
  transition: color 0.3s;
}

/* Hover and active states */
.nav-item:hover {
  background-color: #f3f4f6; /* light gray background */
  color: #1f2937; /* darker text */
}

.nav-item:hover i {
  color: #2563eb; /* blue icon on hover */
}

.nav-item.active {
  background-color: #2563eb; /* blue background */
  color: white;
  font-weight: 600;
}

.nav-item.active i {
  color: white;
}

/* Text styling */
.nav-item span {
  white-space: nowrap;
  user-select: none;
}

/* Scrollbar for sidebar */
.sidebar::-webkit-scrollbar {
  width: 6px;
}

.sidebar::-webkit-scrollbar-thumb {
  background: rgba(100, 116, 139, 0.4);
  border-radius: 3px;
}

.sidebar::-webkit-scrollbar-track {
  background: transparent;
}
.logo-icon{
      padding: 10px 16px;
}

    
</style>








<aside class="sidebar" id="sidebar">
     <a href="/" class="logo-icon">
               <img src="https://jobs.amaljyothi.ac.in/public/assets/img/logo/ajce-logo.png" style="height:60px;">
            </a>
        <nav class="sidebar-content">
            <a href="/" class="nav-item ">
                <i class="fas fa-home"></i>
                <span>Home</span>
            </a>
            <a href="/badges" class="nav-item">
                <i class="fas fa-award"></i>
                <span>Badges</span>
            </a>
            <a href="/view_certificates" class="nav-item">
                <i class="fas fa-certificate"></i>
                <span>Certificates</span>
            </a>
            <a href="/upload_certificate" class="nav-item">
                <i class="fas fa-cloud-upload-alt"></i>
                <span>Upload Certificates</span>
            </a>
            <a href="/profile" class="nav-item">
                <i class="fas fa-user"></i>
                <span>Profile</span>
            </a>
      
            <a href="/logout" class="nav-item">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </nav>
    </aside>
  <script>
        // This script makes the sidebar navigation active state dynamic
        document.addEventListener("DOMContentLoaded", function() {
            const navLinks = document.querySelectorAll('.nav-item');
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