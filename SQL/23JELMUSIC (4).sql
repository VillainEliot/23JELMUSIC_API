-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : mar. 07 mai 2024 à 11:31
-- Version du serveur : 8.0.25
-- Version de PHP : 8.1.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `23JELMUSIC`
--

-- --------------------------------------------------------

--
-- Structure de la table `accessoire`
--

CREATE TABLE `accessoire` (
  `id` int NOT NULL,
  `instrument_id` int NOT NULL,
  `libelle` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `accessoire`
--

INSERT INTO `accessoire` (`id`, `instrument_id`, `libelle`) VALUES
(1, 1, 'Corde'),
(2, 2, 'Grattoir');

-- --------------------------------------------------------

--
-- Structure de la table `classe_instrument`
--

CREATE TABLE `classe_instrument` (
  `id` int NOT NULL,
  `libelle` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `classe_instrument`
--

INSERT INTO `classe_instrument` (`id`, `libelle`) VALUES
(1, 'Claviers'),
(2, 'Instrument amplifié'),
(3, 'Bois'),
(4, 'Cuivres'),
(5, 'Cordes'),
(6, 'Percussions');

-- --------------------------------------------------------

--
-- Structure de la table `contrat_pret`
--

CREATE TABLE `contrat_pret` (
  `id` int NOT NULL,
  `eleve_id` int DEFAULT NULL,
  `date_debut` date DEFAULT NULL,
  `date_fin` date DEFAULT NULL,
  `attestation_assurance` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `etat_detaille_debut` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `etat_detaille_retour` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instrument_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `contrat_pret`
--

INSERT INTO `contrat_pret` (`id`, `eleve_id`, `date_debut`, `date_fin`, `attestation_assurance`, `etat_detaille_debut`, `etat_detaille_retour`, `instrument_id`) VALUES
(1, 1, '2023-10-30', '2023-11-04', 'pièce jointe', 'bon état', 'mauvais', 2),
(2, 2, '2021-08-09', '2021-11-30', 'egrzgreg', 'neuf', 'excellent état ', 5),
(4, 3, '2023-11-07', '2023-11-29', 'piece jointe', 'neuf', 'bonne etat', 7),
(11, 2, '2023-11-27', '2023-12-23', NULL, 'bon état', NULL, 5);

-- --------------------------------------------------------

--
-- Structure de la table `couleur`
--

CREATE TABLE `couleur` (
  `id` int NOT NULL,
  `nom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `couleur`
--

INSERT INTO `couleur` (`id`, `nom`) VALUES
(1, 'Blanc'),
(2, 'Jaune'),
(3, 'Bleu'),
(4, 'Rouge');

-- --------------------------------------------------------

--
-- Structure de la table `cours`
--

CREATE TABLE `cours` (
  `id` int NOT NULL,
  `type_cours_id` int DEFAULT NULL,
  `jours_id` int DEFAULT NULL,
  `professeur_id` int DEFAULT NULL,
  `age_mini` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `heure_debut` time NOT NULL,
  `heure_fin` time NOT NULL,
  `nb_places` int NOT NULL,
  `age_maxi` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_instruments_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `cours`
--

INSERT INTO `cours` (`id`, `type_cours_id`, `jours_id`, `professeur_id`, `age_mini`, `heure_debut`, `heure_fin`, `nb_places`, `age_maxi`, `type_instruments_id`) VALUES
(1, 2, 3, 1, '5', '18:00:00', '19:00:00', 15, '12', 2),
(2, 2, 3, 1, '13', '17:00:00', '18:00:00', 6, '15', 1),
(3, 2, 1, 1, '13', '10:00:00', '11:00:00', 6, '15', 1),
(4, 2, 1, 2, '5', '10:30:00', '11:30:00', 10, '9', 12);

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20231122094656', '2023-11-27 10:45:44', 10275),
('DoctrineMigrations\\Version20231129075015', '2023-11-29 07:50:20', 1489),
('DoctrineMigrations\\Version20231129085614', '2023-11-29 08:56:57', 4448),
('DoctrineMigrations\\Version20231206124148', '2023-12-06 12:41:58', 1891),
('DoctrineMigrations\\Version20231213072342', '2023-12-13 07:24:20', 1013);

-- --------------------------------------------------------

--
-- Structure de la table `eleve`
--

CREATE TABLE `eleve` (
  `id` int NOT NULL,
  `nom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `num_rue` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rue` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `copos` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ville` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tel` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `eleve`
--

INSERT INTO `eleve` (`id`, `nom`, `prenom`, `num_rue`, `rue`, `copos`, `ville`, `tel`, `mail`) VALUES
(1, 'Etienne', 'Cador', '16', 'rue du parc', '14000', 'Caen', '0231545612', 'c.etienne@gmail.com'),
(2, 'Simon', 'Zoe', '4685', 'Rue du moulin', '45000', 'Caen', '0256963847', 'Simon@gmail.com'),
(3, 'Varin', 'Joy', '2', 'Rue du monde', '27500', 'Pont-audemer', '0215147495', 'Varin@gmail.com');

-- --------------------------------------------------------

--
-- Structure de la table `eleve_responsable`
--

CREATE TABLE `eleve_responsable` (
  `eleve_id` int NOT NULL,
  `responsable_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `eleve_responsable`
--

INSERT INTO `eleve_responsable` (`eleve_id`, `responsable_id`) VALUES
(1, 1),
(1, 2),
(2, 2),
(3, 1);

-- --------------------------------------------------------

--
-- Structure de la table `inscription`
--

CREATE TABLE `inscription` (
  `id` int NOT NULL,
  `cours_id` int DEFAULT NULL,
  `eleve_id` int DEFAULT NULL,
  `date_inscription` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `inscription`
--

INSERT INTO `inscription` (`id`, `cours_id`, `eleve_id`, `date_inscription`) VALUES
(1, 1, 1, '2023-11-02');

-- --------------------------------------------------------

--
-- Structure de la table `instrument`
--

CREATE TABLE `instrument` (
  `id` int NOT NULL,
  `marque_id` int NOT NULL,
  `type_id` int NOT NULL,
  `num_serie` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_achat` date NOT NULL,
  `prix_achat` double NOT NULL,
  `utilisation` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `chemin_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nom` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `instrument`
--

INSERT INTO `instrument` (`id`, `marque_id`, `type_id`, `num_serie`, `date_achat`, `prix_achat`, `utilisation`, `chemin_image`, `nom`) VALUES
(1, 1, 5, '5', '2023-11-01', 350.99, 'prêt', '/imgBasse Electrique', 'BE-1'),
(2, 2, 4, '2', '2023-11-03', 400, 'prêt', 'Guittare Electrique', 'GE-1'),
(3, 4, 7, '3', '2018-01-01', 199.99, 'prêt', '/img/imgClarinette', 'Cla-1'),
(4, 4, 12, 'VIO-01', '2018-01-01', 200, 'prêt', '/imgViolon', 'Vio-1'),
(5, 4, 9, '3', '2018-01-01', 200, 'prêt', 'Trombonne', 'Tro-1'),
(6, 4, 6, '3', '2018-01-01', 200, 'prêt', '/imgSaxophone', 'Sax-1'),
(7, 4, 2, '5', '2018-01-01', 300, 'prêt', 'Piano', 'Pia-1'),
(8, 4, 5, 'BE-02', '2023-12-09', 299.95, 'Cours', '/img/img', 'BE-2'),
(9, 3, 5, 'BE-03', '2023-12-28', 1199.99, 'Cours', '/img/img', 'BE-3'),
(10, 3, 13, '1201511', '2023-12-11', 552, 'prêt', '/img', 'VIo-332');

-- --------------------------------------------------------

--
-- Structure de la table `instrument_couleur`
--

CREATE TABLE `instrument_couleur` (
  `instrument_id` int NOT NULL,
  `couleur_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `instrument_couleur`
--

INSERT INTO `instrument_couleur` (`instrument_id`, `couleur_id`) VALUES
(1, 3),
(2, 4),
(8, 2),
(8, 3),
(10, 1),
(10, 3),
(13, 4);

-- --------------------------------------------------------

--
-- Structure de la table `intervention`
--

CREATE TABLE `intervention` (
  `id` int NOT NULL,
  `instrument_id` int DEFAULT NULL,
  `professionnel_id` int DEFAULT NULL,
  `date_debut` date DEFAULT NULL,
  `date_fin` date DEFAULT NULL,
  `descriptif` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prix` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `intervention`
--

INSERT INTO `intervention` (`id`, `instrument_id`, `professionnel_id`, `date_debut`, `date_fin`, `descriptif`, `prix`) VALUES
(1, 2, 2, '2023-11-08', '2023-11-24', 'Changement des cordages', 49.99),
(2, 1, 1, '2023-11-06', '2023-11-10', 'Changement des cordages', 49.99),
(3, 3, 1, '2023-11-13', '2023-11-15', 'Changement du bec', 80),
(10, 1, 2, '2023-12-02', '2023-12-10', 'Réparation de le structure', 349.99),
(11, 1, 2, '2023-12-01', '2023-12-02', 'Accordement de la guitare', 25),
(12, 3, 1, '2023-12-01', '2023-12-08', 'Nettoyage de l\'instrument', 30);

-- --------------------------------------------------------

--
-- Structure de la table `inter_pret`
--

CREATE TABLE `inter_pret` (
  `id` int NOT NULL,
  `intervention_id` int DEFAULT NULL,
  `contrat_pret_id` int DEFAULT NULL,
  `quotite` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `inter_pret`
--

INSERT INTO `inter_pret` (`id`, `intervention_id`, `contrat_pret_id`, `quotite`) VALUES
(1, 3, 4, 30),
(2, 1, 1, 20);

-- --------------------------------------------------------

--
-- Structure de la table `jours`
--

CREATE TABLE `jours` (
  `id` int NOT NULL,
  `libelle` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `jours`
--

INSERT INTO `jours` (`id`, `libelle`) VALUES
(1, 'Lundi'),
(2, 'Mardi'),
(3, 'Mercredi'),
(4, 'Jeudi'),
(5, 'Vendredi'),
(6, 'Samedi'),
(7, 'Dimanche');

-- --------------------------------------------------------

--
-- Structure de la table `marque`
--

CREATE TABLE `marque` (
  `id` int NOT NULL,
  `libelle` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `marque`
--

INSERT INTO `marque` (`id`, `libelle`) VALUES
(1, 'Shiver'),
(2, 'Fender'),
(3, 'Gibson'),
(4, 'Yamaha');

-- --------------------------------------------------------

--
-- Structure de la table `messenger_messages`
--

CREATE TABLE `messenger_messages` (
  `id` bigint NOT NULL,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `metier`
--

CREATE TABLE `metier` (
  `id` int NOT NULL,
  `libelle` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `metier`
--

INSERT INTO `metier` (`id`, `libelle`) VALUES
(1, 'plombier'),
(2, 'chauffagiste'),
(3, 'paysagiste'),
(4, 'chauffeur poids lourd');

-- --------------------------------------------------------

--
-- Structure de la table `professeur`
--

CREATE TABLE `professeur` (
  `id` int NOT NULL,
  `nom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `num_rue` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rue` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `copos` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ville` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tel` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `professeur`
--

INSERT INTO `professeur` (`id`, `nom`, `prenom`, `num_rue`, `rue`, `copos`, `ville`, `tel`, `mail`) VALUES
(1, 'Thomas', 'Bouquet', '12', 'rue des coclicos', '14000', 'Caen', '0231547217', 'b.thomas@gmail.com'),
(2, 'Guerinet', 'Serge', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Structure de la table `professionnel`
--

CREATE TABLE `professionnel` (
  `id` int NOT NULL,
  `nom` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `num_rue` int DEFAULT NULL,
  `rue` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `copos` int DEFAULT NULL,
  `ville` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tel` int DEFAULT NULL,
  `mail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `professionnel`
--

INSERT INTO `professionnel` (`id`, `nom`, `num_rue`, `rue`, `copos`, `ville`, `tel`, `mail`) VALUES
(1, 'Neusy', 23, 'Rue du lac', 76600, 'Havre', 245967455, 'Neusy@gmail.com'),
(2, 'Guerard', 3, 'Rue de l\'horloge', 76000, 'Rouen', 247856633, 'guerard@gmail.com');

-- --------------------------------------------------------

--
-- Structure de la table `professionnel_metier`
--

CREATE TABLE `professionnel_metier` (
  `professionnel_id` int NOT NULL,
  `metier_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `professionnel_metier`
--

INSERT INTO `professionnel_metier` (`professionnel_id`, `metier_id`) VALUES
(1, 3),
(2, 1);

-- --------------------------------------------------------

--
-- Structure de la table `responsable`
--

CREATE TABLE `responsable` (
  `id` int NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `num_rue` int DEFAULT NULL,
  `rue` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tel` int DEFAULT NULL,
  `mail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `responsable`
--

INSERT INTO `responsable` (`id`, `nom`, `prenom`, `num_rue`, `rue`, `tel`, `mail`) VALUES
(1, 'Iffam', 'Annais', 17, 'Rue des Saules', 215368874, 'Iffam@gmail.com'),
(2, 'Quildbeuf', 'Romane', 26, 'Rue des libellule ', 236561477, 'Quildbeuf');

-- --------------------------------------------------------

--
-- Structure de la table `type_cours`
--

CREATE TABLE `type_cours` (
  `id` int NOT NULL,
  `libelle` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `type_cours`
--

INSERT INTO `type_cours` (`id`, `libelle`) VALUES
(1, 'Cours Individuel'),
(2, 'Cours Collectif');

-- --------------------------------------------------------

--
-- Structure de la table `type_instrument`
--

CREATE TABLE `type_instrument` (
  `id` int NOT NULL,
  `classe_id` int NOT NULL,
  `libelle` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `type_instrument`
--

INSERT INTO `type_instrument` (`id`, `classe_id`, `libelle`) VALUES
(1, 1, 'Orgue'),
(2, 1, 'Piano'),
(3, 2, 'Clavier Amplifier'),
(4, 2, 'Guitare Electrique'),
(5, 2, 'Basse Electrique'),
(6, 3, 'Saxophone'),
(7, 3, 'Clarinette'),
(8, 3, 'Flute Traversière'),
(9, 4, 'Trombone'),
(10, 4, 'Trompette'),
(11, 4, 'Tuba'),
(12, 5, 'Violon'),
(13, 5, 'Violoncelle'),
(14, 5, 'Harpe Celtique'),
(15, 6, 'Batterie');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`) VALUES
(4, 'resp@jelmusic.com', '[\"ROLE_RESP\"]', '$2y$13$kEqH3f832C83tQp4vF6g0OxMWJgd28gBdfygi/P0aOZo0MILt94lm'),
(5, 'eleve@jelmusic.com', '[\"ROLE_ELEVE\"]', '$2y$13$LrGEaLsorZ1tiSHVX2POM.7dNqSaK7V/qkUpvtKNhp0H15qf5xhr.'),
(10, 'admin@jelmusic.com', '[\"ROLE_ADMIN\"]', '$2y$13$fOLacv73jbu4cqn77qUUiuz3ZXlVPFqvubOmL67sLQxXas4RDgYeu');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `accessoire`
--
ALTER TABLE `accessoire`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_8FD026ACF11D9C` (`instrument_id`);

--
-- Index pour la table `classe_instrument`
--
ALTER TABLE `classe_instrument`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `contrat_pret`
--
ALTER TABLE `contrat_pret`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_1FB84C67A6CC7B2` (`eleve_id`),
  ADD KEY `IDX_1FB84C67CF11D9C` (`instrument_id`);

--
-- Index pour la table `couleur`
--
ALTER TABLE `couleur`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `cours`
--
ALTER TABLE `cours`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_FDCA8C9CB3305F4C` (`type_cours_id`),
  ADD KEY `IDX_FDCA8C9C6180639B` (`jours_id`),
  ADD KEY `IDX_FDCA8C9CBAB22EE9` (`professeur_id`),
  ADD KEY `IDX_FDCA8C9C4807BAC3` (`type_instruments_id`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `eleve`
--
ALTER TABLE `eleve`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `eleve_responsable`
--
ALTER TABLE `eleve_responsable`
  ADD PRIMARY KEY (`eleve_id`,`responsable_id`),
  ADD KEY `IDX_D7350730A6CC7B2` (`eleve_id`),
  ADD KEY `IDX_D735073053C59D72` (`responsable_id`);

--
-- Index pour la table `inscription`
--
ALTER TABLE `inscription`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_5E90F6D67ECF78B0` (`cours_id`),
  ADD KEY `IDX_5E90F6D6A6CC7B2` (`eleve_id`);

--
-- Index pour la table `instrument`
--
ALTER TABLE `instrument`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_3CBF69DD4827B9B2` (`marque_id`),
  ADD KEY `IDX_3CBF69DDC54C8C93` (`type_id`);

--
-- Index pour la table `instrument_couleur`
--
ALTER TABLE `instrument_couleur`
  ADD PRIMARY KEY (`instrument_id`,`couleur_id`),
  ADD KEY `IDX_443EF844CF11D9C` (`instrument_id`),
  ADD KEY `IDX_443EF844C31BA576` (`couleur_id`);

--
-- Index pour la table `intervention`
--
ALTER TABLE `intervention`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_D11814ABCF11D9C` (`instrument_id`),
  ADD KEY `IDX_D11814AB8A49CC82` (`professionnel_id`);

--
-- Index pour la table `inter_pret`
--
ALTER TABLE `inter_pret`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_244C23678EAE3863` (`intervention_id`),
  ADD KEY `IDX_244C2367B2AF233D` (`contrat_pret_id`);

--
-- Index pour la table `jours`
--
ALTER TABLE `jours`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `marque`
--
ALTER TABLE `marque`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  ADD KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  ADD KEY `IDX_75EA56E016BA31DB` (`delivered_at`);

--
-- Index pour la table `metier`
--
ALTER TABLE `metier`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `professeur`
--
ALTER TABLE `professeur`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `professionnel`
--
ALTER TABLE `professionnel`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `professionnel_metier`
--
ALTER TABLE `professionnel_metier`
  ADD PRIMARY KEY (`professionnel_id`,`metier_id`),
  ADD KEY `IDX_715C73CA8A49CC82` (`professionnel_id`),
  ADD KEY `IDX_715C73CAED16FA20` (`metier_id`);

--
-- Index pour la table `responsable`
--
ALTER TABLE `responsable`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `type_cours`
--
ALTER TABLE `type_cours`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `type_instrument`
--
ALTER TABLE `type_instrument`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_21BCBFF88F5EA509` (`classe_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `accessoire`
--
ALTER TABLE `accessoire`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `classe_instrument`
--
ALTER TABLE `classe_instrument`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `contrat_pret`
--
ALTER TABLE `contrat_pret`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `couleur`
--
ALTER TABLE `couleur`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `cours`
--
ALTER TABLE `cours`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `eleve`
--
ALTER TABLE `eleve`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `inscription`
--
ALTER TABLE `inscription`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `instrument`
--
ALTER TABLE `instrument`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `intervention`
--
ALTER TABLE `intervention`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `inter_pret`
--
ALTER TABLE `inter_pret`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `jours`
--
ALTER TABLE `jours`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `marque`
--
ALTER TABLE `marque`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `metier`
--
ALTER TABLE `metier`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `professeur`
--
ALTER TABLE `professeur`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `professionnel`
--
ALTER TABLE `professionnel`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `responsable`
--
ALTER TABLE `responsable`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `type_cours`
--
ALTER TABLE `type_cours`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `type_instrument`
--
ALTER TABLE `type_instrument`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `contrat_pret`
--
ALTER TABLE `contrat_pret`
  ADD CONSTRAINT `FK_1FB84C67A6CC7B2` FOREIGN KEY (`eleve_id`) REFERENCES `eleve` (`id`),
  ADD CONSTRAINT `FK_1FB84C67CF11D9C` FOREIGN KEY (`instrument_id`) REFERENCES `instrument` (`id`);

--
-- Contraintes pour la table `cours`
--
ALTER TABLE `cours`
  ADD CONSTRAINT `FK_FDCA8C9C4807BAC3` FOREIGN KEY (`type_instruments_id`) REFERENCES `type_instrument` (`id`),
  ADD CONSTRAINT `FK_FDCA8C9C6180639B` FOREIGN KEY (`jours_id`) REFERENCES `jours` (`id`),
  ADD CONSTRAINT `FK_FDCA8C9CB3305F4C` FOREIGN KEY (`type_cours_id`) REFERENCES `type_cours` (`id`),
  ADD CONSTRAINT `FK_FDCA8C9CBAB22EE9` FOREIGN KEY (`professeur_id`) REFERENCES `professeur` (`id`);

--
-- Contraintes pour la table `instrument`
--
ALTER TABLE `instrument`
  ADD CONSTRAINT `FK_3CBF69DD4827B9B2` FOREIGN KEY (`marque_id`) REFERENCES `marque` (`id`),
  ADD CONSTRAINT `FK_3CBF69DDC54C8C93` FOREIGN KEY (`type_id`) REFERENCES `type_instrument` (`id`);

--
-- Contraintes pour la table `intervention`
--
ALTER TABLE `intervention`
  ADD CONSTRAINT `FK_D11814AB8A49CC82` FOREIGN KEY (`professionnel_id`) REFERENCES `professionnel` (`id`),
  ADD CONSTRAINT `FK_D11814ABCF11D9C` FOREIGN KEY (`instrument_id`) REFERENCES `instrument` (`id`);

--
-- Contraintes pour la table `professionnel_metier`
--
ALTER TABLE `professionnel_metier`
  ADD CONSTRAINT `FK_715C73CA8A49CC82` FOREIGN KEY (`professionnel_id`) REFERENCES `professionnel` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_715C73CAED16FA20` FOREIGN KEY (`metier_id`) REFERENCES `metier` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `type_instrument`
--
ALTER TABLE `type_instrument`
  ADD CONSTRAINT `FK_21BCBFF88F5EA509` FOREIGN KEY (`classe_id`) REFERENCES `classe_instrument` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
