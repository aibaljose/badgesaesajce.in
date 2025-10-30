<?php
// Start the session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


// Initialize API Methods to get auth user
require_once $_SERVER['DOCUMENT_ROOT'] . '/api_services/APIMethods.php';
$api = new APIMethods();
$authUser = $api->authUser();

if (!$authUser || !$authUser['status']) {
    // Redirect to login if not authenticated
    header('Location: /login');
    exit;
}

// Set the current page. You would change this in each file (e.g., 'home', 'upload', 'badges').
$currentPage = 'home'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amal Jyothi</title>
    
    <link rel="icon" type="image/x-icon" href="/public/assets/images/favicon.ico">
    
 

      <link rel="stylesheet" href="/public/assets/css/studenthome.css">
      <!--<link rel="stylesheet" href="/public/assets/css/studentheader.css">-->



    <!--<script src="https://cdn.tailwindcss.com"></script>-->
    
        <!--<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>-->

       
   
    <script>
        // Pass authenticated user data to JavaScript
        if (typeof window.__authUser === 'undefined') {
            window.__authUser = <?php echo json_encode($authUser); ?>;
        }
    </script>
</head>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AES Badge</title>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
   <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Google Fonts - Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="/public/assets/css/admin_style.css" rel="stylesheet">


    <!-- Scripts -->

    <!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

    <script>
        console.log(<?=__authUser['staff_name']?>);
    </script>
    
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <style>
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
        }

        .header h1 {
            font-size: 1.5rem;
            font-weight: 600;
        }
        header{
            /*height:60px;*/
        }

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
            margin-left: 280px;
          /*margin-top: 70px;  */
            padding: 30px;
            min-height: calc(100vh - 70px);
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

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
                margin-left: 0;
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
</head>

<body>
    
    
   <header class=" position-fixed w-100 py-1 mb-3" style="top: 0; z-index: 1050;background-color:white; color: black;height:60px;">
   <div class="container-fluid px-3 py-2">
       <div class="d-flex justify-content-between align-items-center">
           <!-- Left Section -->
           <div class="d-flex align-items-center">
               <!--<button class="btn btn-outline-secondary border-0 me-3" id="menuToggle" type="button">-->
                   <!--<i class="fas fa-bars "></i>-->
               </button>
               <h1 class="h4 fw-bold mb-0"></h1>
               <img src="https://jobs.amaljyothi.ac.in/public/assets/img/logo/ajce-logo.png" style="height:40px;">
           </div>
           
            <!-- Right Section -->
           <div class="dropdown">
               <button class="btn  dropdown-toggle d-flex align-items-center border-0 shadow-none" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                   <div class="me-2 me-md-2">
                       <img src="<?php echo htmlspecialchars($authUser['u-photo'] ?? ''); ?>" 
                            alt="User Avatar" 
                            class="rounded-circle" 
                            style="width: 32px; height: 32px; object-fit: cover;">
                   </div>
                   <span class=" small fw-medium me-1 d-none d-md-inline">
                       <?php echo htmlspecialchars($authUser['u-name'] ?? 'User'); ?>
                   </span>
               </button>
               <ul class="dropdown-menu dropdown-menu-end">
                   <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Profile</a></li>
                   <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Settings</a></li>
                   <li><hr class="dropdown-divider"></li>
                   <li><a class="dropdown-item" href="#"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
               </ul>
           </div>
       </div>
   </div>
</header>
    
    
    
    <!-- <header class="header">-->
    <!--    <div style="display: flex; align-items: center; gap: 15px;">-->
    <!--        <button class="menu-toggle" id="menuToggle">-->
    <!--            <i class="fas fa-bars"></i>-->
    <!--        </button>-->
    <!--        <h1>AES BADGES</h1>-->
    <!--    </div>-->
    <!--    <div class="header-right">-->
    <!--        <div class="user-profile">-->
    <!--            <div class="avatar">-->
    <!--                <img class='avatar' src="<?php echo htmlspecialchars($authUser['u-photo'] ?? ''); ?>">-->
    <!--            </div>-->
    <!--            <span><?php echo htmlspecialchars($authUser['u-name'] ?? 'User'); ?></span>-->
    <!--            <i class="fas fa-chevron-down" style="font-size: 0.8rem; margin-left: 5px;"></i>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--</header>-->
</body>

</html>













































<!--<body class="bg-slate-50 font-sans">-->
    
    

<!--    <nav class="bg-[#6c4298] text-white px-4 py-3  fixed top-0 left-0 w-full z-50 text-decoration-none">-->
<!--    <div class="max-w-7xl mx-auto flex items-center justify-between">-->
      
      <!-- Logo and Title -->
<!--      <div class="flex items-center space-x-2">-->
<!--        <img src="/public/assets/images/header_logo.png" alt="AES Logo" class="w-8 h-8">-->
<!--        <span class="text-lg font-semibold">AES Digital Badge System</span>-->
<!--      </div>-->

      <!-- Hamburger Menu (Mobile) -->
<!--      <div class="md:hidden">-->
<!--        <button id="menuBtn" class="focus:outline-none">-->
<!--          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">-->
<!--            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"-->
<!--              d="M4 6h16M4 12h16M4 18h16" />-->
<!--          </svg>-->
<!--        </button>-->
<!--      </div>-->

      <!-- Menu Items -->
<!--      <div id="navMenu"-->
<!--           class="hidden md:flex md:items-center space-x-6 text-sm font-medium">-->
<!--        <a href="#" class="flex items-center space-x-1 hover:text-gray-200">-->
<!--          <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">-->
<!--            <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z" />-->
<!--          </svg>-->
<!--          <span>Home</span>-->
<!--        </a>-->
<!--        <a href="#" class="flex items-center space-x-1 hover:text-gray-200">-->
<!--          <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">-->
<!--            <path d="M12 0L3 6v6c0 5.52 3.84 10.74 9 12 5.16-1.26 9-6.48 9-12V6l-9-6z"/>-->
<!--          </svg>-->
<!--          <span>Certificates</span>-->
<!--        </a>-->
<!--        <a href="#" class="flex items-center space-x-1 hover:text-gray-200">-->
<!--          <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">-->
<!--            <path d="M12 2L2 7v7c0 5.5 4.5 10 10 10s10-4.5 10-10V7l-10-5z"/>-->
<!--          </svg>-->
<!--          <span>Badges</span>-->
<!--        </a>-->
<!--        <a href="/logout" class="ml-auto flex items-center space-x-1 hover:text-gray-200">-->
<!--          <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">-->
<!--            <path d="M16 13v-2H7V7l-5 5 5 5v-4zM20 3h-8v2h8v14h-8v2h8c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2z"/>-->
<!--          </svg>-->
<!--          <span>Logout</span>-->
<!--        </a>-->
<!--      </div>-->
<!--    </div>-->

    <!-- Mobile Dropdown -->
<!--    <div id="mobileMenu" class="md:hidden hidden mt-3 space-y-2 text-sm font-medium">-->
<!--      <a href="#" class="block px-4 py-2 hover:bg-purple-600 rounded">Home</a>-->
<!--      <a href="#" class="block px-4 py-2 hover:bg-purple-600 rounded">Certificates</a>-->
<!--      <a href="#" class="block px-4 py-2 hover:bg-purple-600 rounded">Badges</a>-->
<!--      <a href="/logout" class="block px-4 py-2 hover:bg-purple-600 rounded">Logout</a>-->
<!--    </div>-->
<!--  </nav>-->
  
<!--  <script>-->
<!--    const menuBtn = document.getElementById('menuBtn');-->
<!--    const mobileMenu = document.getElementById('mobileMenu');-->
<!--    menuBtn.addEventListener('click', () => {-->
<!--      mobileMenu.classList.toggle('hidden');-->
<!--    });-->
<!--  </script>-->

    
<!--    <header class="bg-white border-b border-slate-200 shadow-sm fixed top-0 left-0 w-full z-50">-->
<!--    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">-->
<!--        <div class="flex items-center justify-between h-20">-->
            
<!--            <div class="flex-shrink-0">-->
<!--                <a href="/student">-->
<!--                    <img class="h-12 w-auto" src="/public/assets/images/aessas.png" alt="Amal Jyothi College of Engineering">-->
<!--                </a>-->
<!--            </div>-->

<!--            <div class="flex-shrink-0">-->
<!--                <a href="#"> <img class="h-12 w-auto" src="/public/assets/images/header_logo.png" alt="Academic Enterprise Solutions">-->
<!--                </a>-->
<!--            </div>-->

<!--        </div>-->
<!--    </div>-->
<!--</header>-->

<!--    <nav id="sidebar" class="hidden lg:flex bg-white h-full fixed top-0 left-0 z-20 flex-col border-r border-slate-200 transition-width duration-300 ease-in-out">-->
        
<!--        <div class="flex items-center p-5 border-b border-slate-200 h-[69px]">-->
<!--            <a href="/student" class="flex items-center gap-3 w-full overflow-hidden">-->
<!--                <img src="/public/assets/images/header_logo.png" alt="Logo" class="h-8 w-auto flex-shrink-0">-->
<!--                <span id="logo-text" class="font-bold text-xl text-slate-800 whitespace-nowrap transition-opacity duration-300">Amal Jyothi</span>-->
<!--            </a>-->
<!--        </div>-->

<!--        <ul class="flex-grow p-2">-->
<!--            <li>-->
<!--                <a href="/student" class="nav-item flex items-center gap-4 py-3 px-4 rounded-lg <?php echo ($currentPage === 'home') ? 'font-semibold text-primary bg-sidebar-active-bg' : 'text-slate-600 hover:bg-slate-100'; ?>">-->
<!--                    <i class="fas fa-home fa-fw text-lg flex-shrink-0"></i>-->
<!--                    <span class="nav-text whitespace-nowrap">Dashboard</span>-->
<!--                </a>-->
<!--            </li>-->
<!--            <li>-->
<!--                <a href="/upload_certificate" class="nav-item flex items-center gap-4 py-3 px-4 rounded-lg <?php echo ($currentPage === 'upload') ? 'font-semibold text-primary bg-sidebar-active-bg' : 'text-slate-600 hover:bg-slate-100'; ?>">-->
<!--                    <i class="fas fa-certificate fa-fw text-lg flex-shrink-0"></i>-->
<!--                    <span class="nav-text whitespace-nowrap">Upload Certificates</span>-->
<!--                </a>-->
<!--            </li>-->
<!--            <li>-->
<!--                <a href="/view_badges" class="nav-item flex items-center gap-4 py-3 px-4 rounded-lg <?php echo ($currentPage === 'badges') ? 'font-semibold text-primary bg-sidebar-active-bg' : 'text-slate-600 hover:bg-slate-100'; ?>">-->
<!--                    <i class="fas fa-award fa-fw text-lg flex-shrink-0"></i>-->
<!--                    <span class="nav-text whitespace-nowrap">My Badges</span>-->
<!--                </a>-->
<!--            </li>-->
<!--            <li>-->
<!--                <a href="/leaderboard" class="nav-item flex items-center gap-4 py-3 px-4 rounded-lg <?php echo ($currentPage === 'leaderboard') ? 'font-semibold text-primary bg-sidebar-active-bg' : 'text-slate-600 hover:bg-slate-100'; ?>">-->
<!--                    <i class="fas fa-trophy fa-fw text-lg flex-shrink-0"></i>-->
<!--                    <span class="nav-text whitespace-nowrap">Leaderboard</span>-->
<!--                </a>-->
<!--            </li>-->
<!--        </ul>-->

<!--        <div class="p-2 border-t border-slate-200">-->
<!--             <button id="sidebar-toggle" class="w-full flex items-center justify-center gap-4 text-slate-600 hover:text-primary p-3 rounded-lg hover:bg-slate-100 transition-colors">-->
<!--                 <i id="toggle-icon" class="fas fa-chevron-left transition-transform duration-300"></i>-->
<!--            </button>-->
<!--        </div>-->
<!--    </nav>-->

<!--    <div id="main-content" class="transition-all duration-300 ease-in-out pb-24 lg:pb-0">-->
    


   