<?php
echo "<h1>Test Server</h1>";
echo "<p>Si vous voyez ce message, PHP fonctionne correctement.</p>";

// Test des URLs
echo "<h2>Test des URLs :</h2>";
echo "<ul>";
echo "<li><a href='index.php'>index.php (Front Office)</a></li>";
echo "<li><a href='index.php?action=admin_login'>Admin Login</a></li>";
echo "<li><a href='index.php?action=admin_dashboard'>Admin Dashboard</a></li>";
echo "<li><a href='index.php?action=admin_publications'>Admin Publications</a></li>";
echo "</ul>";

// Test de session
session_start();
echo "<h2>Session :</h2>";
echo "<p>Session ID: " . session_id() . "</p>";
echo "<p>Admin session: " . (isset($_SESSION['admin']) ? 'OUI' : 'NON') . "</p>";

// Test base de données
try {
    require_once 'model/Database.php';
    $database = new Database();
    $db = $database->getConnection();
    echo "<p style='color: green;'>✓ Connexion DB réussie</p>";
} catch(Exception $e) {
    echo "<p style='color: red;'>✗ Erreur DB: " . $e->getMessage() . "</p>";
}
?>