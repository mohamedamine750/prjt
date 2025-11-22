<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../model/Database.php';
require_once '../model/Commentaire.php';
require_once '../model/Publication.php';

$database = new Database();
$bd = $database->getConnection();
$commentaire = new Commentaire($bd);
$publication = new Publication($bd);

$is_edit = false;
$publication_titre = "";
$publication_id = "";

if(isset($_GET['id']) && !empty($_GET['id'])) {
    $is_edit = true;
    $commentaire->id_commentaire = intval($_GET['id']);
    
    if(method_exists($commentaire, 'readOne') && $commentaire->readOne()) {
        $publication_id = $commentaire->id_publication;
        
        $publication->id_publication = $publication_id;
        if($publication->readOne()) {
            $publication_titre = substr($publication->contenu, 0, 100) . (strlen($publication->contenu) > 100 ? "..." : "");
        }
    }
} else {
    $publication_id = isset($_GET['publication_id']) ? intval($_GET['publication_id']) : 0;
    
    if($publication_id > 0) {
        $publication->id_publication = $publication_id;
        if($publication->readOne()) {
            $publication_titre = substr($publication->contenu, 0, 100) . (strlen($publication->contenu) > 100 ? "..." : "");
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $is_edit ? 'Edit Comment' : 'New Comment'; ?> - Gaming</title>
    <link rel="icon" href="../img/favicon.png">
    <link rel="stylesheet" href="../view/FrontOffice/css/bootstrap.min.css">
    <link rel="stylesheet" href="../view/FrontOffice/css/animate.css">
    <link rel="stylesheet" href="../view/FrontOffice/css/owl.carousel.min.css">
    <link rel="stylesheet" href="../view/FrontOffice/css/all.css">
    <link rel="stylesheet" href="../view/FrontOffice/css/flaticon.css">
    <link rel="stylesheet" href="../view/FrontOffice/css/themify-icons.css">
    <link rel="stylesheet" href="../view/FrontOffice/css/magnific-popup.css">
    <link rel="stylesheet" href="../view/FrontOffice/css/slick.css">
    <link rel="stylesheet" href="../view/FrontOffice/css/style.css">
</head>
<body>

<header class="main_menu single_page_menu">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-12">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <a class="navbar-brand" href="../index.php"> 
                        <img src="../img/logo.png" alt="logo"> 
                    </a>
                </nav>
            </div>
        </div>
    </div>
</header>

<section class="breadcrumb breadcrumb_bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb_iner text-center">
                    <div class="breadcrumb_iner_item">
                        <h2><?php echo $is_edit ? 'Edit Comment' : 'New Comment'; ?></h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="community_section section_padding">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="create_post_card">
                    <?php if(!empty($publication_titre)): ?>
                    <div class="publication-context mb-4 p-3 bg-light rounded">
                        <h6>Publication :</h6>
                        <p class="mb-0 text-muted">"<?php echo htmlspecialchars($publication_titre); ?>"</p>
                    </div>
                    <?php endif; ?>

                    <form id="commentForm" method="POST" action="../index.php?action=<?php echo $is_edit ? 'update_comment' : 'create_comment'; ?>">
                        <?php if($is_edit): ?>
                            <input type="hidden" name="id_commentaire" value="<?php echo $commentaire->id_commentaire; ?>">
                        <?php endif; ?>

                        <input type="hidden" name="id_publication" value="<?php echo htmlspecialchars($publication_id); ?>">

                        <div class="form-group">
                            <label for="contenu" class="form-label">
                                <strong><?php echo $is_edit ? 'Edit your comment' : 'Write your comment'; ?></strong>
                            </label>
                            <textarea class="form-control" id="contenu" name="contenu" rows="4" 
                                      placeholder="Share your thoughts..."><?php echo $is_edit ? htmlspecialchars($commentaire->contenu) : ''; ?></textarea>
                            <div id="commentError" class="text-danger small mt-1" style="display: none;"></div>
                        </div>

                        <div class="form-group text-right">
                            <a href="../index.php" class="btn btn-secondary mr-2">Cancel</a>
                            <button type="submit" class="btn_1 btn_small">
                                <i class="fas fa-<?php echo $is_edit ? 'edit' : 'comment'; ?>"></i>
                                <?php echo $is_edit ? 'Update Comment' : 'Post Comment'; ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<footer class="footer_part black">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="copyright_text">
                    <P>Copyright &copy;<?php echo date('Y'); ?> All rights reserved</P>
                </div>
            </div>
        </div>
    </div>
</footer>

<script src="../view/FrontOffice/js/jquery-1.12.1.min.js"></script>
<script src="../view/FrontOffice/js/bootstrap.min.js"></script>

<script>
$(document).ready(function() {
    $('#commentForm').on('submit', function(e) {
        const content = $('#contenu').val().trim();
        const errorDiv = $('#commentError');
        
        errorDiv.hide().text('');
        
        if (content === '') {
            e.preventDefault();
            errorDiv.text('Please enter a comment.').show();
            $('#contenu').focus();
            return false;
        }
        
        if (content.length < 2) {
            e.preventDefault();
            errorDiv.text('Comment must be at least 2 characters long.').show();
            $('#contenu').focus();
            return false;
        }
        
        return true;
    });
});
</script>
</body>
</html>