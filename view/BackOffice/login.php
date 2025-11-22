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
        /* Additional custom styles to match the existing design */
        .body_bg {
            background: #1a1a2e;
            color: #fff;
            font-family: 'Roboto', sans-serif;
        }
        
        .community-container {
            max-width: 800px;
            margin: 100px auto 50px;
            padding: 0 15px;
        }
        
        .publication-card {
            background: rgba(30, 30, 50, 0.9);
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 25px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(108, 92, 231, 0.2);
        }
        
        .publication-header {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .user-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(45deg, #6c5ce7, #a29bfe);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-weight: bold;
            font-size: 18px;
        }
        
        .user-info h4 {
            margin: 0;
            color: #6c5ce7;
            font-size: 18px;
        }
        
        .user-info p {
            margin: 0;
            color: #aaa;
            font-size: 12px;
        }
        
        .publication-content {
            margin-bottom: 15px;
            line-height: 1.6;
        }
        
        .publication-media {
            margin: 15px 0;
            border-radius: 8px;
            overflow: hidden;
        }
        
        .publication-media img,
        .publication-media video {
            max-width: 100%;
            border-radius: 8px;
        }
        
        .publication-actions {
            display: flex;
            justify-content: space-between;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 15px;
        }
        
        .action-btn {
            background: none;
            border: none;
            color: #aaa;
            cursor: pointer;
            transition: color 0.3s;
            display: flex;
            align-items: center;
        }
        
        .action-btn i {
            margin-right: 5px;
        }
        
        .action-btn:hover {
            color: #6c5ce7;
        }
        
        .comment-section {
            margin-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 15px;
        }
        
        .comment {
            display: flex;
            margin-bottom: 15px;
        }
        
        .comment-avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: linear-gradient(45deg, #00b894, #55efc4);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            font-weight: bold;
            font-size: 14px;
        }
        
        .comment-content {
            flex: 1;
            background: rgba(255, 255, 255, 0.05);
            padding: 10px 15px;
            border-radius: 20px;
        }
        
        .comment-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }
        
        .comment-author {
            color: #00b894;
            font-weight: bold;
            font-size: 14px;
        }
        
        .comment-date {
            color: #777;
            font-size: 12px;
        }
        
        .comment-text {
            color: #ddd;
            font-size: 14px;
        }
        
        .comment-actions {
            display: flex;
            margin-top: 5px;
        }
        
        .comment-action {
            background: none;
            border: none;
            color: #777;
            font-size: 12px;
            cursor: pointer;
            margin-right: 10px;
        }
        
        .comment-action:hover {
            color: #6c5ce7;
        }
        
        .add-comment-form {
            display: flex;
            margin-top: 15px;
        }
        
        .comment-input {
            flex: 1;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(108, 92, 231, 0.3);
            border-radius: 20px;
            padding: 10px 15px;
            color: white;
            margin-right: 10px;
        }
        
        .comment-submit {
            background: #6c5ce7;
            border: none;
            border-radius: 20px;
            padding: 10px 20px;
            color: white;
            cursor: pointer;
            transition: background 0.3s;
        }
        
        .comment-submit:hover {
            background: #5b4bc4;
        }
        
        .create-publication {
            background: rgba(30, 30, 50, 0.9);
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 25px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(108, 92, 231, 0.2);
        }
        
        .publication-textarea {
            width: 100%;
            min-height: 100px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(108, 92, 231, 0.3);
            border-radius: 8px;
            padding: 15px;
            color: white;
            margin-bottom: 15px;
            resize: vertical;
        }
        
        .media-upload {
            margin-bottom: 15px;
        }
        
        .media-label {
            display: inline-block;
            background: rgba(108, 92, 231, 0.2);
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
            margin-bottom: 10px;
        }
        
        .media-label:hover {
            background: rgba(108, 92, 231, 0.4);
        }
        
        .publication-submit {
            background: #6c5ce7;
            border: none;
            border-radius: 5px;
            padding: 10px 25px;
            color: white;
            cursor: pointer;
            transition: background 0.3s;
            font-weight: bold;
        }
        
        .publication-submit:hover {
            background: #5b4bc4;
        }
        
        .message {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .message.success {
            background: rgba(0, 184, 148, 0.2);
            border: 1px solid rgba(0, 184, 148, 0.5);
            color: #00b894;
        }
        
        .message.error {
            background: rgba(255, 118, 117, 0.2);
            border: 1px solid rgba(255, 118, 117, 0.5);
            color: #ff7675;
        }
        
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #777;
        }
        
        .empty-state i {
            font-size: 50px;
            margin-bottom: 15px;
            color: #6c5ce7;
        }
    </style>
</head>
<body class="body_bg">
    <!-- Header Section -->
    <header>
        <!-- Your existing header/navigation would go here -->
    </header>

    <!-- Main Content -->
    <div class="community-container">
        <!-- Success/Error Messages -->
        <?php if(isset($_SESSION['message'])): ?>
            <div class="message <?php echo $_SESSION['message_type']; ?>">
                <?php echo $_SESSION['message']; ?>
                <?php unset($_SESSION['message']); unset($_SESSION['message_type']); ?>
            </div>
        <?php endif; ?>

        <!-- Create Publication Form -->
        <div class="create-publication">
            <h3 style="color: #6c5ce7; margin-bottom: 15px;">Create a Publication</h3>
            <form method="POST" action="index.php?action=create_publication" enctype="multipart/form-data">
                <textarea class="publication-textarea" name="contenu" placeholder="What's on your mind?" required></textarea>
                
                <div class="media-upload">
                    <label class="media-label">
                        <i class="fas fa-image"></i> Add Media
                        <input type="file" name="media_file" accept="image/*,video/*" style="display: none;">
                    </label>
                    <div id="file-name" style="color: #aaa; font-size: 14px; margin-left: 10px; display: inline-block;"></div>
                </div>
                
                <button type="submit" class="publication-submit">Publish</button>
            </form>
        </div>

        <!-- Publications List -->
        <?php if(empty($publications)): ?>
            <div class="empty-state">
                <i class="fas fa-comments"></i>
                <h3>No publications yet</h3>
                <p>Be the first to share something with the community!</p>
            </div>
        <?php else: ?>
            <?php foreach($publications as $publication): ?>
                <div class="publication-card">
                    <!-- Publication Header -->
                    <div class="publication-header">
                        <div class="user-avatar">
                            <?php echo substr($publication['nom_utilisateur'] ?? 'User', 0, 1); ?>
                        </div>
                        <div class="user-info">
                            <h4><?php echo $publication['nom_utilisateur'] ?? 'Anonymous'; ?></h4>
                            <p><?php echo date('M j, Y \a\t g:i A', strtotime($publication['date_publication'])); ?></p>
                        </div>
                    </div>
                    
                    <!-- Publication Content -->
                    <div class="publication-content">
                        <?php echo nl2br(htmlspecialchars($publication['contenu'])); ?>
                    </div>
                    
                    <!-- Publication Media -->
                    <?php if(!empty($publication['media_url'])): ?>
                        <div class="publication-media">
                            <?php if($publication['media_type'] == 'image'): ?>
                                <img src="uploads/publications/<?php echo $publication['media_url']; ?>" alt="Publication image">
                            <?php elseif($publication['media_type'] == 'video'): ?>
                                <video controls>
                                    <source src="uploads/publications/<?php echo $publication['media_url']; ?>" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Publication Actions -->
                    <div class="publication-actions">
                        <button class="action-btn">
                            <i class="far fa-heart"></i> Like
                        </button>
                        <button class="action-btn" onclick="toggleCommentSection(<?php echo $publication['id_publication']; ?>)">
                            <i class="far fa-comment"></i> Comment
                        </button>
                        <div>
                            <a href="index.php?action=edit_publication_form&id=<?php echo $publication['id_publication']; ?>" class="action-btn">
                                <i class="far fa-edit"></i> Edit
                            </a>
                            <a href="index.php?action=delete_publication&id=<?php echo $publication['id_publication']; ?>" class="action-btn" onclick="return confirm('Are you sure you want to delete this publication?');">
                                <i class="far fa-trash-alt"></i> Delete
                            </a>
                        </div>
                    </div>
                    
                    <!-- Comment Section -->
                    <div class="comment-section" id="comment-section-<?php echo $publication['id_publication']; ?>" style="display: none;">
                        <!-- Existing Comments -->
                        <?php if(!empty($publication['commentaires'])): ?>
                            <?php foreach($publication['commentaires'] as $comment): ?>
                                <div class="comment">
                                    <div class="comment-avatar">
                                        <?php echo substr($comment['nom_utilisateur'] ?? 'User', 0, 1); ?>
                                    </div>
                                    <div class="comment-content">
                                        <div class="comment-header">
                                            <span class="comment-author"><?php echo $comment['nom_utilisateur'] ?? 'Anonymous'; ?></span>
                                            <span class="comment-date"><?php echo date('M j, g:i A', strtotime($comment['date_commentaire'])); ?></span>
                                        </div>
                                        <div class="comment-text">
                                            <?php echo nl2br(htmlspecialchars($comment['contenu'])); ?>
                                        </div>
                                        <div class="comment-actions">
                                            <a href="index.php?action=edit_comment_form&id=<?php echo $comment['id_commentaire']; ?>" class="comment-action">Edit</a>
                                            <a href="index.php?action=delete_comment&id=<?php echo $comment['id_commentaire']; ?>" class="comment-action" onclick="return confirm('Are you sure you want to delete this comment?');">Delete</a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        
                        <!-- Add Comment Form -->
                        <form method="POST" action="index.php?action=create_comment" class="add-comment-form">
                            <input type="hidden" name="id_publication" value="<?php echo $publication['id_publication']; ?>">
                            <input type="text" class="comment-input" name="contenu" placeholder="Write a comment..." required>
                            <button type="submit" class="comment-submit">Post</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- JavaScript -->
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
        // Toggle comment section visibility
        function toggleCommentSection(publicationId) {
            const commentSection = document.getElementById('comment-section-' + publicationId);
            if (commentSection.style.display === 'none') {
                commentSection.style.display = 'block';
            } else {
                commentSection.style.display = 'none';
            }
        }
        
        // Show selected file name
        document.querySelector('input[name="media_file"]').addEventListener('change', function(e) {
            const fileName = e.target.files[0] ? e.target.files[0].name : 'No file selected';
            document.getElementById('file-name').textContent = fileName;
        });
        
        // Auto-resize textarea
        document.querySelectorAll('.publication-textarea').forEach(textarea => {
            textarea.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = (this.scrollHeight) + 'px';
            });
        });
    </script>
</body>
</html>