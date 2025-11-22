<?php
class Commentaire {
    private $conn;
    private $table_name = "commentaire";

    public $id_commentaire;
    public $id_publication;
    public $id_utilisateur;
    public $contenu;
    public $date_commentaire;

    public function __construct($bd) {
        $this->conn = $bd;
    }

    public function create() {
        try {
            $query = "INSERT INTO " . $this->table_name . " 
                      SET id_publication=:id_publication, id_utilisateur=:id_utilisateur, contenu=:contenu, date_commentaire=NOW()";
            
            $stmt = $this->conn->prepare($query);
            
            $this->id_publication = htmlspecialchars(strip_tags($this->id_publication));
            $this->id_utilisateur = htmlspecialchars(strip_tags($this->id_utilisateur));
            $this->contenu = htmlspecialchars(strip_tags($this->contenu));
            
            $stmt->bindParam(":id_publication", $this->id_publication);
            $stmt->bindParam(":id_utilisateur", $this->id_utilisateur);
            $stmt->bindParam(":contenu", $this->contenu);
            
            return $stmt->execute();
            
        } catch (PDOException $exception) {
            error_log("Erreur PDO Commentaire->create(): " . $exception->getMessage());
            return false;
        }
    }

    // AJOUT DE LA MÉTHODE READALL MANQUANTE
    public function readAll() {
        try {
            $query = "SELECT c.*, u.nom, u.prenom 
                      FROM " . $this->table_name . " c 
                      LEFT JOIN utilisateur u ON c.id_utilisateur = u.id_utilisateur 
                      ORDER BY c.date_commentaire DESC";
            
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            
            return $stmt;
            
        } catch (PDOException $exception) {
            error_log("Erreur PDO Commentaire->readAll(): " . $exception->getMessage());
            return false;
        }
    }

    public function readByPublication() {
        try {
            $query = "SELECT c.*, u.nom, u.prenom 
                      FROM " . $this->table_name . " c 
                      LEFT JOIN utilisateur u ON c.id_utilisateur = u.id_utilisateur 
                      WHERE c.id_publication = :id_publication 
                      ORDER BY c.date_commentaire DESC";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id_publication", $this->id_publication);
            $stmt->execute();
            
            return $stmt;
            
        } catch (PDOException $exception) {
            error_log("Erreur PDO Commentaire->readByPublication(): " . $exception->getMessage());
            return false;
        }
    }

    public function readOne() {
        $query = "SELECT * FROM commentaire WHERE id_commentaire = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id_commentaire);
        $stmt->execute();
        
        if($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->contenu = $row['contenu'];
            $this->id_publication = $row['id_publication'];
            $this->id_utilisateur = $row['id_utilisateur'];
            $this->date_commentaire = $row['date_commentaire'];
            return true;
        }
        return false;
    }

    public function update() {
        $query = "UPDATE commentaire SET contenu = :contenu WHERE id_commentaire = :id";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':contenu', $this->contenu);
        $stmt->bindParam(':id', $this->id_commentaire);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function delete() {
        try {
            $query = "DELETE FROM " . $this->table_name . " WHERE id_commentaire = ?";
            
            $stmt = $this->conn->prepare($query);
            $this->id_commentaire = htmlspecialchars(strip_tags($this->id_commentaire));
            $stmt->bindParam(1, $this->id_commentaire);
            
            return $stmt->execute();
            
        } catch (PDOException $exception) {
            error_log("Erreur PDO Commentaire->delete(): " . $exception->getMessage());
            return false;
        }
    }

    // NOUVELLE MÉTHODE POUR ADMIN
    public function getByPublication($id_publication) {
        $this->id_publication = $id_publication;
        $stmt = $this->readByPublication();
        return $stmt ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
    }
}
?>