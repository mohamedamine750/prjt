<?php
// Vérification de l'authentification admin (à adapter selon votre système)
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: ../index.php?action=admin_login');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Panel - Gaming</title>
    <link rel="icon" href="../../img/favicon.png">
    <link rel="stylesheet" href="../../view/FrontOffice/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../view/FrontOffice/css/animate.css">
    <link rel="stylesheet" href="../../view/FrontOffice/css/all.css">
    <link rel="stylesheet" href="../../view/FrontOffice/css/style.css">
    <style>
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        
        .sidebar-sticky {
            position: sticky;
            top: 0;
            height: 100vh;
            padding-top: 20px;
        }
        
        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 15px 20px;
            margin: 5px 0;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: white;
            background: rgba(255,255,255,0.1);
            transform: translateX(5px);
        }
        
        .sidebar .nav-link i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        
        .admin-header {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        
        .stats-card {
            background: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            margin-bottom: 25px;
            border-left: 4px solid #667eea;
        }
        
        .stats-card h3 {
            color: #667eea;
            margin-bottom: 10px;
        }
        
        .table-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            overflow: hidden;
        }
        
        .btn-admin {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            transition: all 0.3s ease;
        }
        
        .btn-admin:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
            color: white;
        }
        
        .action-buttons .btn {
            margin: 0 2px;
            padding: 5px 10px;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar">
                <div class="sidebar-sticky">
                    <div class="text-center mb-4">
                        <img src="../../img/logo.png" alt="Logo" style="max-width: 120px; background: white; padding: 10px; border-radius: 10px;">
                    </div>
                    
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>" href="dashboard.php">
                                <i class="fas fa-tachometer-alt"></i>
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'publications.php' ? 'active' : ''; ?>" href="publications.php">
                                <i class="fas fa-newspaper"></i>
                                Publications
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'commentaires.php' ? 'active' : ''; ?>" href="commentaires.php">
                                <i class="fas fa-comments"></i>
                                Commentaires
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../../index.php?action=admin_logout">
                                <i class="fas fa-sign-out-alt"></i>
                                Déconnexion
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main content -->
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
                <div class="admin-header pt-3">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                        <h1 class="h2"><?php echo $page_title ?? 'Admin Panel'; ?></h1>
                        <div class="btn-toolbar mb-2 mb-md-0">
                            <span class="text-muted">Connecté en tant qu'administrateur</span>
                        </div>
                    </div>
                </div>

                <!-- Content will be included here -->
                <?php echo $content; ?>
            </main>
        </div>
    </div>

    <script src="../../view/FrontOffice/js/jquery-1.12.1.min.js"></script>
    <script src="../../view/FrontOffice/js/bootstrap.min.js"></script>
    <script src="../../view/FrontOffice/js/all.js"></script>
</body>
</html>