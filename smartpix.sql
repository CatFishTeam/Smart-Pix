-- phpMyAdmin SQL Dump
-- version 4.7.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 14, 2017 at 10:45 PM
-- Server version: 5.6.35
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `smartpix`
--
CREATE DATABASE IF NOT EXISTS `smartpix` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `smartpix`;

-- --------------------------------------------------------

--
-- Table structure for table `action`
--

CREATE TABLE `action` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type_action` varchar(10) NOT NULL,
  `related_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `action`
--

INSERT INTO `action` (`id`, `user_id`, `type_action`, `related_id`, `created_at`) VALUES
(1, 6, 'picture', 98, '2017-06-05 00:19:19'),
(2, 6, 'picture', 99, '2017-06-06 00:28:42'),
(7, 11, 'signup', 11, '2017-07-03 17:24:02'),
(6, 10, 'album', 106, '2017-06-17 22:03:57'),
(8, 12, 'signup', 12, '2017-07-09 18:59:07'),
(9, 13, 'signup', 13, '2017-07-09 19:05:44'),
(10, 14, 'signup', 14, '2017-07-12 20:26:14');

-- --------------------------------------------------------

--
-- Table structure for table `album`
--

CREATE TABLE `album` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `thumbnail_url` varchar(150) DEFAULT '',
  `background` varchar(150) DEFAULT '',
  `disposition` text,
  `description` text,
  `is_presentation` tinyint(1) NOT NULL,
  `is_published` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `album`
--

INSERT INTO `album` (`id`, `user_id`, `title`, `thumbnail_url`, `background`, `disposition`, `description`, `is_presentation`, `is_published`, `created_at`, `updated_at`) VALUES
(106, 10, 'Yolo', NULL, NULL, NULL, 'Coast', 0, 1, '2017-06-17 22:03:57', '2017-06-17 22:03:57'),
(107, 10, 'Yolo', NULL, NULL, NULL, '', 0, 1, '2017-06-21 19:19:18', '2017-06-21 19:19:18');

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `picture_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `is_archived` tinyint(1) NOT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`id`, `content`, `created_at`, `picture_id`, `user_id`, `is_archived`, `is_published`) VALUES
(1, 'test', '2017-06-09 22:54:13', 103, 10, 1, 0),
(13, 'o', '2017-06-09 23:53:00', 104, 10, 1, 0),
(15, 'Tchoin', '2017-06-13 15:09:35', 103, 10, 0, 1),
(16, 'test', '2017-06-13 18:35:16', 103, 10, 1, 0),
(17, 'yolo', '2017-06-13 18:47:06', 103, 10, 1, 0),
(18, 'test', '2017-06-13 21:12:14', 104, 10, 1, 1),
(19, 'test', '2017-06-13 21:24:06', 104, 10, 1, 1),
(20, 'TEston', '2017-06-13 22:20:02', 104, 10, 0, 1),
(21, 'test', '2017-06-13 22:37:54', 103, 10, 1, 1),
(22, 'test', '2017-06-14 00:45:20', 103, 10, 1, 1),
(23, 'YOLOO', '2017-06-14 07:53:30', 103, 10, 0, 1),
(24, 'Ajout', '2017-06-17 21:35:39', 117, 10, 0, 1),
(25, 'test', '2017-06-17 21:59:01', 103, 10, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `community`
--

CREATE TABLE `community` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` int(11) NOT NULL,
  `slug` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `community_user`
--

CREATE TABLE `community_user` (
  `community_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `email`
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
-- Table structure for table `picture`
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
  `is_archived` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `picture`
--

INSERT INTO `picture` (`id`, `user_id`, `album_id`, `title`, `description`, `url`, `weight`, `is_visible`, `is_archived`, `created_at`, `updated_at`) VALUES
(103, 10, NULL, 'test', '', 'test_5939bda49e36e.jpg', 31706, 0, 0, '2017-06-08 21:12:04', '2017-06-17 21:49:10'),
(104, 10, NULL, 'test', '', 'test_5939ca5254a4e.png', 486288, 0, 0, '2017-06-08 22:06:10', '2017-06-17 21:49:08'),
(117, 10, NULL, 'Swaaag', '', 'Swaaag_5945a095a19be.jpg', 196531, 0, 0, '2017-06-17 21:35:17', '2017-06-17 21:35:17'),
(119, 10, NULL, 'fqsdqsd', '', 'fqsdqsd_5945a4fa7e143.png', 10688, 0, 0, '2017-06-17 21:54:02', '2017-06-17 21:54:02'),
(120, 10, NULL, 'fqdsfqd', '', 'fqdsfqd_5945a50123ef7.jpg', 196531, 0, 0, '2017-06-17 21:54:09', '2017-06-17 21:54:09'),
(121, 10, NULL, 'qfsqsd', '', 'qfsqsd_5945a509d0777.png', 10688, 0, 0, '2017-06-17 21:54:17', '2017-06-17 21:54:17'),
(122, 10, NULL, 'fqsdfqsd', '', 'fqsdfqsd_5945a51012c5c.jpg', 196531, 0, 0, '2017-06-17 21:54:24', '2017-06-17 21:54:24');

-- --------------------------------------------------------

--
-- Table structure for table `stat`
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
-- Table structure for table `tag`
--

CREATE TABLE `tag` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tag_album`
--

CREATE TABLE `tag_album` (
  `tag_id` int(11) NOT NULL,
  `album_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tag_picture`
--

CREATE TABLE `tag_picture` (
  `tag_id` int(11) NOT NULL,
  `picture_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `template`
--

CREATE TABLE `template` (
  `id` int(11) NOT NULL,
  `albums_id` int(11) NOT NULL,
  `name` varchar(60) NOT NULL,
  `disposition` text NOT NULL,
  `background` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user`
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
  `is_archived` int(11) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL COMMENT '0 not validated, 1 validated, 2 deleted',
  `access_token` varchar(32) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `firstname`, `lastname`, `username`, `password`, `avatar`, `permission`, `is_archived`, `status`, `access_token`, `created_at`, `updated_at`) VALUES
(4, 'guillaumepn@free.fr', 'Guillaume', 'Pham ngoc', 'test5', '$2y$10$DFNF3521V5DZ.8dTwf4MWuEIaDMaEBLJeppNXVFtC8.ew.bz3Oocu', 'SP_592b1a3ae97fd.jpg', 3, 0, 1, '251810bc2942b709142607597cc4df67', '2017-05-28 18:40:45', '2017-06-21 05:13:50'),
(5, 'minimus76@gmail.com', '', '', 'test6', '$2y$10$xxyWJGW0nCB420jeiXSvnuiQQyJV6Tgri6zP2JVp4xSNuCnLku4aK', '', 2, 0, 0, '39c9025b703e0cbcdd279b2f302e3f2e', '2017-05-28 19:00:12', '2017-06-21 05:22:32'),
(6, 'admin@guillaumepn.fr', 'Guillaume', 'Pham ngoc', 'guillaume', '$2y$10$LwGMvpxcHmFJ/29rwto1yuNVlF0fMZKiW0JdM7jx78j6ljMJt.HWq', 'SP_592ca24634184.jpg', 1, 0, 1, 'c949c64c08acc288f84142ee21e1c6d4', '2017-05-29 20:57:48', '2017-06-16 08:41:34'),
(7, 'contact@guillaumepn.fr', '', '', 'toto', '$2y$10$hD6Ls1j8ZUxcl3MSJiQKIeCni.LzhPEhTjd7LSytSGgy1te9xvERO', '', 2, 0, 1, 'ab707bcac780edd5c48b8866bd087fec', '2017-06-02 00:21:49', '2017-06-21 05:24:37'),
(10, '', '', '', 'Welldo', 'test', '', 4, 0, 1, '181eb2eb10aec9323a975be7b42f41ac', '2017-06-07 22:29:05', '2017-07-03 17:23:01'),
(14, 'mael.mayon@free.fr', '', '', 'welldon', '$2y$10$plynJYt63Q2XV65r2sjtzuw3ZJ4K7utUzSVzDxFDNmnEaMVyvKDl2', '', 2, 0, 1, '4ed04e8fa813cf148c599fdfa8054b43', '2017-07-12 20:26:14', '2017-07-12 20:59:05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `action`
--
ALTER TABLE `action`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `album`
--
ALTER TABLE `album`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Albums_Users` (`user_id`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Comments_Pictures` (`picture_id`),
  ADD KEY `comments_users` (`user_id`);

--
-- Indexes for table `community`
--
ALTER TABLE `community`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `community_user`
--
ALTER TABLE `community_user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `email`
--
ALTER TABLE `email`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `picture`
--
ALTER TABLE `picture`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Pictures_Albums` (`album_id`),
  ADD KEY `Pictures_Users` (`user_id`);


--
-- Indexes for table `stat`
--
ALTER TABLE `stat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Stats_Albums` (`album_id`),
  ADD KEY `Stats_Pictures` (`picture_id`),
  ADD KEY `Stats_Users` (`user_id`);

--
-- Indexes for table `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tag_album`
--
ALTER TABLE `tag_album`
  ADD PRIMARY KEY (`tag_id`,`album_id`),
  ADD KEY `Tags_Albums_Albums` (`album_id`);

--
-- Indexes for table `tag_picture`
--
ALTER TABLE `tag_picture`
  ADD PRIMARY KEY (`tag_id`,`picture_id`),
  ADD KEY `Tags_Pictures_Pictures` (`picture_id`);

--
-- Indexes for table `template`
--
ALTER TABLE `template`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Template_Albums` (`albums_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `action`
--
ALTER TABLE `action`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `album`
--
ALTER TABLE `album`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;
--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `community`
--
ALTER TABLE `community`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `email`
--
ALTER TABLE `email`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `picture`
--
ALTER TABLE `picture`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;
--
-- AUTO_INCREMENT for table `stat`
--
ALTER TABLE `stat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tag`
--
ALTER TABLE `tag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `template`
--
ALTER TABLE `template`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `album`
--
ALTER TABLE `album`
  ADD CONSTRAINT `Albums_Users` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `Comments_Pictures` FOREIGN KEY (`picture_id`) REFERENCES `picture` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_users` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `picture`
--
ALTER TABLE `picture`
  ADD CONSTRAINT `Pictures_Albums` FOREIGN KEY (`album_id`) REFERENCES `album` (`id`),
  ADD CONSTRAINT `Pictures_Users` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stat`
--
ALTER TABLE `stat`
  ADD CONSTRAINT `Stats_Albums` FOREIGN KEY (`album_id`) REFERENCES `album` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `Stats_Pictures` FOREIGN KEY (`picture_id`) REFERENCES `picture` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `Stats_Users` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tag_album`
--
ALTER TABLE `tag_album`
  ADD CONSTRAINT `Tags_Albums_Albums` FOREIGN KEY (`album_id`) REFERENCES `album` (`id`),
  ADD CONSTRAINT `Tags_Albums_Tags` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`id`);

--
-- Constraints for table `tag_picture`
--
ALTER TABLE `tag_picture`
  ADD CONSTRAINT `Tags_Pictures_Pictures` FOREIGN KEY (`picture_id`) REFERENCES `picture` (`id`),
  ADD CONSTRAINT `Tags_Pictures_Tags` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`id`);

--
-- Constraints for table `template`
--
ALTER TABLE `template`
  ADD CONSTRAINT `Template_Albums` FOREIGN KEY (`albums_id`) REFERENCES `album` (`id`);
