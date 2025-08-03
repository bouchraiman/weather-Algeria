-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306:4306
-- Généré le : mar. 10 juin 2025 à 00:17
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `weather_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `communautes`
--

CREATE TABLE `communautes` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `wilaya_id` int(11) DEFAULT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `communautes`
--

INSERT INTO `communautes` (`id`, `nom`, `wilaya_id`, `latitude`, `longitude`) VALUES
(1, 'Bab El Oued', 1, NULL, NULL),
(2, 'El Madania', 1, NULL, NULL),
(3, 'Bir El Djir', 2, NULL, NULL),
(4, 'Es Senia', 2, NULL, NULL),
(5, 'Boufarik', 3, NULL, NULL),
(6, 'Mouzaia', 3, NULL, NULL),
(7, 'Bab El Oued', 1, NULL, NULL),
(8, 'Bir Mourad Raïs', 1, NULL, NULL),
(9, 'El Bahia', 2, NULL, NULL),
(10, 'Sidi El Houari', 2, NULL, NULL),
(11, 'Reggane', 3, NULL, NULL),
(12, 'Timimoun', 3, NULL, NULL),
(13, 'Boufarik', 11, NULL, NULL),
(14, 'Ouled Yaïch', 11, NULL, NULL),
(15, 'Meftah', 11, NULL, NULL),
(16, 'Larbaâ', 11, NULL, NULL),
(17, 'Beni Mered', 11, NULL, NULL),
(18, 'Taghit', 12, NULL, NULL),
(19, 'Kenadsa', 12, NULL, NULL),
(20, 'Beni Ounif', 12, NULL, NULL),
(21, 'Igli', 12, NULL, NULL),
(22, 'Boukais', 12, NULL, NULL),
(23, 'Maghnia', 13, NULL, NULL),
(24, 'Ghazaouet', 13, NULL, NULL),
(25, 'Sebdou', 13, NULL, NULL),
(26, 'Remchi', 13, NULL, NULL),
(27, 'Beni Snous', 13, NULL, NULL),
(28, 'Aïn Nouïssy', 14, NULL, NULL),
(29, 'Kheir Eddine', 14, NULL, NULL),
(30, 'Mesra', 14, NULL, NULL),
(31, 'Sidi Lakhdar', 14, NULL, NULL),
(32, 'Hassi Mameche', 14, NULL, NULL),
(33, 'Rogassa', 15, NULL, NULL),
(34, 'Bougtob', 15, NULL, NULL),
(35, 'Brézina', 15, NULL, NULL),
(36, 'El Abiodh Sidi Cheikh', 15, NULL, NULL),
(37, 'Cheguig', 15, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `meteo`
--

CREATE TABLE `meteo` (
  `id` int(11) NOT NULL,
  `village` varchar(100) DEFAULT NULL,
  `temperature` float DEFAULT NULL,
  `humidite` int(11) DEFAULT NULL,
  `pression` int(11) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `vitesse_vent` float DEFAULT NULL,
  `lever_soleil` time DEFAULT NULL,
  `coucher_soleil` time DEFAULT NULL,
  `date_enregistrement` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `meteo_village`
--

CREATE TABLE `meteo_village` (
  `id` int(11) NOT NULL,
  `village_nom` varchar(100) NOT NULL,
  `temperature` float DEFAULT NULL,
  `humidite` int(11) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `meteo_village`
--

INSERT INTO `meteo_village` (`id`, `village_nom`, `temperature`, `humidite`, `description`, `date`) VALUES
(1, 'Ain El Beida', 28.3, 48, 'Partiellement nuageux', '2025-05-17 18:09:31'),
(2, 'Bab El Oued', 24.5, 65, 'Ensoleillé', '2025-05-17 18:27:17'),
(3, 'El Harrach', 23.1, 70, 'Partiellement nuageux', '2025-05-17 18:27:17'),
(4, 'Bir El Djir', 25.2, 60, 'Clair', '2025-05-17 18:27:17'),
(5, 'Es Senia', 26.4, 58, 'Ciel dégagé', '2025-05-17 18:27:17'),
(6, 'Boufarik', 22.9, 72, 'Nuageux', '2025-05-17 18:27:17'),
(7, 'Ouled Yaïch', 21.7, 75, 'Averses', '2025-05-17 18:27:17');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `wilaya` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `profile_pic` varchar(255) DEFAULT 'default.jpg',
  `bio` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users2`
--

CREATE TABLE `users2` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `wilaya` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `profile_pic` varchar(255) DEFAULT 'default.jpg',
  `bio` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$GmnhvDkySSaq1CsVlMQx9.7HM32YgpnCzX1hRJEO7Wb76sKZERJGO');

-- --------------------------------------------------------

--
-- Structure de la table `wilayas`
--

CREATE TABLE `wilayas` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `wilayas`
--

INSERT INTO `wilayas` (`id`, `nom`) VALUES
(1, 'Alger'),
(2, 'Oran'),
(3, 'Blida'),
(4, 'Constantine'),
(5, 'Alger'),
(6, 'Oran'),
(7, 'Adrar'),
(8, 'Alger'),
(9, 'Oran'),
(10, 'Adrar'),
(11, 'Blida'),
(12, 'Béchar'),
(13, 'Tlemcen'),
(14, 'Mostaganem'),
(15, 'El Bayadh');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `communautes`
--
ALTER TABLE `communautes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wilaya_id` (`wilaya_id`);

--
-- Index pour la table `meteo`
--
ALTER TABLE `meteo`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `meteo_village`
--
ALTER TABLE `meteo_village`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `users2`
--
ALTER TABLE `users2`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `wilayas`
--
ALTER TABLE `wilayas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `communautes`
--
ALTER TABLE `communautes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT pour la table `meteo`
--
ALTER TABLE `meteo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `meteo_village`
--
ALTER TABLE `meteo_village`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `users2`
--
ALTER TABLE `users2`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `wilayas`
--
ALTER TABLE `wilayas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `communautes`
--
ALTER TABLE `communautes`
  ADD CONSTRAINT `communautes_ibfk_1` FOREIGN KEY (`wilaya_id`) REFERENCES `wilayas` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
