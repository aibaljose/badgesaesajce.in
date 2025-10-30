<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AES Badge Admin</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Google Fonts - Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="/public/assets/css/admin_style.css" rel="stylesheet">

    <style>
    :root {
        --header-height: 74px;
        --primary: #6A4C93;
        --primary-dark: #5a3f7d;
        --primary-light: rgba(255, 255, 255, 0.1);
        --surface-card: #ffffff;
        --text-primary: #2C3E50;
        --text-secondary: #64748B;
        --border-color: #E2E8F0;
    }

    body {
        font-family: 'Inter', sans-serif;
        background-color: #F8FAFC;
        min-height: 100vh;
        margin: 0;
        padding-top: var(--header-height);
    }

    .app-header {
        height: var(--header-height);
        background: linear-gradient(87deg, var(--primary) 0, #825fa9 100%);
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 1000;
        box-shadow: 0 4px 20px 0 rgba(0,0,0,.14), 0 7px 10px -5px rgba(106, 76, 147, 0.4);
    }

    .header-container {
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 1.5rem;
        max-width: 1480px;
        margin: 0 auto;
    }

    .header-brand {
        display: flex;
        align-items: center;
        gap: 1rem;
        text-decoration: none;
    }

    .brand-logo {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        color: white;
        font-size: 1.25rem;
    }

    .brand-text {
        font-weight: 600;
        font-size: 1.125rem;
        color: white;
        margin: 0;
    }

    .header-nav {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin: 0 auto;
        padding: 0 2rem;
    }

    .nav-link {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 0.875rem;
        color: rgba(255, 255, 255, 0.9) !important;
        text-decoration: none;
        font-weight: 500;
        font-size: 0.875rem;
        border-radius: 8px;
        transition: all 0.2s ease;
    }

    .nav-link:hover {
        color: white !important;
        background: var(--primary-light);
    }

    .nav-link.active {
        color: white !important;
        background: var(--primary-light);
    }

    .nav-link i {
        font-size: 1rem;
    }

    .header-actions {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .action-button {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        color: rgba(255, 255, 255, 0.9);
        background: transparent;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .action-button:hover {
        color: white;
        background: var(--primary-light);
    }

    .user-menu {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.5rem;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s ease;
        background: var(--primary-light);
    }

    .user-menu:hover {
        background: rgba(255, 255, 255, 0.2);
    }

    .user-avatar {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        object-fit: cover;
        border: 2px solid rgba(255, 255, 255, 0.3);
    }

    .user-info {
        display: none;
    }

    @media (min-width: 768px) {
        .user-info {
            display: block;
        }

        .user-name {
            font-weight: 600;
            font-size: 0.875rem;
            color: white;
            margin: 0;
        }

        .user-role {
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.7);
            margin: 0;
        }
    }

    .dropdown-menu {
        padding: 0.5rem;
        border: none;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        border-radius: 12px;
        min-width: 200px;
        margin-top: 0.5rem;
    }

    .dropdown-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1rem;
        color: var(--text-primary);
        font-weight: 500;
        font-size: 0.875rem;
        border-radius: 8px;
        transition: all 0.2s ease;
    }

    .dropdown-item:hover {
        background: var(--primary-light);
        color: var(--primary);
    }

    .dropdown-item i {
        font-size: 1rem;
        color: var(--text-secondary);
        transition: all 0.2s ease;
    }

    .dropdown-item:hover i {
        color: var(--primary);
    }

    .dropdown-divider {
        margin: 0.5rem 0;
        border-color: var(--border-color);
        opacity: 0.5;
    }

    .main-content {
        padding: 2rem 1.5rem;
        max-width: 1480px;
        margin: 0 auto;
    }

    @media (max-width: 768px) {
        .header-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: var(--primary);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding: 0.75rem;
            justify-content: space-around;
            z-index: 1000;
        }

        .nav-link {
            flex-direction: column;
            gap: 0.25rem;
            font-size: 0.75rem;
            padding: 0.5rem;
        }

        .nav-link i {
            font-size: 1.25rem;
        }

        .nav-text {
            font-size: 0.75rem;
        }

        .main-content {
            padding-bottom: 5rem;
        }
    }
    </style>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

    <script>
        console.log(<?=__authUser['staff_name']?>);
    </script>
</head>

<body>
    <header class="app-header">
        <div class="header-container">
            <a href="/admin/dashboard" class="header-brand">
                <div class="brand-logo">
                    <i class="fas fa-award"></i>
                </div>
                <h1 class="brand-text">AES Badge Admin</h1>
            </a>

            <nav class="header-nav">
                <a href="/admin/dashboard" class="nav-link <?= $currentPage === 'dashboard' ? 'active' : '' ?>">
                    <i class="fas fa-home"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
                <a href="/admin/badges" class="nav-link <?= $currentPage === 'badges' ? 'active' : '' ?>">
                    <i class="fas fa-award"></i>
                    <span class="nav-text">Badges</span>
                </a>
                <a href="/admin/departments" class="nav-link <?= $currentPage === 'departments' ? 'active' : '' ?>">
                    <i class="fas fa-building"></i>
                    <span class="nav-text">Departments</span>
                </a>
            </nav>

            <div class="header-actions">
                <button class="action-button" title="Notifications">
                    <i class="fas fa-bell"></i>
                </button>

                <div class="dropdown">
                    <div class="user-menu" data-bs-toggle="dropdown">
                        <img src="<?=__authUser['staff_photo']?>" alt="User" class="user-avatar">
                        <div class="user-info">
                            <p class="user-name"><?=__authUser['staff_name']?></p>
                            <p class="user-role">Administrator</p>
                        </div>
                    </div>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="/admin/profile">
                                <i class="fas fa-user"></i>
                                Profile
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="/admin/settings">
                                <i class="fas fa-cog"></i>
                                Settings
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item text-danger" href="/logout">
                                <i class="fas fa-sign-out-alt"></i>
                                Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </header>

    <main class="main-content">
</body>

</html>