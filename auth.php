<?php
session_start();
require 'config.php';

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Nettoyer les entrées
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    
    // Validation de base
    if (empty($username) || empty($password)) {
        header('Location: login.html?error=empty_fields');
        exit();
    }
    
    try {
        // Préparer la requête
        $stmt = $db->prepare("SELECT id, username, password FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Vérifier l'utilisateur et le mot de passe
        if ($user && password_verify($password, $user['password'])) {
            // Créer la session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            
            // Rediriger vers la page d'accueil
            header('Location: index.html');
            exit();
        } else {
            // Identifiants invalides
            header('Location: login.html?error=invalid_credentials');
            exit();
        }
    } catch(PDOException $e) {
        // Journaliser l'erreur (en production, utilisez un système de logging)
        error_log('Erreur de connexion: ' . $e->getMessage());
        
        // Rediriger avec un message d'erreur générique
        header('Location: login.html?error=server_error');
        exit();
    }
} else {
    // Si quelqu'un essaie d'accéder directement au script
    header('Location: login.html');
    exit();
}
?>