<?php 
// Démarrer la session si pas déjà fait
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Vérifier admin
if(!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: /Web%20projet/Web%20projet/index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin - Gaming Community</title>
    <link rel="icon" href="/Web%20projet/Web%20projet/img/favicon.png">
    <!-- CHEMINS ABSOLUS -->
    <link rel="stylesheet" href="/Web%20projet/Web%20projet/view/FrontOffice/css/bootstrap.min.css">
    <link rel="stylesheet" href="/Web%20projet/Web%20projet/view/FrontOffice/css/all.css">
    <style>
        .admin-sidebar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 0;
        }
        .admin-sidebar .nav-link {
            color: #fff;
            padding: 15px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .admin-sidebar .nav-link:hover {
            background: rgba(255,255,255,0.1);
        }
        .admin-sidebar .nav-link.active {
            background: rgba(255,255,255,0.2);
        }
        .admin-content {
            padding: 30px;
            background: #f8f9fa;
            min-height: 100vh;
        }
        .stats-card {
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            color: white;
        }
        .bg-primary { background: linear-gradient(45deg, #667eea, #764ba2); }
        .bg-success { background: linear-gradient(45deg, #28a745, #20c997); }
        .bg-warning { background: linear-gradient(45deg, #ffc107, #fd7e14); }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 admin-sidebar">
                <div class="sidebar-sticky pt-3">
                    <h4 class="text-white text-center mb-4">Admin Gaming</h4>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="/Web%20projet/Web%20projet/index.php?action=admin_dashboard">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/Web%20projet/Web%20projet/index.php?action=admin_publications">
                                <i class="fas fa-newspaper"></i> Publications
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/Web%20projet/Web%20projet/index.php?action=admin_commentaires">
                                <i class="fas fa-comments"></i> Commentaires
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/Web%20projet/Web%20projet/index.php?action=admin_logout">
                                <i class="fas fa-sign-out-alt"></i> Déconnexion
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main content -->
            <div class="col-md-9 col-lg-10 admin-content"></div>