<?php
session_start();

require_once 'model/Database.php';
require_once 'model/Publication.php';
require_once 'model/Commentaire.php';
require_once 'controller/PublicationController.php';
require_once 'controller/CommentaireController.php';
require_once 'controller/AdminController.php';



// CORRECTION: Connexion DB d'abord, puis création des contrôleurs
$database = new Database();
$bd = $database->getConnection();

if (!$bd) {
    die("Erreur de connexion à la base de données");
}

// CORRECTION: Créer les contrôleurs APRÈS la connexion DB
$publicationController = new PublicationController($bd);
$commentaireController = new CommentaireController($bd);
$adminController = new AdminController($bd); // Déplacé après $bd

$action = isset($_GET['action']) ? $_GET['action'] : 'index';

switch($action) {
    case 'index':
        $publications = $publicationController->index();
        break;
    

  
        
   case 'create_publication':
    if ($_POST && isset($_POST['contenu'])) {

        $id_utilisateur = 1; 
        $contenu = trim($_POST['contenu']);

        $media_url = null;
        $media_type = null;

        // ----- TRAITEMENT UPLOAD -----
        if (isset($_FILES['media_file']) && $_FILES['media_file']['error'] === UPLOAD_ERR_OK) {

            $uploadDir = 'uploads/publications/';

            // Créer le dossier s'il n'existe pas
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $fileName = time() . '_' . basename($_FILES['media_file']['name']);
            $uploadFile = $uploadDir . $fileName;

            // Vérification du type MIME
            $allowedImageTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
            $allowedVideoTypes = ['video/mp4', 'video/quicktime', 'video/avi'];

            $fileType = mime_content_type($_FILES['media_file']['tmp_name']);

            if (in_array($fileType, $allowedImageTypes)) {
                $media_type = 'image';
            } elseif (in_array($fileType, $allowedVideoTypes)) {
                $media_type = 'video';
            } else {
                $_SESSION['message'] = "Invalid file type. Please upload an image or video.";
                $_SESSION['message_type'] = "error";
                header("Location: index.php");
                exit;
            }

            // Déplacement du fichier
            if (move_uploaded_file($_FILES['media_file']['tmp_name'], $uploadFile)) {
                $media_url = $fileName;
            } else {
                $_SESSION['message'] = "Error uploading file.";
                $_SESSION['message_type'] = "error";
                header("Location: index.php");
                exit;
            }
        }
        // ----- FIN UPLOAD -----

        // Enregistrement BD
        if ($publicationController->create($id_utilisateur, $contenu, $media_url, $media_type)) {
            $_SESSION['message'] = "Publication créée avec succès!";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = "Erreur lors de la création de la publication.";
            $_SESSION['message_type'] = "error";
        }
    }

    header("Location: index.php");
    exit;
    break;

    case 'create_comment':
        if($_POST && isset($_POST['id_publication']) && isset($_POST['contenu'])) {
            $id_publication = intval($_POST['id_publication']);
            $id_utilisateur = 1; 
            $contenu = trim($_POST['contenu']);
            
            if($commentaireController->create($id_publication, $id_utilisateur, $contenu)) {
                $_SESSION['message'] = "Commentaire ajouté avec succès!";
                $_SESSION['message_type'] = "success";
            } else {
                $_SESSION['message'] = "Erreur lors de l'ajout du commentaire.";
                $_SESSION['message_type'] = "error";
            }
        }
        header("Location: index.php");
        exit;
        break;

    case 'edit_comment_form':
        if(isset($_GET['id'])) {
            $commentaire = new Commentaire($bd);
            $commentaire->id_commentaire = intval($_GET['id']);
            if($commentaire->readOne()) {
                ?>
                <!DOCTYPE html>
                <html lang="fr">
                <head>
                    <meta charset="utf-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
                    <title>Edit Comment - Gaming</title>
                    <link rel="icon" href="img/favicon.png">
                    <link rel="stylesheet" href="view/FrontOffice/css/bootstrap.min.css">
                    <link rel="stylesheet" href="view/FrontOffice/css/animate.css">
                    <link rel="stylesheet" href="view/FrontOffice/css/owl.carousel.min.css">
                    <link rel="stylesheet" href="view/FrontOffice/css/all.css">
                    <link rel="stylesheet" href="view/FrontOffice/css/flaticon.css">
                    <link rel="stylesheet" href="view/FrontOffice/css/themify-icons.css">
                    <link rel="stylesheet" href="view/FrontOffice/css/magnific-popup.css">
                    <link rel="stylesheet" href="view/FrontOffice/css/slick.css">
                    <link rel="stylesheet" href="view/FrontOffice/css/style.css">
                    <style>
                        .edit-form-container {
                            max-width: 600px;
                            margin: 100px auto;
                            padding: 30px;
                            background: rgba(30, 30, 50, 0.9);
                            border-radius: 10px;
                            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
                        }
                        
                        .edit-form-container h2 {
                            color: #6c5ce7;
                            margin-bottom: 20px;
                            text-align: center;
                        }
                        
                        .edit-form-container textarea {
                            width: 100%;
                            min-height: 150px;
                            padding: 15px;
                            background: rgba(255, 255, 255, 0.1);
                            border: 1px solid rgba(108, 92, 231, 0.3);
                            border-radius: 5px;
                            color: white;
                            margin-bottom: 20px;
                        }
                        
                        .form-actions {
                            display: flex;
                            justify-content: space-between;
                        }
                    </style>
                </head>
                <body class="body_bg">
                    <div class="edit-form-container">
                        <h2>Modifier le commentaire</h2>
                        <form method="POST" action="index.php?action=update_comment">
                            <input type="hidden" name="id_commentaire" value="<?php echo $commentaire->id_commentaire; ?>">
                            <textarea name="contenu" placeholder="Modifier votre commentaire..."><?php echo htmlspecialchars($commentaire->contenu); ?></textarea>
                            <div class="form-actions">
                                <a href="index.php" class="btn_1">Annuler</a>
                                <button type="submit" class="btn_1">Enregistrer</button>
                            </div>
                        </form>
                    </div>
                </body>
                </html>
                <?php
                exit;
            } else {
                $_SESSION['message'] = "Commentaire non trouvé!";
                $_SESSION['message_type'] = "error";
                header("Location: index.php");
                exit;
            }
        }
        break;
        
    case 'update_comment':
        if($_POST && isset($_POST['id_commentaire']) && isset($_POST['contenu'])) {
            $id_commentaire = intval($_POST['id_commentaire']);
            $contenu = trim($_POST['contenu']);
            
            $commentaireController = new CommentaireController($bd);
            if($commentaireController->update($id_commentaire, $contenu)) {
                $_SESSION['message'] = "Commentaire modifié avec succès!";
                $_SESSION['message_type'] = "success";
            } else {
                $_SESSION['message'] = "Erreur lors de la modification du commentaire.";
                $_SESSION['message_type'] = "error";
            }
        }
        header("Location: index.php");
        exit;
     break;
        
    case 'delete_comment':
        if(isset($_GET['id'])) {
            $id_commentaire = intval($_GET['id']);
            $commentaireController = new CommentaireController($bd);
            if($commentaireController->delete($id_commentaire)) {
                $_SESSION['message'] = "Commentaire supprimé avec succès!";
                $_SESSION['message_type'] = "success";
            } else {
                $_SESSION['message'] = "Erreur lors de la suppression du commentaire.";
                $_SESSION['message_type'] = "error";
            }
        }
        header("Location: index.php");
        exit;
        break;

    case 'update_publication':
    if($_POST && isset($_POST['id_publication']) && isset($_POST['contenu'])) {
        $id_publication = intval($_POST['id_publication']);
        $contenu = trim($_POST['contenu']);
        
        // Handle media file upload for update
        $media_url = null;
        $media_type = null;
        
        if(isset($_FILES['media_file']) && $_FILES['media_file']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/publications/';
            
            if(!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            
            $fileName = time() . '_' . basename($_FILES['media_file']['name']);
            $uploadFile = $uploadDir . $fileName;
            
            // Check file type
            $allowedImageTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
            $allowedVideoTypes = ['video/mp4', 'video/quicktime', 'video/avi'];
            $fileType = mime_content_type($_FILES['media_file']['tmp_name']);
            
            if(in_array($fileType, $allowedImageTypes)) {
                $media_type = 'image';
            } elseif(in_array($fileType, $allowedVideoTypes)) {
                $media_type = 'video';
            } else {
                $_SESSION['message'] = "Invalid file type. Please upload an image or video.";
                $_SESSION['message_type'] = "error";
                header("Location: index.php");
                exit;
            }
            
            if(move_uploaded_file($_FILES['media_file']['tmp_name'], $uploadFile)) {
                $media_url = $fileName;
            }
        }
    
        if($publicationController->update($id_publication, $contenu, $media_url, $media_type)) {
            $_SESSION['message'] = "Publication modifiée avec succès!";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = "Erreur lors de la modification de la publication.";
            $_SESSION['message_type'] = "error";
        }
    }
    header("Location: index.php");
    exit;
    break;


    // CORRECTION: Routes admin - BackOffice
   case 'admin_dashboard':
        $adminController->dashboard();
        break;
    case 'admin_publications':
        $adminController->publications();
        break;
    case 'admin_create_publication':
        $adminController->createPublication();
        break;
    case 'admin_edit_publication':
        $adminController->editPublication();
        break;
    case 'admin_delete_publication':
        $adminController->deletePublication();
        break;
    case 'admin_commentaires':
        $adminController->commentaires();
        break;
    case 'admin_delete_commentaire':
        $adminController->deleteCommentaire();
        break;
    case 'admin_login':
        $adminController->login();
        break;
    case 'admin_logout':
        $adminController->logout();
        break;//
        
    case 'delete_publication':
        if(isset($_GET['id'])) {
            $id_publication = intval($_GET['id']);
            if($publicationController->delete($id_publication)) {
                $_SESSION['message'] = "Publication supprimée avec succès!";
                $_SESSION['message_type'] = "success";
            } else {
                $_SESSION['message'] = "Erreur lors de la suppression de la publication.";
                $_SESSION['message_type'] = "error";
            }
        }
        header("Location: index.php");
        exit;
        break;
        
    case 'edit_publication_form':
        if(isset($_GET['id'])) {
            $publication = new Publication($bd);
            $publication->id_publication = intval($_GET['id']);
            if($publication->readOne()) {
            ?>
            <!DOCTYPE html>
            <html lang="fr">
            <head>
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
                <title>Edit Publication - Gaming</title>
                <link rel="icon" href="img/favicon.png">
                <link rel="stylesheet" href="view/FrontOffice/css/bootstrap.min.css">
                <link rel="stylesheet" href="view/FrontOffice/css/animate.css">
                <link rel="stylesheet" href="view/FrontOffice/css/owl.carousel.min.css">
                <link rel="stylesheet" href="view/FrontOffice/css/all.css">
                <link rel="stylesheet" href="view/FrontOffice/css/flaticon.css">
                <link rel="stylesheet" href="view/FrontOffice/css/themify-icons.css">
                <link rel="stylesheet" href="view/FrontOffice/css/magnific-popup.css">
                <link rel="stylesheet" href="view/FrontOffice/css/slick.css">
                <link rel="stylesheet" href="view/FrontOffice/css/style.css">
                <style>
                    .edit-form-container {
                        max-width: 600px;
                        margin: 100px auto;
                        padding: 30px;
                        background: rgba(30, 30, 50, 0.9);
                        border-radius: 10px;
                        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
                    }
                    
                    .edit-form-container h2 {
                        color: #6c5ce7;
                        margin-bottom: 20px;
                        text-align: center;
                    }
                    
                    .edit-form-container textarea {
                        width: 100%;
                        min-height: 150px;
                        padding: 15px;
                        background: rgba(255, 255, 255, 0.1);
                        border: 1px solid rgba(108, 92, 231, 0.3);
                        border-radius: 5px;
                        color: white;
                        margin-bottom: 20px;
                    }
                    
                    .form-actions {
                        display: flex;
                        justify-content: space-between;
                    }
                </style>
            </head>
            <body class="body_bg">
                <div class="edit-form-container">
                    <h2>Modifier la publication</h2>
                    <form method="POST" action="index.php?action=update_publication">
                        <input type="hidden" name="id_publication" value="<?php echo $publication->id_publication; ?>">
                        <textarea name="contenu" placeholder="Modifier votre publication..."><?php echo htmlspecialchars($publication->contenu); ?></textarea>
                        <div class="form-actions">
                            <a href="index.php" class="btn_1">Annuler</a>
                            <button type="submit" class="btn_1">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </body>
            </html>
            <?php
            exit;
        } else {
            $_SESSION['message'] = "Publication non trouvée!";
            $_SESSION['message_type'] = "error";
            header("Location: index.php");
            exit;
        }
    }
    break;

    default:
        $publications = $publicationController->index();
        break;
}


// CORRECTION: Vérifier si c'est une requête admin pour éviter d'inclure le template front office
$isAdminRoute = strpos($action, 'admin_') === 0;

//vérif

$isAdminRoute = strpos($action, 'admin_') === 0;

if (!$isAdminRoute) {
    // Inclure le template front office normal
    ?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Community - Gaming</title>
        <link rel="icon" href="img/favicon.png">
        <link rel="stylesheet" href="view/FrontOffice/css/bootstrap.min.css">
        <link rel="stylesheet" href="view/FrontOffice/css/animate.css">
        <link rel="stylesheet" href="view/FrontOffice/css/owl.carousel.min.css">
        <link rel="stylesheet" href="view/FrontOffice/css/all.css">
        <link rel="stylesheet" href="view/FrontOffice/css/flaticon.css">
        <link rel="stylesheet" href="view/FrontOffice/css/themify-icons.css">
        <link rel="stylesheet" href="view/FrontOffice/css/magnific-popup.css">
        <link rel="stylesheet" href="view/FrontOffice/css/slick.css">
        <link rel="stylesheet" href="view/FrontOffice/css/style.css">
        <style>
            /* Votre CSS existant */
        </style>
    </head>
    <body class="body_bg">
        <?php include 'view/communauté.php'; ?>
        
        
        <script src="js/jquery-1.12.1.min.js"></script>
        <script src="js/popper.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/jquery.magnific-popup.js"></script>
        <script src="js/swiper.min.js"></script>
        <script src="js/masonry.pkgd.js"></script>
        <script src="js/owl.carousel.min.js"></script>
        <script src="js/jquery.nice-select.min.js"></script>
        <script src="js/slick.min.js"></script>
        <script src="js/jquery.counterup.min.js"></script>
        <script src="js/waypoints.min.js"></script>
        <script src="js/contact.js"></script>
        <script src="js/jquery.ajaxchimp.min.js"></script>
        <script src="js/jquery.form.js"></script>
        <script src="js/jquery.validate.min.js"></script>
        <script src="js/mail-script.js"></script>
        <script src="js/custom.js"></script>
    </body>
    </html>
    
    <?php
}
?>