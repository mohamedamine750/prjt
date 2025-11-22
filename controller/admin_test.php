<?php
session_start();
$_SESSION['admin'] = true;

echo "<h1>Test Admin Minimal</h1>";
echo "<p><a href='index.php?action=admin_dashboard'>Aller au Dashboard Admin</a></p>";

// Test direct
if(isset($_GET['test'])) {
    echo "<h2>Test des modèles :</h2>";
    try {
        require_once 'model/Database.php';
        require_once 'model/Publication.php';
        
        $database = new Database();
        $db = $database->getConnection();
        $pub = new Publication($db);
        
        $stmt = $pub->readAll();
        $publications = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo "<p>Publications trouvées : " . count($publications) . "</p>";
        
    } catch(Exception $e) {
        echo "<p>Erreur : " . $e->getMessage() . "</p>";
    }
}
?>