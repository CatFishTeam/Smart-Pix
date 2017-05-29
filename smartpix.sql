-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Dim 28 Mai 2017 à 19:00
-- Version du serveur :  5.7.14
-- Version de PHP :  7.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `smartpix`
--

-- --------------------------------------------------------

--
-- Structure de la table `album`
--

CREATE TABLE `album` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `background` varchar(150) DEFAULT '',
  `disposition` text,
  `description` text,
  `is_presentation` tinyint(1) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `album`
--

INSERT INTO `album` (`id`, `user_id`, `title`, `background`, `disposition`, `description`, `is_presentation`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 1, 'title', 'thing', 'test', 'description', 0, 0, '2017-05-23 18:06:23', '2017-05-23 18:06:23'),
(3, 3, 'test', NULL, NULL, '', 0, 0, '2017-05-24 08:52:02', '2017-05-24 08:52:02'),
(4, 3, 'test', NULL, NULL, '', 0, 0, '2017-05-24 08:57:16', '2017-05-24 08:57:16'),
(5, 3, 'test', NULL, NULL, 'desc', 0, 0, '2017-05-24 08:57:27', '2017-05-24 08:57:27'),
(6, 3, '', NULL, NULL, '', 0, 0, '2017-05-24 08:58:08', '2017-05-24 08:58:08'),
(7, 2, 'bonjour', NULL, NULL, '', 1, 0, '2017-05-27 22:22:44', '2017-05-27 22:22:44');

-- --------------------------------------------------------

--
-- Structure de la table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `is_confirmed` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `picture_id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `is_archived` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `email`
--

CREATE TABLE `email` (
  `id` int(11) NOT NULL,
  `subject` text NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `sent_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `picture`
--

CREATE TABLE `picture` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `album_id` int(11) DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `description` text,
  `url` text NOT NULL,
  `weight` int(11) NOT NULL,
  `is_visible` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `picture`
--

INSERT INTO `picture` (`id`, `user_id`, `album_id`, `title`, `description`, `url`, `weight`, `is_visible`, `created_at`, `updated_at`) VALUES
(47, 1, NULL, 'fsqddfqs', '', 'fsqddfqs_590c54db8ecc0.png', 650245, 0, '2017-05-05 10:32:59', '2017-05-05 10:32:59'),
(48, 1, NULL, 'Test', '', 'Test_590c54e475467.png', 91215, 0, '2017-05-05 10:33:08', '2017-05-05 10:33:08'),
(50, 1, NULL, 'Title', '', 'Title_590f07591522b.jpg', 29211, 0, '2017-05-07 11:39:05', '2017-05-07 11:39:05'),
(51, 2, NULL, 'Title', '', 'Title_590f076511abc.jpg', 29211, 0, '2017-05-07 11:39:17', '2017-05-07 12:59:30'),
(52, 1, NULL, 'test', '', 'test_590f08028f461.jpg', 29211, 0, '2017-05-07 11:41:54', '2017-05-07 11:41:54'),
(53, 1, NULL, 'test', '', 'test_590f080403db7.jpg', 29211, 0, '2017-05-07 11:41:56', '2017-05-07 11:41:56'),
(55, 1, NULL, 'test', '', 'test_590f08056824e.jpg', 29211, 0, '2017-05-07 11:41:57', '2017-05-07 11:41:57'),
(56, 1, NULL, 'test', '', 'test_590f086a7f629.png', 2040475, 0, '2017-05-07 11:43:38', '2017-05-07 11:43:38'),
(57, 1, NULL, 'test', '', 'test_590f0b84d387e.png', 2040475, 0, '2017-05-07 11:56:52', '2017-05-07 11:56:52'),
(58, 1, NULL, 'Test', '', 'Test_590f0c570891d.png', 2040475, 0, '2017-05-07 12:00:23', '2017-05-07 12:00:23'),
(59, 1, NULL, 'test', '', 'test_590f0c685870c.png', 2040475, 0, '2017-05-07 12:00:40', '2017-05-07 12:00:40'),
(62, 1, NULL, 'Swag', '', 'Swag_590f1495949f1.png', 2040475, 0, '2017-05-07 12:35:33', '2017-05-07 12:35:33'),
(63, 2, NULL, 'Swag', '', 'Swag_590f1de9031b6.png', 2040475, 0, '2017-05-07 13:15:21', '2017-05-07 13:15:21'),
(68, 2, NULL, 'title', 'desc', 'title_59245d1bc1696.jpg', 121371, 0, '2017-05-23 16:02:35', '2017-05-23 16:02:35'),
(70, 2, NULL, 'Ariana', 'Grande', 'Ariana_59245f9b9fcf5.jpg', 121371, 0, '2017-05-23 16:13:15', '2017-05-23 16:13:15'),
(73, 2, NULL, 'trst', '', 'trst_5924602009a82.jpg', 121371, 0, '2017-05-23 16:15:28', '2017-05-23 16:15:28'),
(75, 2, NULL, 'test', '', 'test_59246064f3d65.png', 91215, 0, '2017-05-23 16:16:36', '2017-05-23 16:16:36'),
(76, 2, NULL, 'Titre', '', 'Titre_592461c14c2af.png', 91215, 0, '2017-05-23 16:22:25', '2017-05-23 16:22:25'),
(81, 3, NULL, 'Title', 'Description', 'Title_592476030882d.png', 1868405, 0, '2017-05-23 17:48:51', '2017-05-23 17:48:51'),
(82, 3, NULL, 'test', '', 'test_59247d1d41ea6.png', 91215, 0, '2017-05-23 18:19:09', '2017-05-23 18:19:09');

-- --------------------------------------------------------

--
-- Structure de la table `picture_cart`
--

CREATE TABLE `picture_cart` (
  `picture_id` int(11) NOT NULL,
  `carts_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `stat`
--

CREATE TABLE `stat` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `picture_id` int(11) DEFAULT NULL,
  `album_id` int(11) DEFAULT NULL,
  `count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `tag`
--

CREATE TABLE `tag` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `tag_album`
--

CREATE TABLE `tag_album` (
  `tag_id` int(11) NOT NULL,
  `album_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `tag_picture`
--

CREATE TABLE `tag_picture` (
  `tag_id` int(11) NOT NULL,
  `picture_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `template`
--

CREATE TABLE `template` (
  `id` int(11) NOT NULL,
  `albums_id` int(11) NOT NULL,
  `name` varchar(60) NOT NULL,
  `disposition` json NOT NULL,
  `background` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(60) NOT NULL,
  `firstname` varchar(60) NOT NULL,
  `lastname` varchar(60) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(60) NOT NULL,
  `avatar` text NOT NULL,
  `permission` int(1) NOT NULL,
  `is_deleted` int(11) NOT NULL,
  `status` int(1) NOT NULL COMMENT '0 not validated, 1 validated, 2 deleted',
  `access_token` varchar(32) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`id`, `email`, `firstname`, `lastname`, `username`, `password`, `avatar`, `permission`, `is_deleted`, `status`, `access_token`, `updated_at`, `created_at`) VALUES
(1, 'luhjh', 'lkhljkh', 'lkjhlkjh', 'lkjhlkjh', 'lkjhklj', 'ljklhlkljh\n', 0, 0, 0, '0', '2017-05-04 11:35:24', '2017-05-04 11:35:24'),
(2, 'mael.mayon@free.fr', '', '', 'test', '$2y$10$wMwv2Ivi5Kys8qGp5F2PZ.IqwYZb2Iq40/hEFPwg4C6cn78DJGRFW', '', 1, 0, 0, '0', '2017-05-07 10:05:15', '2017-05-07 10:05:15'),
(3, 'mael.mayon@gmail.com', '', '', 'welldon', '$2y$10$xPBu4PHTMmG9P4rmi9yER.5Yn6cd.dLkHzWOJEZrZsQXnQi0GcM2W', '', 1, 0, 0, '0', '2017-05-23 12:23:45', '2017-05-23 12:23:45'),
(4, 'guillaumepn@free.fr', 'Guillaume', 'Pham ngoc', 'test5', '$2y$10$DFNF3521V5DZ.8dTwf4MWuEIaDMaEBLJeppNXVFtC8.ew.bz3Oocu', 'SP_592b1a3ae97fd.jpg', 1, 0, 1, '251810bc2942b709142607597cc4df67', '2017-05-28 18:40:45', '2017-05-28 18:40:45'),
(5, 'minimus76@gmail.com', '', '', 'test6', '$2y$10$xxyWJGW0nCB420jeiXSvnuiQQyJV6Tgri6zP2JVp4xSNuCnLku4aK', '', 1, 0, 0, '39c9025b703e0cbcdd279b2f302e3f2e', '2017-05-28 19:00:12', '2017-05-28 19:00:12');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `album`
--
ALTER TABLE `album`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Albums_Users` (`user_id`);

--
-- Index pour la table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_users` (`users_id`);

--
-- Index pour la table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Comments_Pictures` (`picture_id`),
  ADD KEY `comments_users` (`users_id`);

--
-- Index pour la table `email`
--
ALTER TABLE `email`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `picture`
--
ALTER TABLE `picture`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Pictures_Albums` (`album_id`),
  ADD KEY `Pictures_Users` (`user_id`);

--
-- Index pour la table `picture_cart`
--
ALTER TABLE `picture_cart`
  ADD PRIMARY KEY (`picture_id`,`carts_id`),
  ADD KEY `pictures_carts_carts` (`carts_id`);

--
-- Index pour la table `stat`
--
ALTER TABLE `stat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Stats_Albums` (`album_id`),
  ADD KEY `Stats_Pictures` (`picture_id`),
  ADD KEY `Stats_Users` (`user_id`);

--
-- Index pour la table `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `tag_album`
--
ALTER TABLE `tag_album`
  ADD PRIMARY KEY (`tag_id`,`album_id`),
  ADD KEY `Tags_Albums_Albums` (`album_id`);

--
-- Index pour la table `tag_picture`
--
ALTER TABLE `tag_picture`
  ADD PRIMARY KEY (`tag_id`,`picture_id`),
  ADD KEY `Tags_Pictures_Pictures` (`picture_id`);

--
-- Index pour la table `template`
--
ALTER TABLE `template`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Template_Albums` (`albums_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `album`
--
ALTER TABLE `album`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT pour la table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `email`
--
ALTER TABLE `email`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `picture`
--
ALTER TABLE `picture`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;
--
-- AUTO_INCREMENT pour la table `stat`
--
ALTER TABLE `stat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `tag`
--
ALTER TABLE `tag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `template`
--
ALTER TABLE `template`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `album`
--
ALTER TABLE `album`
  ADD CONSTRAINT `Albums_Users` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `carts_users` FOREIGN KEY (`users_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `Comments_Pictures` FOREIGN KEY (`picture_id`) REFERENCES `picture` (`id`),
  ADD CONSTRAINT `comments_users` FOREIGN KEY (`users_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `picture`
--
ALTER TABLE `picture`
  ADD CONSTRAINT `Pictures_Albums` FOREIGN KEY (`album_id`) REFERENCES `album` (`id`),
  ADD CONSTRAINT `Pictures_Users` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `picture_cart`
--
ALTER TABLE `picture_cart`
  ADD CONSTRAINT `Pictures_Cart_Pictures` FOREIGN KEY (`picture_id`) REFERENCES `picture` (`id`),
  ADD CONSTRAINT `pictures_carts_carts` FOREIGN KEY (`carts_id`) REFERENCES `cart` (`id`);

--
-- Contraintes pour la table `stat`
--
ALTER TABLE `stat`
  ADD CONSTRAINT `Stats_Albums` FOREIGN KEY (`album_id`) REFERENCES `album` (`id`),
  ADD CONSTRAINT `Stats_Pictures` FOREIGN KEY (`picture_id`) REFERENCES `picture` (`id`),
  ADD CONSTRAINT `Stats_Users` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `tag_album`
--
ALTER TABLE `tag_album`
  ADD CONSTRAINT `Tags_Albums_Albums` FOREIGN KEY (`album_id`) REFERENCES `album` (`id`),
  ADD CONSTRAINT `Tags_Albums_Tags` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`id`);

--
-- Contraintes pour la table `tag_picture`
--
ALTER TABLE `tag_picture`
  ADD CONSTRAINT `Tags_Pictures_Pictures` FOREIGN KEY (`picture_id`) REFERENCES `picture` (`id`),
  ADD CONSTRAINT `Tags_Pictures_Tags` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`id`);

--
-- Contraintes pour la table `template`
--
ALTER TABLE `template`
  ADD CONSTRAINT `Template_Albums` FOREIGN KEY (`albums_id`) REFERENCES `album` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
