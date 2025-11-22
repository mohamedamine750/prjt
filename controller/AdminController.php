<?php
class AdminController {
    private $publicationModel;
    private $commentaireModel;
    private $bd; // CORRIGÉ : $bd au lieu de $db

    public function __construct($bd) { // CORRIGÉ : $bd
        $this->bd = $bd;
        $this->publicationModel = new Publication($bd);
        $this->commentaireModel = new Commentaire($bd);
    }

    private function checkAdmin() {
        if (!isset($_SESSION['admin'])) {
            $_SESSION['admin'] = true; // Auto-login pour développement
        }
        
        if(!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
            header("Location: index.php");
            exit;
        }
    }

    private function renderBackOffice($view, $data = []) {
        $this->checkAdmin();
        
        // Valeurs par défaut
        $defaults = [
            'publications' => [],
            'commentaires' => [], 
            'errors' => [],
            'publication' => null
        ];
        
        $data = array_merge($defaults, $data);
        extract($data);
        
        // CHEMINS CORRIGÉS
        include 'view/BackOffice/header.php';
        include "view/BackOffice/{$view}.php";
        include 'view/BackOffice/footer.php';
        exit;
    }

    public function dashboard() {
        $publications = [];
        $commentaires = [];
        
        try {
            $stmtPub = $this->publicationModel->readAll();
            if ($stmtPub) {
                $publications = $stmtPub->fetchAll(PDO::FETCH_ASSOC);
            }
            $commentaires = $this->getAllCommentaires();
        } catch(Exception $e) {
            error_log("Dashboard error: " . $e->getMessage());
        }
        
        $this->renderBackOffice('dashboard', [
            'publications' => $publications,
            'commentaires' => $commentaires
        ]);
    }

    public function publications() {
        $publications = [];
        
        try {
            $stmt = $this->publicationModel->readAll();
            if ($stmt) {
                $publications = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch(Exception $e) {
            error_log("Publications error: " . $e->getMessage());
        }
        
        $this->renderBackOffice('publications', [
            'publications' => $publications
        ]);
    }

    public function createPublication() {
        $errors = [];
        
        if($_POST && isset($_POST['contenu'])) {
            $this->publicationModel->id_utilisateur = 1;
            $this->publicationModel->contenu = trim($_POST['contenu']);

            if(empty($this->publicationModel->contenu)) {
                $errors[] = "Le contenu est obligatoire";
            }

            if(empty($errors)) {
                if($this->publicationModel->create()) {
                    header("Location: index.php?action=admin_publications&success=1");
                    exit;
                } else {
                    $errors[] = "Erreur lors de la création";
                }
            }
        }
        
        $this->renderBackOffice('create_publication', [
            'errors' => $errors
        ]);
    }

    public function editPublication() {
        $errors = [];

        if(!isset($_GET['id'])) {
            header("Location: index.php?action=admin_publications");
            exit;
        }

        $this->publicationModel->id_publication = (int)$_GET['id'];
        
        if(!$this->publicationModel->readOne()) {
            header("Location: index.php?action=admin_publications");
            exit;
        }

        if($_POST && isset($_POST['contenu'])) {
            $this->publicationModel->contenu = trim($_POST['contenu']);

            if(empty($this->publicationModel->contenu)) {
                $errors[] = "Le contenu est obligatoire";
            }

            if(empty($errors)) {
                if($this->publicationModel->update()) {
                    header("Location: index.php?action=admin_publications&success=1");
                    exit;
                } else {
                    $errors[] = "Erreur lors de la modification";
                }
            }
        }
        
        $this->renderBackOffice('edit_publication', [
            'errors' => $errors,
            'publication' => $this->publicationModel
        ]);
    }

    public function deletePublication() {
        $this->checkAdmin();
        
        if(!isset($_GET['id'])) {
            header("Location: index.php?action=admin_publications");
            exit;
        }

        $this->publicationModel->id_publication = (int)$_GET['id'];
        
        if($this->publicationModel->delete()) {
            header("Location: index.php?action=admin_publications&success=1");
        } else {
            header("Location: index.php?action=admin_publications&error=1");
        }
        exit;
    }

    public function commentaires() {
        $commentaires = $this->getAllCommentaires();
        $this->renderBackOffice('commentaires', [
            'commentaires' => $commentaires
        ]);
    }

    public function deleteCommentaire() {
        $this->checkAdmin();
        
        if(!isset($_GET['id'])) {
            header("Location: index.php?action=admin_commentaires");
            exit;
        }

        $this->commentaireModel->id_commentaire = (int)$_GET['id'];
        
        if($this->commentaireModel->delete()) {
            header("Location: index.php?action=admin_commentaires&success=1");
        } else {
            header("Location: index.php?action=admin_commentaires&error=1");
        }
        exit;
    }

    private function getAllCommentaires() {
        try {
            $query = "SELECT c.*, u.nom as nom_utilisateur 
                      FROM commentaire c 
                      LEFT JOIN utilisateur u ON c.id_utilisateur = u.id_utilisateur 
                      ORDER BY c.date_commentaire DESC";
            
            $stmt = $this->bd->prepare($query); // CORRIGÉ : $this->bd
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            error_log("Erreur getAllCommentaires: " . $e->getMessage());
            return [];
        }
    }

    public function login() {
        $_SESSION['admin'] = true;
        header("Location: index.php?action=admin_dashboard");
        exit;
    }

    public function logout() {
        unset($_SESSION['admin']);
        header("Location: index.php");
        exit;
    }
}
?>