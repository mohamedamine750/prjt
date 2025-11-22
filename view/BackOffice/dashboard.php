<?php
$page_title = "Tableau de Bord";
ob_start();
?>

<div class="row">
    <div class="col-md-3">
        <div class="stats-card">
            <h3><?php echo $stats['total_publications'] ?? 0; ?></h3>
            <p>Publications Total</p>
            <i class="fas fa-newspaper fa-2x text-primary"></i>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card">
            <h3><?php echo $stats['total_commentaires'] ?? 0; ?></h3>
            <p>Commentaires Total</p>
            <i class="fas fa-comments fa-2x text-success"></i>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card">
            <h3><?php echo $stats['publications_today'] ?? 0; ?></h3>
            <p>Publications Aujourd'hui</p>
            <i class="fas fa-chart-line fa-2x text-warning"></i>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card">
            <h3><?php echo $stats['commentaires_today'] ?? 0; ?></h3>
            <p>Commentaires Aujourd'hui</p>
            <i class="fas fa-comment-dots fa-2x text-info"></i>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-8">
        <div class="table-card">
            <div class="p-3 border-bottom">
                <h5 class="mb-0">Publications Récentes</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Contenu</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recent_publications as $pub): ?>
                        <tr>
                            <td><?php echo $pub['id_publication']; ?></td>
                            <td>
                                <?php echo strlen($pub['contenu']) > 50 ? substr($pub['contenu'], 0, 50) . '...' : $pub['contenu']; ?>
                                <?php if ($pub['media_url']): ?>
                                    <br><small class="text-muted"><i class="fas fa-image"></i> Média attaché</small>
                                <?php endif; ?>
                            </td>
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
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="table-card">
            <div class="p-3 border-bottom">
                <h5 class="mb-0">Commentaires Récents</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Commentaire</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recent_commentaires as $com): ?>
                        <tr>
                            <td><?php echo $com['id_commentaire']; ?></td>
                            <td><?php echo strlen($com['contenu']) > 30 ? substr($com['contenu'], 0, 30) . '...' : $com['contenu']; ?></td>
                            <td class="action-buttons">
                                <a href="commentaires.php?action=edit&id=<?php echo $com['id_commentaire']; ?>" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="commentaires.php?action=delete&id=<?php echo $com['id_commentaire']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include 'layout.php';
?>