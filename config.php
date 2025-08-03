<?php
// Configuration de la base de données
define('DB_HOST', 'localhost');
define('DB_USER', 'votre_utilisateur'); // Remplacez par votre utilisateur MySQL
define('DB_PASS', 'votre_mot_de_passe'); // Remplacez par votre mot de passe MySQL
define('DB_NAME', 'meteo_algerie'); // Nom de votre base de données

// Tentative de connexion
try {
    $db = new PDO(
        "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8", 
        DB_USER, 
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );
} catch(PDOException $e) {
    // En production, vous devriez logger cette erreur
    die("Erreur de connexion à la base de données. Veuillez réessayer plus tard.");
}
?>