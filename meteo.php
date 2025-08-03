<?php
require 'config.php';

// Récupérer la wilaya depuis l'URL
$wilayaName = $_GET['wilaya'] ?? '';
$villageName = $_GET['village'] ?? '';

// Requête pour récupérer les données de la wilaya
$stmt = $pdo->prepare("SELECT * FROM wilayas WHERE name = ?");
$stmt->execute([$wilayaName]);
$wilaya = $stmt->fetch();

if (!$wilaya) {
    header("HTTP/1.0 404 Not Found");
    die("Wilaya non trouvée");
}

// Requête pour la météo actuelle
$weatherStmt = $pdo->prepare("
    SELECT * FROM weather_data 
    WHERE wilaya_id = ? AND (village = ? OR village IS NULL)
    ORDER BY recorded_at DESC 
    LIMIT 1
");
$weatherStmt->execute([$wilaya['id'], $villageName]);
$currentWeather = $weatherStmt->fetch();

// Requête pour les prévisions
$forecastStmt = $pdo->prepare("
    SELECT * FROM weather_forecasts
    WHERE wilaya_id = ? 
    AND forecast_date >= CURDATE()
    ORDER BY forecast_date ASC
    LIMIT 5
");
$forecastStmt->execute([$wilaya['id']]);
$forecasts = $forecastStmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- Même head que la version HTML -->
</head>
<body>
    <!-- En-tête -->
    <header class="header">
        <a href="index.php" class="back-btn">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div class="header-content">
            <h1 class="wilaya-title">Météo - <?= htmlspecialchars($wilaya['name']) ?></h1>
            <p>Informations météorologiques détaillées</p>
        </div>
    </header>
    
    <!-- Contenu principal -->
    <div class="container">
        <!-- Sélecteurs -->
        <div class="selectors">
            <div class="select-box">
                <label for="wilaya-select">Wilaya</label>
                <select id="wilaya-select" onchange="updateVillages()">
                    <option value="">Sélectionnez une wilaya</option>
                    <?php
                    $wilayas = $pdo->query("SELECT name FROM wilayas ORDER BY name")->fetchAll();
                    foreach ($wilayas as $w) {
                        $selected = ($w['name'] === $wilayaName) ? 'selected' : '';
                        echo "<option value=\"{$w['name']}\" $selected>{$w['name']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="select-box">
                <label for="village-select">Village/Commune</label>
                <select id="village-select" onchange="updateWeather()" <?= empty($villageName) ? 'disabled' : '' ?>>
                    <option value="">Sélectionnez un village</option>
                    <?php
                    $villages = $pdo->query("SELECT DISTINCT village FROM weather_data WHERE wilaya_id = {$wilaya['id']} AND village IS NOT NULL")->fetchAll();
                    foreach ($villages as $v) {
                        $selected = ($v['village'] === $villageName) ? 'selected' : '';
                        echo "<option value=\"{$v['village']}\" $selected>{$v['village']}</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
        
        <!-- Carte météo principale -->
        <div class="weather-card">
            <div class="weather-header">
                <h2 class="location">
                    <?= htmlspecialchars($villageName ? $villageName : $wilaya['name']) ?>
                </h2>
                <p class="weather-date">
                    <?= date('l j F') ?>
                </p>
            </div>
            <div class="weather-main">
                <div class="weather-icon">
                    <?php
                    $icon = match(true) {
                        str_contains(strtolower($currentWeather['conditions']), 'soleil') => 'fa-sun',
                        str_contains(strtolower($currentWeather['conditions']), 'nuage') => 'fa-cloud',
                        str_contains(strtolower($currentWeather['conditions']), 'pluie') => 'fa-cloud-rain',
                        default => 'fa-cloud-sun'
                    };
                    ?>
                    <i class="fas <?= $icon ?>"></i>
                </div>
                <div class="weather-temp">
                    <?= $currentWeather['temperature'] ?>°C
                </div>
            </div>
            <div class="weather-details">
                <!-- Détails météo... -->
            </div>
        </div>
        
        <!-- Prévisions -->
        <h3 class="forecast-title">Prévisions sur 5 jours</h3>
        <div class="forecast-container">
            <?php foreach ($forecasts as $forecast): ?>
                <div class="forecast-card">
                    <div class="forecast-day">
                        <?= date('D', strtotime($forecast['forecast_date'])) ?>
                    </div>
                    <div class="forecast-icon">
                        <?php
                        $icon = match(true) {
                            str_contains(strtolower($forecast['conditions']), 'soleil') => 'fa-sun',
                            str_contains(strtolower($forecast['conditions']), 'nuage') => 'fa-cloud',
                            str_contains(strtolower($forecast['conditions']), 'pluie') => 'fa-cloud-rain',
                            default => 'fa-cloud-sun'
                        };
                        ?>
                        <i class="fas <?= $icon ?>"></i>
                    </div>
                    <div class="forecast-temp">
                        <span class="max-temp"><?= $forecast['max_temp'] ?>°</span>
                        <span class="min-temp"><?= $forecast['min_temp'] ?>°</span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script>
        // JavaScript similaire à la version HTML pour la dynamique
        function updateVillages() {
            const wilayaSelect = document.getElementById('wilaya-select');
            if (wilayaSelect.value) {
                window.location.href = `meteo.php?wilaya=${encodeURIComponent(wilayaSelect.value)}`;
            }
        }
        
        function updateWeather() {
            const wilayaSelect = document.getElementById('wilaya-select');
            const villageSelect = document.getElementById('village-select');
            if (villageSelect.value) {
                window.location.href = `meteo.php?wilaya=${encodeURIComponent(wilayaSelect.value)}&village=${encodeURIComponent(villageSelect.value)}`;
            }
        }
    </script>
</body>
</html>