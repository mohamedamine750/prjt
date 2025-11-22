<?php
$page_title = "Gestion des Publications";
ob_start();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Liste des Publications</h4>
    <a href="publications.php?action=create" class="btn-admin">
        <i class="fas fa-plus"></i> Nouvelle Publication
    </a>
</div>

<?php if (isset($_GET['action']) && in_array($_GET['action'], ['create', 'edit'])): ?>
    <!-- Formulaire de création/édition -->
    <div class="table-card">
        <div class="p-4">
            <h5><?php echo $_GET['action'] == 'create' ? 'Créer une Publication' : 'Modifier la Publication'; ?></h5>
            <form method="POST" action="publications.php" enctype="multipart/form-data">
                <?php if (isset($_GET['id'])): ?>
                    <input type="hidden" name="id_publication" value="<?php echo $publication['id_publication']; ?>">
                <?php endif; ?>
                
                <div class="form-group">
                    <label>Contenu</label>
                    <textarea name="contenu" class="form-control" rows="6" required><?php echo $publication['contenu'] ?? ''; ?></textarea>
                </div>
                
                <div class="form-group">
                    <label>Média (Image/Video)</label>
                    <input type="file" name="media_file" class="form-control" accept="image/*,video/*">
                    <?php if (isset($publications['media_url']) && $publication['media_url']): ?>
                        <small class="form-text text-muted">
                            Média actuel: 
                            <?php if ($publications['media_type'] == 'image'): ?>
                                <img src="../../uploads/publications/<?php echo $publication['media_url']; ?>" width="100" class="ml-2">
                            <?php else: ?>
                                <span class="badge badge-info">Vidéo</span>
                            <?php endif; ?>
                        </small>
                    <?php endif; ?>
                </div>
                
                <div class="form-group">
                    <button type="submit" name="save" class="btn-admin">
                        <i class="fas fa-save"></i> Enregistrer
                    </button>
                    <a href="publications.php" class="btn btn-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
<?php else: ?>
    <!-- Liste des publications -->
    <div class="table-card">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Contenu</th>
                        <th>Média</th>
                        <th>Utilisateur</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($publications as $pub): ?>
                    <tr>
                        <td><?php echo $pub['id_publication']; ?></td>
                        <td>
                            <?php echo strlen($pub['contenu']) > 50 ? substr($pub['contenu'], 0, 50) . '...' : $pub['contenu']; ?>
                        </td>
                        <td>
                            <?php if ($pub['media_url']): ?>
                                <?php if ($pub['media_type'] == 'image'): ?>
                                    <img src="../../uploads/publications/<?php echo $pub['media_url']; ?>" width="50" height="50" style="object-fit: cover;">
                                <?php else: ?>
                                    <i class="fas fa-video text-primary"></i>
                                <?php endif; ?>
                            <?php else: ?>
                                <span class="text-muted">Aucun</span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo $pub['prenom'] . ' ' . $pub['nom']; ?></td>
                        <td><?php echo date('d/m/Y H:i', strtotime($pub['date_publication'])); ?></td>
                        <td class="action-buttons">
                            <a href="publications.php?action=edit&id=<?php echo $pub['id_publication']; ?>" class="btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="publications.php?action=delete&id=<?php echo $pub['id_publication']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr?')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="p-3 border-top">
            <nav>
                <ul class="pagination justify-content-center mb-0">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1">Précédent</a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#">Suivant</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
<?php endif; ?>

<?php
$content = ob_get_clean();
include 'layout.php';
?>