<?php
session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Nettoyer les entrées
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $wilaya = trim($_POST['wilaya']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validation de base
    if (empty($username) || empty($email) || empty($wilaya) || empty($password) || empty($confirm_password)) {
        header('Location: register.html?error=empty_fields');
        exit();
    }
    
    if ($password !== $confirm_password) {
        header('Location: register.html?error=password_mismatch');
        exit();
    }
    
    if (strlen($password) < 8) {
        header('Location: register.html?error=weak_password');
        exit();
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('Location: register.html?error=invalid_email');
        exit();
    }
    
    try {
        // Vérifier si l'utilisateur existe déjà
        $stmt = $db->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        $existingUser = $stmt->fetch();
        
        if ($existingUser) {
            if (strtolower($existingUser['username']) === strtolower($username)) {
                header('Location: register.html?error=username_exists');
            } else {
                header('Location: register.html?error=email_exists');
            }
            exit();
        }
        
        // Hacher le mot de passe
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        
        // Insérer le nouvel utilisateur
        $stmt = $db->prepare("INSERT INTO users (username, email, wilaya, password) VALUES (?, ?, ?, ?)");
        $stmt->execute([$username, $email, $wilaya, $hashedPassword]);
        
        // Rediriger vers la page de connexion avec un message de succès
        header('Location: register.html?success=1');
        exit();
        
    } catch(PDOException $e) {
        error_log('Erreur d\'inscription: ' . $e->getMessage());
        header('Location: register.html?error=server_error');
        exit();
    }
} else {
    // Si quelqu'un essaie d'accéder directement au script
    header('Location: register.html');
    exit();
}
?>