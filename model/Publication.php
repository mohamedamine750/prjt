<?php
class Publication {
    private $conn;
    private $table_name = "publication";

    public $id_publication;
    public $id_utilisateur;
    public $contenu;
    public $date_publication;
    public $media_url;
    public $media_type;

    public function __construct($bd) {
        $this->conn = $bd;
    }

    public function create() {
        try {
            $query = "INSERT INTO " . $this->table_name . " 
                      SET id_utilisateur=:id_utilisateur, contenu=:contenu, media_url=:media_url, media_type=:media_type, date_publication=NOW()";
            
            $stmt = $this->conn->prepare($query);
            
            $this->id_utilisateur = htmlspecialchars(strip_tags($this->id_utilisateur));
            $this->contenu = htmlspecialchars(strip_tags($this->contenu));
            $this->media_url = htmlspecialchars(strip_tags($this->media_url));
            $this->media_type = htmlspecialchars(strip_tags($this->media_type));
            
            $stmt->bindParam(":id_utilisateur", $this->id_utilisateur);
            $stmt->bindParam(":contenu", $this->contenu);
            $stmt->bindParam(":media_url", $this->media_url);
            $stmt->bindParam(":media_type", $this->media_type);
            
            return $stmt->execute();
            
        } catch (PDOException $exception) {
            error_log("Erreur PDO Publication->create(): " . $exception->getMessage());
            return false;
        }
    }
    

    public function readAll() {
        try {
            $query = "SELECT p.*, u.nom as nom_utilisateur 
                      FROM " . $this->table_name . " p 
                      LEFT JOIN utilisateur u ON p.id_utilisateur = u.id_utilisateur 
                      ORDER BY p.date_publication DESC";
            
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            
            return $stmt;
            
        } catch (PDOException $exception) {
            error_log("Erreur PDO Publication->readAll(): " . $exception->getMessage());
            return false;
        }
    }

  public function readOne() {
    $query = "SELECT * FROM publication WHERE id_publication = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1, $this->id_publication);
    $stmt->execute();
    
    if($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->contenu = $row['contenu'];
        $this->id_utilisateur = $row['id_utilisateur'];
        $this->date_publication = $row['date_publication'];
        $this->media_url = $row['media_url'];
        $this->media_type = $row['media_type'];
        return true;
    }
    return false;
}

public function update() {
    $query = "UPDATE publication SET contenu = :contenu, media_url = :media_url, media_type = :media_type WHERE id_publication = :id";
    $stmt = $this->conn->prepare($query);
    
    $stmt->bindParam(':contenu', $this->contenu);
    $stmt->bindParam(':media_url', $this->media_url);
    $stmt->bindParam(':media_type', $this->media_type);
    $stmt->bindParam(':id', $this->id_publication);
    
    if($stmt->execute()) {
        return true;
    }
    return false;
}

    public function delete() {
        try {
            $query = "DELETE FROM " . $this->table_name . " WHERE id_publication = ?";
            
            $stmt = $this->conn->prepare($query);
            $this->id_publication = htmlspecialchars(strip_tags($this->id_publication));
            $stmt->bindParam(1, $this->id_publication);
            
            return $stmt->execute();
            
        } catch (PDOException $exception) {
            error_log("Erreur PDO Publication->delete(): " . $exception->getMessage());
            return false;
        }
    }
}
?>