<?php
require_once 'model/Database.php';
require_once 'model/Publication.php';
require_once 'model/Commentaire.php';

$database = new Database();
$bd = $database->getConnection();

echo "<!DOCTYPE html>
<html>
<head>
    <title>Création des données de test</title>
    <link rel='stylesheet' href='css/bootstrap.min.css'>
</head>
<body>
    <div class='container mt-4'>
        <h1>Création des données de test</h1>";

try {
    $publication = new Publication($bd);
    $commentaire = new Commentaire($bd);

    $checkUser = $bd->prepare("SELECT id_utilisateur FROM utilisateur WHERE id_utilisateur = 1");
    $checkUser->execute();
    
    if ($checkUser->rowCount() == 0) {
        echo "<div class='alert alert-danger'>
                <h4>❌ ERREUR : Aucun utilisateur trouvé!</h4>
                <p>Créez d'abord la table utilisateur avec au moins un utilisateur (ID=1)</p>
              </div>";
        echo "</div></body></html>";
        exit();
    }

    echo "<div class='alert alert-success'>✅ Utilisateurs trouvés dans la base</div>";

    $testPublications = [
        [
            'id_utilisateur' => 1,
            'contenu' => 'Just completed the Dragon\'s Lair mission! That final boss was insane! 🔥 Anyone else struggling with it?'
        ],
        [
            'id_utilisateur' => 1, 
            'contenu' => '🏆 TEAM PHOENIX IS RECRUITING! 🏆 Looking for dedicated players level 20+ to join our competitive team.'
        ],
        [
            'id_utilisateur' => 1,
            'contenu' => 'Double XP weekend is here! From Friday 6 PM to Sunday 11:59 PM, all missions grant 2x experience points.'
        ]
    ];

    foreach ($testPublications as $index => $testPub) {
        echo "<div class='card mb-3'><div class='card-body'>";
        echo "<h5>Publication " . ($index + 1) . "</h5>";
        
        $publication->id_utilisateur = $testPub['id_utilisateur'];
        $publication->contenu = $testPub['contenu'];
        
        if ($publication->create()) {
            echo "<p class='text-success'>✅ Publication créée</p>";
            
            $stmt = $publication->readAll();
            $publications = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $lastPublicationId = $publications[0]['id_publication'];
            
            $testComments = [
                [
                    'id_utilisateur' => 1, 
                    'contenu' => 'Great job! That boss was really tough.'
                ],
                [
                    'id_utilisateur' => 1, 
                    'contenu' => 'Congratulations! 🎉 The reward was totally worth it though.'
                ]
            ];
            
            foreach ($testComments as $commentIndex => $testComment) {
                $commentaire->id_publication = $lastPublicationId;
                $commentaire->id_utilisateur = $testComment['id_utilisateur'];
                $commentaire->contenu = $testComment['contenu'];
                
                if ($commentaire->create()) {
                    echo "<p class='text-info ml-3'>✅ Commentaire " . ($commentIndex + 1) . " ajouté</p>";
                }
            }
        } else {
            echo "<p class='text-danger'>❌ Erreur lors de la création</p>";
        }
        echo "</div></div>";
    }

    echo "<div class='alert alert-success mt-4'>
            <h4>🎉 Données de test créées avec succès!</h4>
            <p><a href='index.php' class='btn btn-primary'>Accéder à la communauté</a></p>
          </div>";

} catch (PDOException $e) {
    echo "<div class='alert alert-danger'>
            <h4>❌ Erreur de base de données</h4>
            <p>" . $e->getMessage() . "</p>
          </div>";
}

echo "</div></body></html>";
?>