<div class="admin-create-publication">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-plus"></i> Créer une Publication</h4>
                </div>
                <div class="card-body">
                    
                    <?php if(!empty($errors)): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach($errors as $error): ?>
                                    <li><?= htmlspecialchars($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="form-group mb-3">
                            <label for="contenu" class="form-label">Contenu de la publication *</label>
                            <textarea class="form-control" id="contenu" name="contenu" rows="6" 
                                      placeholder="Partagez votre expérience gaming..." required><?= $_POST['contenu'] ?? '' ?></textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="index.php?action=admin_publications" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Retour
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Publier
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>