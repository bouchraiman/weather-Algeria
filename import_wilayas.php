<?php
require 'config.php';

// Données des wilayas (comme dans le SQL ci-dessus)
$wilayas = [
    ['code' => 1, 'name' => 'Adrar', 'ar_name' => 'أدرار', 'latitude' => 27.8767, 'longitude' => -0.2833],
    // ... ajoutez toutes les wilayas
];

// Données des villages par wilaya
$villages = [
    16 => ['Bouzareah', 'بوزريعة'], // Alger
    31 => ['Aïn El Turk', 'عين الترك'], // Oran
    // ... ajoutez les villages pour chaque wilaya
];

try {
    // Insertion des wilayas
    $stmt = $pdo->prepare("INSERT INTO wilayas (code, name, ar_name, latitude, longitude) VALUES (?, ?, ?, ?, ?)");
    
    foreach ($wilayas as $wilaya) {
        $stmt->execute([
            $wilaya['code'],
            $wilaya['name'],
            $wilaya['ar_name'],
            $wilaya['latitude'],
            $wilaya['longitude']
        ]);
    }
    
    // Insertion des villages
    $stmt = $pdo->prepare("INSERT INTO villages (wilaya_id, name, ar_name) VALUES (?, ?, ?)");
    
    foreach ($villages as $wilayaId => $villageList) {
        foreach ($villageList as $village) {
            $stmt->execute([
                $wilayaId,
                $village[0], // Nom français
                $village[1]  // Nom arabe
            ]);
        }
    }
    
    echo "Import terminé avec succès!";
    
} catch (PDOException $e) {
    die("Erreur d'importation: " . $e->getMessage());
}