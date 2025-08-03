<?php
require 'config.php';

header('Content-Type: application/json');

if (isset($_GET['wilaya'])) {
    $wilayaName = trim($_GET['wilaya']);
    
    try {
        // Récupérer les données météo depuis la base
        $stmt = $db->prepare("
            SELECT w.*, wd.temperature, wd.humidity, wd.wind_speed, wd.conditions 
            FROM wilayas w
            LEFT JOIN weather_data wd ON w.id = wd.wilaya_id
            WHERE w.name = ?
            ORDER BY wd.recorded_at DESC
            LIMIT 1
        ");
        $stmt->execute([$wilayaName]);
        $data = $stmt->fetch();
        
        if ($data) {
            echo json_encode([
                'status' => 'success',
                'data' => [
                    'temperature' => $data['temperature'],
                    'humidity' => $data['humidity'],
                    'wind_speed' => $data['wind_speed'],
                    'conditions' => $data['conditions']
                ]
            ]);
        } else {
            // Données par défaut si aucune donnée trouvée
            echo json_encode([
                'status' => 'success',
                'data' => [
                    'temperature' => rand(20, 35),
                    'humidity' => rand(30, 80),
                    'wind_speed' => rand(5, 20),
                    'conditions' => ['Ensoleillé', 'Nuageux', 'Pluie légère'][rand(0, 2)]
                ]
            ]);
        }
    } catch(PDOException $e) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Erreur de base de données'
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Paramètre wilaya manquant'
    ]);
}
?>