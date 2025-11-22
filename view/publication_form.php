<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../model/Database.php';
require_once '../model/Publication.php';

$database = new Database();
$bd = $database->getConnection();
$publication = new Publication($bd);

$is_edit = false;
if(isset($_GET['id'])) {
    $is_edit = true;
    $publication->id_publication = $_GET['id'];
    $publication->readOne();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $is_edit ? 'Edit Publication' : 'New Publication'; ?> - Gaming</title>
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
    <style>
        .media-preview-container {
            margin-top: 15px;
            display: none;
        }
        
        .media-preview {
            max-width: 100%;
            max-height: 300px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .video-preview {
            width: 100%;
            max-height: 300px;
            border-radius: 8px;
        }
        
        .remove-media {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(255,255,255,0.8);
            border: none;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            cursor: pointer;
            color: #dc3545;
        }
        
        .file-input-label {
            display: block;
            padding: 12px;
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }
        
        .file-input-label:hover {
            border-color: #007bff;
            background: #e9ecef;
        }
        
        .file-input-label i {
            font-size: 24px;
            margin-bottom: 8px;
            color: #6c757d;
        }
        
        .file-info {
            font-size: 0.875em;
            color: #6c757d;
            margin-top: 5px;
        }
    </style>
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
                        <h2><?php echo $is_edit ? 'Edit Publication' : 'New Publication'; ?></h2>
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
                    <form id="publicationForm" method="POST" action="../index.php?action=<?php echo $is_edit ? 'update_publication' : 'create_publication'; ?>" enctype="multipart/form-data">
                        <?php if($is_edit): ?>
                            <input type="hidden" name="id_publication" value="<?php echo $publication->id_publication; ?>">
                        <?php endif; ?>

                        <div class="form-group">
                            <label for="contenu" class="form-label"><strong>Publication Content</strong></label>
                            <textarea class="form-control" id="contenu" name="contenu" rows="6" 
                                      placeholder="Share your gaming experience..."><?php echo $is_edit ? htmlspecialchars($publication->contenu) : ''; ?></textarea>
                            <div id="publicationError" class="text-danger small mt-1" style="display: none;"></div>
                        </div>

                        <!-- Media Upload Section -->
                        <div class="form-group">
                            <label class="form-label"><strong>Add Photo or Video</strong></label>
                            
                            <!-- File Input (Hidden) -->
                            <input type="file" id="mediaFile" name="media_file" accept="image/*,video/*" style="display: none;">
                            
                            <!-- Custom File Input Label -->
                            <label for="mediaFile" class="file-input-label" id="fileInputLabel">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <div>Click to upload a photo or video</div>
                                <div class="file-info">Supports: JPG, PNG, GIF, MP4, MOV (Max: 10MB)</div>
                            </label>
                            
                            <!-- Media Preview -->
                            <div class="media-preview-container" id="mediaPreviewContainer">
                                <div class="position-relative d-inline-block">
                                    <div id="mediaPreview"></div>
                                    <button type="button" class="remove-media" id="removeMedia">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Media Error -->
                            <div id="mediaError" class="text-danger small mt-1" style="display: none;"></div>
                        </div>

                        <div class="form-group text-right">
                            <a href="../index.php" class="btn btn-secondary mr-2">Cancel</a>
                            <button type="submit" class="btn_1 btn_small">
                                <i class="fas fa-<?php echo $is_edit ? 'edit' : 'plus'; ?>"></i>
                                <?php echo $is_edit ? 'Update' : 'Publish'; ?>
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
    console.log('Publication form with media upload loaded');
    
    // Elements
    const mediaFileInput = $('#mediaFile');
    const fileInputLabel = $('#fileInputLabel');
    const mediaPreviewContainer = $('#mediaPreviewContainer');
    const mediaPreview = $('#mediaPreview');
    const removeMediaBtn = $('#removeMedia');
    const mediaError = $('#mediaError');
    
    // Allowed file types and max size
    const allowedImageTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
    const allowedVideoTypes = ['video/mp4', 'video/quicktime', 'video/avi'];
    const maxFileSize = 10 * 1024 * 1024; // 10MB in bytes
    
    // File input change event
    mediaFileInput.on('change', function(e) {
        const file = e.target.files[0];
        mediaError.hide().text('');
        
        if (file) {
            // Validate file
            if (!validateFile(file)) {
                return;
            }
            
            // Preview file
            previewFile(file);
            
            // Update label text
            fileInputLabel.html(`
                <i class="fas fa-check text-success"></i>
                <div>File selected: ${file.name}</div>
                <div class="file-info">Click to change file</div>
            `);
        }
    });
    
    // Remove media
    removeMediaBtn.on('click', function() {
        mediaFileInput.val('');
        mediaPreviewContainer.hide();
        mediaPreview.empty();
        fileInputLabel.html(`
            <i class="fas fa-cloud-upload-alt"></i>
            <div>Click to upload a photo or video</div>
            <div class="file-info">Supports: JPG, PNG, GIF, MP4, MOV (Max: 10MB)</div>
        `);
    });
    
    // File validation
    function validateFile(file) {
        // Check file size
        if (file.size > maxFileSize) {
            mediaError.text('File is too large. Maximum size is 10MB.').show();
            mediaFileInput.val('');
            return false;
        }
        
        // Check file type
        const isImage = allowedImageTypes.includes(file.type);
        const isVideo = allowedVideoTypes.includes(file.type);
        
        if (!isImage && !isVideo) {
            mediaError.text('Invalid file type. Please upload an image or video.').show();
            mediaFileInput.val('');
            return false;
        }
        
        return true;
    }
    
    // File preview
    function previewFile(file) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            const isImage = allowedImageTypes.includes(file.type);
            const isVideo = allowedVideoTypes.includes(file.type);
            
            if (isImage) {
                mediaPreview.html(`<img src="${e.target.result}" class="media-preview" alt="Preview">`);
            } else if (isVideo) {
                mediaPreview.html(`
                    <video controls class="video-preview">
                        <source src="${e.target.result}" type="${file.type}">
                        Your browser does not support the video tag.
                    </video>
                `);
            }
            
            mediaPreviewContainer.show();
        };
        
        reader.readAsDataURL(file);
    }
    
    // Enhanced form validation
    $('#publicationForm').on('submit', function(e) {
        console.log('Form submission intercepted');
        const content = $('#contenu').val().trim();
        const errorDiv = $('#publicationError');
        const file = mediaFileInput[0].files[0];
        
        // Reset errors
        errorDiv.hide().text('');
        mediaError.hide().text('');
        
        let hasErrors = false;
        
        // Content validation
        if (content === '') {
            errorDiv.text('Please enter some content for your post.').show();
            $('#contenu').focus();
            hasErrors = true;
        } else if (content.length < 2) {
            errorDiv.text('Post content must be at least 2 characters long.').show();
            $('#contenu').focus();
            hasErrors = true;
        }
        
        // File validation (if file is selected)
        if (file && !validateFile(file)) {
            hasErrors = true;
        }
        
        // Check if at least content or file is provided
        if (content === '' && !file) {
            errorDiv.text('Please enter content or upload a photo/video.').show();
            hasErrors = true;
        }
        
        if (hasErrors) {
            e.preventDefault();
            return false;
        }
        
        console.log('Validation passed, form will submit');
        return true;
    });
});
</script>
</body>
</html>