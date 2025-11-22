<!doctype html>
<html lang="zxx">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Community - Gaming</title>
    <link rel="icon" href="img/favicon.png">

    <link rel="stylesheet" href="FrontOffice/css/bootstrap.min.css">
    <link rel="stylesheet" href="FrontOffice/css/animate.css">
    <link rel="stylesheet" href="FrontOffice/css/owl.carousel.min.css">
    <link rel="stylesheet" href="FrontOffice/css/all.css">
    <link rel="stylesheet" href="FrontOffice/css/flaticon.css">
    <link rel="stylesheet" href="FrontOffice/css/themify-icons.css">
    <link rel="stylesheet" href="FrontOffice/css/magnific-popup.css">
    <link rel="stylesheet" href="FrontOffice/css/slick.css">
    <link rel="stylesheet" href="FrontOffice/css/style.css">
    <style>
        .publication-media {
            margin-top: 15px;
            text-align: center;
        }
        
        .publication-media img {
            max-width: 100%;
            max-height: 400px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        
        .publication-media video {
            max-width: 100%;
            max-height: 400px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        
        .create-post-btn {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
<header class="main_menu single_page_menu">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-12">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <a class="navbar-brand" href="index.html"> 
                        <img src="img/logo.png" alt="logo"> 
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="menu_icon"><i class="fas fa-bars"></i></span>
                    </button>

                    <div class="collapse navbar-collapse main-menu-item" id="navbarSupportedContent">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="index.html">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="mission.html">Missions</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="index.php">Community</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="evenement.html">Events</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="BoutiqueInventaire.html">Boutique & Inventaire</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="profile.html">Profile</a>
                            </li>
                        </ul>
                    </div>
                    <div class="user_profile">
                        <a href="profile.html" class="btn_1 d-none d-sm-block">
                            <i class="far fa-user"></i> My Profile
                        </a>
                    </div>
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
                        <h2>Community</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="community_section section_padding">
    <div class="container">
        <?php if(isset($_SESSION['message'])): ?>
            <div class="alert alert-<?php echo $_SESSION['message_type'] == 'success' ? 'success' : 'danger'; ?> alert-dismissible fade show">
                <?php echo $_SESSION['message']; ?>
                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
            <?php unset($_SESSION['message'], $_SESSION['message_type']); ?>
        <?php endif; ?>
        
        <div class="row">
            <div class="col-lg-8">
                <div class="create-post-btn text-right mb-4">
                    <a href="view/publication_form.php" class="btn_1">
                        <i class="fas fa-plus"></i> Create New Post
                    </a>
                </div>

                <div class="posts_feed">
                    <?php if(empty($publications)): ?>
                        <div class="alert alert-info text-center">
                            <h5>No posts yet</h5>
                            <p>Be the first to share your gaming experience!</p>
                        </div>
                    <?php else: ?>
                        <?php foreach($publications as $publication): ?>
                            <div class="post_card mb-4">
                                <div class="post_header">
                                    <div class="post_author">
                                        <img src="img/avatar2.png" alt="avatar" class="author_avatar">
                                        <div class="author_info">
                                            <h6><?php echo htmlspecialchars($publication['nom'] ?? 'Anonymous'); ?></h6>
                                            <small><?php echo date('F j, Y g:i A', strtotime($publication['date_publication'])); ?></small>
                                        </div>
                                    </div>
                                    <div class="post_actions_dropdown">
                                        <div class="dropdown">
                                            <i class="fas fa-ellipsis-h" data-toggle="dropdown"></i>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="index.php?action=edit_publication_form&id=<?php echo $publication['id_publication']; ?>">Modifier</a>
                                                <a class="dropdown-item text-danger" href="index.php?action=delete_publication&id=<?php echo $publication['id_publication']; ?>" onclick="return confirm('Are you sure?')">Supprimer</a>
                                                <a class="dropdown-item" href="#">Report</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="post_content">
                                    <p><?php echo nl2br(htmlspecialchars($publication['contenu'])); ?></p>
                                    
                                    <!-- AFFICHAGE DES MÉDIAS -->
                                    <?php if(!empty($publication['media_url'])): ?>
                                        <div class="publication-media mt-3">
                                            <?php if($publication['media_type'] == 'image'): ?>
                                                <img src="uploads/publications/<?php echo htmlspecialchars($publication['media_url']); ?>" 
                                                     alt="Publication image" 
                                                     class="img-fluid">
                                            <?php elseif($publication['media_type'] == 'video'): ?>
                                                <video controls class="img-fluid">
                                                    <source src="uploads/publications/<?php echo htmlspecialchars($publication['media_url']); ?>" 
                                                            type="video/mp4">
                                                    Your browser does not support the video tag.
                                                </video>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="post_stats">
                                    <span class="stat_item"><i class="far fa-heart"></i> 24</span>
                                    <span class="stat_item"><i class="far fa-comment"></i> <?php echo count($publication['commentaires'] ?? []); ?></span>
                                    <span class="stat_item"><i class="fas fa-share"></i> 3</span>
                                </div>
                                <div class="post_comments">
                                    <form class="commentForm" data-publication-id="<?php echo $publication['id_publication']; ?>">
                                        <div class="comment_input mb-3">
                                            <input type="text" class="form-control comment-content" placeholder="Write a comment...">
                                            <div class="comment-error text-danger small mt-1" style="display: none;"></div>
                                        </div>
                                    </form>
                                    <div class="comments_list">
                                        <?php foreach(($publication['commentaires'] ?? []) as $commentaire): ?>
                                            <div class="comment_item">
                                                <img src="img/avatar3.png" alt="avatar" class="comment_avatar">
                                                <div class="comment_content">
                                                    <h6><?php echo htmlspecialchars($commentaire['nom'] ?? 'Anonymous'); ?></h6>
                                                    <p><?php echo htmlspecialchars($commentaire['contenu']); ?></p>
                                                    <small><?php echo date('F j, Y g:i A', strtotime($commentaire['date_commentaire'])); ?></small>
                                                    <div class="comment-actions mt-2">
                                                        <a href="index.php?action=edit_comment_form&id=<?php echo $commentaire['id_commentaire']; ?>" class="btn btn-sm btn-outline-primary">Modifier</a>
                                                        <a href="index.php?action=delete_comment&id=<?php echo $commentaire['id_commentaire']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Supprimer</a>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="community_stats_card mb-4">
                    <h4 class="widget_title">Community Stats</h4>
                    <div class="stats_grid">
                        <div class="stat_item text-center">
                            <h5>12.5K</h5>
                            <p>Active Players</p>
                        </div>
                        <div class="stat_item text-center">
                            <h5>856</h5>
                            <p>Online Now</p>
                        </div>
                        <div class="stat_item text-center">
                            <h5>324</h5>
                            <p>Teams</p>
                        </div>
                    </div>
                </div>

                <div class="top_players_card mb-4">
                    <h4 class="widget_title">Top Players</h4>
                    <div class="players_list">
                        <div class="player_item">
                            <div class="player_rank">1</div>
                            <img src="img/avatar7.png" alt="avatar" class="player_avatar">
                            <div class="player_info">
                                <h6>DragonKing</h6>
                                <small>Level 50</small>
                            </div>
                            <div class="player_score">25,480 XP</div>
                        </div>
                        <div class="player_item">
                            <div class="player_rank">2</div>
                            <img src="img/avatar8.png" alt="avatar" class="player_avatar">
                            <div class="player_info">
                                <h6>ShadowQueen</h6>
                                <small>Level 48</small>
                            </div>
                            <div class="player_score">23,150 XP</div>
                        </div>
                        <div class="player_item">
                            <div class="player_rank">3</div>
                            <img src="img/avatar9.png" alt="avatar" class="player_avatar">
                            <div class="player_info">
                                <h6>FireMage</h6>
                                <small>Level 47</small>
                            </div>
                            <div class="player_score">22,890 XP</div>
                        </div>
                    </div>
                </div>

                <div class="trending_topics_card">
                    <h4 class="widget_title">Trending Topics</h4>
                    <div class="topics_list">
                        <a href="#" class="topic_item">
                            <span class="topic_badge">#DragonUpdate</span>
                            <small>245 posts</small>
                        </a>
                        <a href="#" class="topic_item">
                            <span class="topic_badge">#TeamRecruitment</span>
                            <small>189 posts</small>
                        </a>
                        <a href="#" class="topic_item">
                            <span class="topic_badge">#WeeklyEvent</span>
                            <small>167 posts</small>
                        </a>
                        <a href="#" class="topic_item">
                            <span class="topic_badge">#GameTips</span>
                            <small>142 posts</small>
                        </a>
                        <a href="#" class="topic_item">
                            <span class="topic_badge">#BugReport</span>
                            <small>98 posts</small>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<footer class="footer_part black">
    <div class="footer_top">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-lg-3">
                    <div class="single_footer_part">
                        <a href="index.html" class="footer_logo_iner"> <img src="img/logo.png" alt="#"> </a>
                        <p>Heaven fruitful doesn't over lesser days appear creeping seasons so behold bearing
                            days open
                        </p>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="single_footer_part">
                        <h4>Contact Info</h4>
                        <p>Address : Your address goes here, your demo address. Bangladesh.</p>
                        <p>Phone : +8880 44338899</p>
                        <p>Email : info@colorlib.com</p>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="single_footer_part">
                        <h4>Important Link</h4>
                        <ul class="list-unstyled">
                            <li><a href=""> WHMCS-bridge</a></li>
                            <li><a href="">Search Domain</a></li>
                            <li><a href="">My Account</a></li>
                            <li><a href="">Shopping Cart</a></li>
                            <li><a href="">Our Shop</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="single_footer_part">
                        <h4>Newsletter</h4>
                        <p>Heaven fruitful doesn't over lesser in days. Appear creeping seasons deve behold
                            bearing days open
                        </p>
                        <div id="mc_embed_signup">
                            <form target="_blank"
                                action="https://spondonit.us12.list-manage.com/subscribe/post?u=1462626880ade1ac87bd9c93a&amp;id=92a4423d01"
                                method="get" class="subscribe_form relative mail_part">
                                <input type="email" name="email" id="newsletter-form-email"
                                    placeholder="Email Address" class="placeholder hide-on-focus"
                                    onfocus="this.placeholder = ''" onblur="this.placeholder = ' Email Address '">
                                <button type="submit" name="submit" id="newsletter-submit"
                                    class="email_icon newsletter-submit button-contactForm"><i
                                        class="far fa-paper-plane"></i></button>
                                <div class="mt-10 info"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="copygight_text">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="copyright_text">
                        <P><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="ti-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></P>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="footer_icon social_icon">
                        <ul class="list-unstyled">
                            <li><a href="#" class="single_social_icon"><i class="fab fa-facebook-f"></i></a>
                            </li>
                            <li><a href="#" class="single_social_icon"><i class="fab fa-twitter"></i></a></li>
                            <li><a href="#" class="single_social_icon"><i class="fas fa-globe"></i></a></li>
                            <li><a href="#" class="single_social_icon"><i class="fab fa-behance"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

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

<script>
$(document).ready(function() {
    $('.commentForm').on('submit', function(e) {
        e.preventDefault();
        
        const form = $(this);
        const contentInput = form.find('.comment-content');
        const errorDiv = form.find('.comment-error');
        const content = contentInput.val().trim();
        const publicationId = form.data('publication-id');
        
        errorDiv.hide().text('');
        
        if (content === '') {
            errorDiv.text('Please enter a comment.').show();
            return false;
        }
        
        if (content.length < 2) {
            errorDiv.text('Comment must be at least 2 characters long.').show();
            return false;
        }
        
        $.post('index.php?action=create_comment', {
            id_publication: publicationId,
            contenu: content
        }, function(response) {
            window.location.reload();
        }).fail(function() {
            errorDiv.text('Error posting comment. Please try again.').show();
        });
    });
    
    $('.comment-content').on('keypress', function(e) {
        if (e.which === 13) {
            e.preventDefault();
            $(this).closest('form').submit();
        }
    });
});
</script>
</body>
</html>