<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


// Initialize API Methods to get auth user
require_once $_SERVER['DOCUMENT_ROOT'] . '/api_services/APIMethods.php';
$api = new APIMethods();
$authUser = $api->authUser();
// echo json_encode($authUser);

if (!$authUser || !$authUser['status']) {
    // Redirect to login if not authenticated
    header('Location: /login');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="/public/assets/css/teacher-style.css" rel="stylesheet">
    <link rel="stylesheet" href="/public/assets/css/teacher-cert-modal.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
        // Pass authenticated user data to JavaScript
        if (typeof window.__authUser === 'undefined') {
            window.__authUser = <?php echo json_encode($authUser); ?>;
            console.log(__authUser);
        }
</script>
    <!-- 
    <style>
    /* Compact navbar and responsive sidebar support */
    .navbar { padding: .35rem 0.75rem; }
    .navbar .navbar-brand img { height: 32px; margin-right: 8px; }
    .navbar .nav-link { transition: background-color 0.18s ease, color 0.18s ease; padding: .35rem .6rem; font-size: .95rem; }
    .navbar .nav-link:hover { background-color: rgba(255,255,255,0.12); color: #fff; }
    .navbar .nav-link.active { box-shadow: 0 2px 6px rgba(0,0,0,0.06); }

    /* Add a small toggle for the mobile sidebar */
    #sidebarToggle { border: 0; background: transparent; color: rgba(255,255,255,0.95); }

    /* Small devices: make navbar denser */
    @media (max-width: 768px) {
        .navbar { padding: .25rem .5rem; }
        .navbar .nav-link { padding: .25rem .45rem; font-size: .92rem; }
    }
    </style>
</head>
<body>
   <nav class="navbar navbar-expand-lg navbar-dark shadow-sm py-2" style="background-color: #6c4298; border-bottom-left-radius: 0.5rem; border-bottom-right-radius: 0.5rem;">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center fw-semibold" href="#">
            <img src="/public/assets/images/header_logo.png" alt="Logo" style="height: 40px; margin-right: 10px;">
            <span class="fs-5">AES Digital Badge System</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <button id="sidebarToggle" class="d-lg-none btn btn-link text-white ms-2 p-0" title="Toggle sidebar">
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto gap-3">
                <li class="nav-item">
                    <a class="nav-link px-3 rounded <?php echo ($currentPage == 'home') ? 'active bg-white text-dark fw-semibold' : ''; ?>" href="home.php">
                        <i class="fas fa-home me-1"></i> Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3 rounded <?php echo ($currentPage == 'certificates') ? 'active bg-white text-dark fw-semibold' : ''; ?>" href="certificates.php">
                        <i class="fas fa-certificate me-1"></i> Certificates
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3 rounded <?php echo ($currentPage == 'badges') ? 'active bg-white text-dark fw-semibold' : ''; ?>" href="/teacher/badges/">
                        <i class="fas fa-award me-1"></i> Badges
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link px-3 rounded" href="/logout">
                        <i class="fas fa-sign-out-alt me-1"></i> Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

</body>
</html> -->
   <header class=" position-fixed w-100 py-1 mb-3" style="top: 0; z-index: 1050;background-color:white; color: black;height:60px;">
   <div class="container-fluid px-3 py-2">
       <div class="d-flex justify-content-between align-items-center">
           <!-- Left Section -->
           <div class="d-flex align-items-center">
               <!-- Sidebar toggle button intentionally removed; stray closing tag fixed -->
               <h1 class="h4 fw-bold mb-0"></h1>
               <img src="https://jobs.amaljyothi.ac.in/public/assets/img/logo/ajce-logo.png" style="height:40px;">
           </div>
           
            <!-- Right Section -->
           <div class="dropdown position-static">
               <button class="btn dropdown-toggle d-flex align-items-center border-0 shadow-none" type="button" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false" id="profileDropdown">
                   <div class="me-2 me-md-2">
                       <img src="<?php echo htmlspecialchars($authUser['staff_photo'] ?? ''); ?>" 
                            alt="User Avatar" 
                            class="rounded-circle" 
                            style="width: 32px; height: 32px; object-fit: cover;">
                   </div>
                   <span class=" small fw-medium me-1 d-none d-md-inline">
                       <?php echo htmlspecialchars($authUser['staff_name'] ?? 'User'); ?>
                   </span>
               </button>
               <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="profileDropdown" style="z-index: 2000;">
                   <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Profile</a></li>
                   <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Settings</a></li>
                   <li><hr class="dropdown-divider"></li>
                   <li><a class="dropdown-item" href="#"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
               </ul>
           </div>
       </div>
   </div>
</header>