<?php
require 'config.php';

// Récupérer la wilaya depuis l'URL
$wilayaName = $_GET['wilaya'] ?? '';

// Requête pour récupérer les données de la wilaya
$stmt = $db->prepare("SELECT * FROM wilayas WHERE name = ?");
$stmt->execute([$wilayaName]);
$wilaya = $stmt->fetch();

if (!$wilaya) {
    header("HTTP/1.0 404 Not Found");
    die("Wilaya non trouvée");
}

// Requête pour les posts de la communauté
$postsStmt = $db->prepare("
    SELECT p.*, u.username, u.profile_pic 
    FROM community_posts p
    JOIN users u ON p.user_id = u.id
    WHERE p.wilaya_id = ?
    ORDER BY p.created_at DESC
    LIMIT 10
");
$postsStmt->execute([$wilaya['id']]);
$posts = $postsStmt->fetchAll();

// Requête pour la météo actuelle
$weatherStmt = $db->prepare("
    SELECT * FROM weather_data 
    WHERE wilaya_id = ?
    ORDER BY recorded_at DESC
    LIMIT 1
");
$weatherStmt->execute([$wilaya['id']]);
$weather = $weatherStmt->fetch();
?>
<!DOCTYPE html>
<html lang="fr">
<!-- Même structure HTML que précédemment, mais avec du PHP pour les données dynamiques -->

<!-- Dans le header -->
<h1 class="wilaya-title"><?= htmlspecialchars($wilaya['name']) ?></h1>

<!-- Section Communauté -->
<div class="community-section" id="communitySection">
    <?php foreach ($posts as $post): ?>
        <div class="post">
            <div class="post-header">
                <img src="<?= htmlspecialchars($post['profile_pic']) ?>" alt="User" class="user-avatar">
                <div class="user-info">
                    <div class="user-name"><?= htmlspecialchars($post['username']) ?></div>
                    <div class="post-time"><?= date('d/m/Y H:i', strtotime($post['created_at'])) ?></div>
                </div>
            </div>
            <div class="post-content">
                <p><?= nl2br(htmlspecialchars($post['content'])) ?></p>
                <?php if (!empty($post['image'])): ?>
                    <img src="<?= htmlspecialchars($post['image']) ?>" style="width:100%; margin-top:1rem; border-radius:8px;">
                <?php endif; ?>
            </div>
            <div class="post-actions">
                <a href="#" class="post-action"><i class="far fa-thumbs-up"></i> <?= $post['likes_count'] ?></a>
                <a href="#" class="post-action"><i class="far fa-comment"></i> <?= $post['comments_count'] ?></a>
                <a href="#" class="post-action"><i class="fas fa-share"></i> Partager</a>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<!-- Section Météo -->
<div class="weather-card">
    <div class="weather-icon">
        <?php
        $weatherIcon = match(true) {
            str_contains(strtolower($weather['conditions']), 'soleil') => 'fa-sun',
            str_contains(strtolower($weather['conditions']), 'nuage') => 'fa-cloud',
            str_contains(strtolower($weather['conditions']), 'pluie') => 'fa-cloud-rain',
            default => 'fa-cloud-sun'
        };
        ?>
        <i class="fas <?= $weatherIcon ?>"></i>
    </div>
    <div class="weather-temp"><?= $weather['temperature'] ?>°C</div>
    <div class="weather-desc"><?= htmlspecialchars($weather['conditions']) ?></div>
    
    <div class="weather-details">
        <div class="weather-detail">
            <i class="fas fa-droplet"></i>
            <span>Humidité: <?= $weather['humidity'] ?>%</span>
        </div>
        <!-- Autres détails météo... -->
    </div>
</div>

<script>
    // JavaScript similaire mais avec les données PHP
    document.addEventListener('DOMContentLoaded', function() {
        const wilayaName = "<?= addslashes($wilaya['name']) ?>";
        // ... reste du JavaScript ...
    });
</script>