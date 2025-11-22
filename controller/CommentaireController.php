<?php
class CommentaireController {
    private $commentaireModel;
    private $publicationModel;

    public function __construct($bd) {
        $this->commentaireModel = new Commentaire($bd);
        $this->publicationModel = new Publication($bd);
    }

    

    public function create($id_publication, $id_utilisateur, $contenu) {
        if(empty(trim($contenu)) || strlen(trim($contenu)) < 2) {
            return false;
        }
        
        $this->publicationModel->id_publication = $id_publication;
        if(!$this->publicationModel->readOne()) {
            return false;
        }
        
        $this->commentaireModel->id_publication = $id_publication;
        $this->commentaireModel->id_utilisateur = $id_utilisateur;
        $this->commentaireModel->contenu = $contenu;
        
        return $this->commentaireModel->create();
    }

    public function update($id_commentaire, $contenu) {
        if(empty(trim($contenu)) || strlen(trim($contenu)) < 2) {
            return false;
        }
        
        $this->commentaireModel->id_commentaire = $id_commentaire;
        $this->commentaireModel->contenu = $contenu;
        
        return $this->commentaireModel->update();
    }

    public function delete($id_commentaire) {
        $this->commentaireModel->id_commentaire = $id_commentaire;
        return $this->commentaireModel->delete();
    }
}
?>