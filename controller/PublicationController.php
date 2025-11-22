<?php
class PublicationController {
    private $publicationModel;
    private $commentaireModel;

    public function __construct($bd) {
        $this->publicationModel = new Publication($bd);
        $this->commentaireModel = new Commentaire($bd);
    }

    public function index() {
        $stmt = $this->publicationModel->readAll();
        if ($stmt) {
            $publications = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            foreach($publications as &$publication) {
                $this->commentaireModel->id_publication = $publication['id_publication'];
                $stmt_comments = $this->commentaireModel->readByPublication();
                if ($stmt_comments) {
                    $publication['commentaires'] = $stmt_comments->fetchAll(PDO::FETCH_ASSOC);
                } else {
                    $publication['commentaires'] = [];
                }
            }
            
            return $publications;
        }
        return [];
    }

    public function create($id_utilisateur, $contenu, $media_url = null, $media_type = null) {
    if(empty(trim($contenu)) || strlen(trim($contenu)) < 2) {
        return false;
    }
    
    $this->publicationModel->id_utilisateur = $id_utilisateur;
    $this->publicationModel->contenu = $contenu;
    $this->publicationModel->media_url = $media_url;
    $this->publicationModel->media_type = $media_type;
    
    return $this->publicationModel->create();
}

    public function update($id_publication, $contenu, $media_url = null, $media_type = null) {
        if(empty(trim($contenu)) || strlen(trim($contenu)) < 2) {
            return false;
        }
        
        $this->publicationModel->id_publication = $id_publication;
        $this->publicationModel->contenu = $contenu;
        $this->publicationModel->media_url = $media_url;
        $this->publicationModel->media_type = $media_type;
        
        return $this->publicationModel->update();
    }

    public function delete($id_publication) {
        $this->publicationModel->id_publication = $id_publication;
        return $this->publicationModel->delete();
    }
}
?>