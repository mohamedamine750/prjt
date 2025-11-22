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
                      SET id_publication=:id_publication, id_utilisateur=:id_utilisateur, 
                          contenu=:contenu, date_commentaire=NOW()";
            
            $stmt = $this->conn->prepare($query);
            
            // Nettoyage léger seulement
            $this->id_publication = (int)$this->id_publication;
            $this->id_utilisateur = (int)$this->id_utilisateur;
            $this->contenu = trim($this->contenu);
            
            $stmt->bindParam(":id_publication", $this->id_publication);
            $stmt->bindParam(":id_utilisateur", $this->id_utilisateur);
            $stmt->bindParam(":contenu", $this->contenu);
            
            if ($stmt->execute()) {
                $this->id_commentaire = $this->conn->lastInsertId();
                return true;
            }
            return false;
            
        } catch (PDOException $exception) {
            error_log("Erreur PDO Commentaire->create(): " . $exception->getMessage());
            return false;
        }
    }

    public function readByPublication() {
        try {
            $query = "SELECT c.*, u.nom as nom
                      FROM " . $this->table_name . " c 
                      LEFT JOIN utilisateur u ON c.id_utilisateur = u.id_utilisateur 
                      WHERE c.id_publication = ? 
                      ORDER BY c.date_commentaire ASC";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $this->id_publication);
            $stmt->execute();
            
            return $stmt;
            
        } catch (PDOException $exception) {
            error_log("Erreur PDO Commentaire->readByPublication(): " . $exception->getMessage());
            return false;
        }
    }

    public function readOne() {
        try {
            $query = "SELECT * FROM " . $this->table_name . " WHERE id_commentaire = ? LIMIT 0,1";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $this->id_commentaire);
            $stmt->execute();
            
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if($row) {
                $this->id_publication = $row['id_publication'];
                $this->id_utilisateur = $row['id_utilisateur'];
                $this->contenu = $row['contenu'];
                $this->date_commentaire = $row['date_commentaire'];
                return true;
            }
            return false;
            
        } catch (PDOException $exception) {
            error_log("Erreur PDO Commentaire->readOne(): " . $exception->getMessage());
            return false;
        }
    }

    public function update() {
        try {
            $query = "UPDATE " . $this->table_name . " 
                      SET contenu=:contenu 
                      WHERE id_commentaire=:id_commentaire";
            
            $stmt = $this->conn->prepare($query);
            
            $this->contenu = trim($this->contenu);
            $this->id_commentaire = (int)$this->id_commentaire;
            
            $stmt->bindParam(":contenu", $this->contenu);
            $stmt->bindParam(":id_commentaire", $this->id_commentaire);
            
            return $stmt->execute();
            
        } catch (PDOException $exception) {
            error_log("Erreur PDO Commentaire->update(): " . $exception->getMessage());
            return false;
        }
    }

    public function delete() {
        try {
            $query = "DELETE FROM " . $this->table_name . " WHERE id_commentaire = ?";
            
            $stmt = $this->conn->prepare($query);
            $this->id_commentaire = (int)$this->id_commentaire;
            $stmt->bindParam(1, $this->id_commentaire);
            
            return $stmt->execute();
            
        } catch (PDOException $exception) {
            error_log("Erreur PDO Commentaire->delete(): " . $exception->getMessage());
            return false;
        }
    }

    // Méthode pour vérifier si l'utilisateur peut modifier le commentaire
    public function canUserEdit($user_id) {
        return ($this->id_utilisateur == $user_id);
    }
}
?>