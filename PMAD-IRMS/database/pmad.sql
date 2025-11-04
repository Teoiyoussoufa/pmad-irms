-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 21 juil. 2025 à 13:23
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
-- Base de données : `pmad`
--

-- --------------------------------------------------------

--
-- Structure de la table `blog`
--

CREATE TABLE `blog` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `author_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `companies`
--

CREATE TABLE `companies` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `employees_range` varchar(50) DEFAULT NULL,
  `capital` decimal(15,2) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `companies`
--

INSERT INTO `companies` (`id`, `user_id`, `company_name`, `description`, `website`, `category`, `country`, `employees_range`, `capital`, `logo`) VALUES
(2, 4, 'Munamaster', 'Notre passion est de vous aider à réaliser vos ambitions à travers l\'investissement et l\'entrepreneuriat, où que vous soyez. N\'hésitez pas à laisser vos commentaires sous les vidéos, poser des questions et surtout, partager votre expertise et votre expérience avec notre communauté.\r\n\r\nSouvenez-vous, seul, on va vite. Mais ensemble, on va loin.\r\n\r\nRejoignez-nous et ensemble, contribuons au développement de l\'entrepreneuriat en Afrique !', 'www.investiraupay.com', 'Finance', 'Cameroon', '11-50', 10000000.00, 'uploads/logos/logo_6878d4c62b9a48.17009691.png'),
(3, 6, 'angelec', 'African tech companies try to find capital in a competitive market where international investors are looking to back the next Andela or Jumia.\r\nFor African startups, 2018 was a record-breaking year. More startups — a total of 210 recorded — raised 32 percent more funding than ever before, securing', 'www.angelec.com', 'Finance', 'Cameroon', '11-50', 10000.00, 'uploads/logos/logo_687911655470c4.77202872.webp'),
(4, 7, 'preact', 'African tech companies try to find capital in a competitive market where international investors are looking to back the next Andela or Jumia.\r\nFor African startups, 2018 was a record-breaking year. More startups — a total of 210 recorded — raised 32 percent more funding than ever before, securing', 'www.preact.com', 'Retail', 'Cameroon', '11-50', 10000.00, 'uploads/logos/logo_687911e4a651c7.97559979.jpg'),
(5, 8, 'couturium', 'African tech companies try to find capital in a competitive market where international investors are looking to back the next Andela or Jumia.\r\nFor African startups, 2018 was a record-breaking year. More startups — a total of 210 recorded — raised 32 percent more funding than ever before, securing', 'www.couturium.com', 'Manufacturing', 'Burkina Faso', '11-50', 1000000.00, 'uploads/logos/logo_68791277b6a839.81041898.jpeg'),
(6, 9, 'couturium', 'African tech companies try to find capital in a competitive market where international investors are looking to back the next Andela or Jumia.\r\nFor African startups, 2018 was a record-breaking year. More startups — a total of 210 recorded — raised 32 percent more funding than ever before, securing', 'www.eduka.com', 'Education', 'Ivory Coast', '11-50', 1000000.00, 'uploads/logos/logo_687912e2b8df17.80202839.jpeg'),
(7, 10, 'afrecabuilding', 'African techcompanies try to find capital in a competitive market where international investors are looking to back the next Andela or Jumia.\r\nFor African startups, 2018 was a record-breaking year. More startups — a total of 210 recorded — raised 32 percent more funding than ever before, securing', 'www.afrecabuilding.com', 'Other', 'Ivory Coast', '11-50', 1000000.00, 'uploads/logos/logo_6879136df11bc4.48449584.jpeg'),
(8, 11, 'wave', 'Notre passion est de vous aider à réaliser vos ambitions à travers l\'investissement et l\'entrepreneuriat, où que vous soyez. N\'hésitez pas à laisser vos commentaires sous les vidéos, poser des questions et surtout, partager votre expertise et votre expérience avec notre communauté.\r\n\r\nSouvenez-vous, seul, on va vite. Mais ensemble, on va loin.\r\n\r\nRejoignez-nous et ensemble, contribuons au développement de l\'entrepreneuriat en Afrique !', 'www.wave.cm', 'Manufacturing', 'Egypt', '201-500', 100000000.00, 'uploads/logos/logo_68791aa7350d85.12824316.jpg'),
(9, 12, 'nana wax', 'Notre passion est de vous aider à réaliser vos ambitions à travers l\'investissement et l\'entrepreneuriat, où que vous soyez. N\'hésitez pas à laisser vos commentaires sous les vidéos, poser des questions et surtout, partager votre expertise et votre expérience avec notre communauté.\r\n\r\nSouvenez-vous, seul, on va vite. Mais ensemble, on va loin.\r\n\r\nRejoignez-nous et ensemble, contribuons au développement de l\'entrepreneuriat en Afrique !', 'www.nanawax.cm', 'Manufacturing', 'Benin', '11-50', 100000000.00, 'uploads/logos/logo_68791b3b6d19d8.43828894.jpg'),
(10, 13, 'tomata', 'Notre passion est de vous aider à réaliser vos ambitions à travers l\'investissement et l\'entrepreneuriat, où que vous soyez. N\'hésitez pas à laisser vos commentaires sous les vidéos, poser des questions et surtout, partager votre expertise et votre expérience avec notre communauté.\r\n\r\nSouvenez-vous, seul, on va vite. Mais ensemble, on va loin.\r\n\r\nRejoignez-nous et ensemble, contribuons au développement de l\'entrepreneuriat en Afrique !', 'www.tomata.cm', 'Other', 'Equatorial Guinea', '11-50', 100000000.00, 'uploads/logos/logo_68791b9559c282.48414373.jpg'),
(11, 14, 'costein', 'Notre passion est de vous aider à réaliser vos ambitions à travers l\'investissement et l\'entrepreneuriat, où que vous soyez. N\'hésitez pas à laisser vos commentaires sous les vidéos, poser des questions et surtout, partager votre expertise et votre expérience avec notre communauté.\r\n\r\nSouvenez-vous, seul, on va vite. Mais ensemble, on va loin.\r\n\r\nRejoignez-nous et ensemble, contribuons au développement de l\'entrepreneuriat en Afrique !', 'www.costein.cm', 'Other', 'Cameroon', '201-500', 100000000.00, 'uploads/logos/logo_68791c44699fa7.61810073.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `sent_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `investments`
--

CREATE TABLE `investments` (
  `id` int(11) NOT NULL,
  `investor_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `invested_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `investors`
--

CREATE TABLE `investors` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `investors`
--

INSERT INTO `investors` (`id`, `user_id`, `phone`, `address`) VALUES
(1, 2, '+237682181942', 'Yaounde');

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `sent_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `messages`
--

INSERT INTO `messages` (`id`, `name`, `email`, `subject`, `message`, `sent_at`) VALUES
(1, 'Teoi Youssoufa', 'www.youssoufateoi@gmail.com', 'pmad sarl', 'hello', '2025-07-18 14:33:07'),
(2, 'Teoi Youssoufa', 'www.youssoufateoi@gmail.com', 'pmad sarl', 'hello', '2025-07-18 14:33:14'),
(3, 'Teoi Youssoufa', 'www.youssoufateoi@gmail.com', 'pmad sarl', 'hello', '2025-07-18 14:33:17'),
(4, 'Teoi Youssoufa', 'www.youssoufateoi@gmail.com', 'couturium', 'hello', '2025-07-18 14:33:25'),
(5, 'Teoi Youssoufa', 'www.youssoufateoi@gmail.com', 'angelec', 'hello', '2025-07-18 14:45:33');

-- --------------------------------------------------------

--
-- Structure de la table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `amount_needed` decimal(15,2) NOT NULL,
  `amount_raised` decimal(15,2) DEFAULT 0.00,
  `status` enum('open','closed','funded') DEFAULT 'open',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('investor','company','user') NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `status` enum('active','inactive') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `password`, `role`, `created_at`, `status`) VALUES
(1, 'Wave', 'root@root.com', '$2y$10$8wlM.dTdXsosa0100gYEJOpN8helfce5R5YBFWTos8HLZr2gWKBfW', 'user', '2025-07-18 15:32:37', 'active'),
(2, 'pmad', 'pmad@gmail.com', '$2y$10$H/bLnRvt1qrk7rpo9pcjAeVibN2nyyyRzA0RlvHOh7DCrTGDQ6ycO', 'user', '2025-07-18 15:33:07', 'active'),
(3, 'admin', 'admin@admin.com', '$2y$10$1khwV0bvkxfBF7936olHa.Y.w17vZqlwLYfQd4JzrTKrDfKaEY6bO', 'user', '2025-07-18 15:34:32', 'active'),
(4, 'ange', 'root@gmail.com', '$2y$10$oXGFWjcLM//dUudFYuHZM.8g/4CJaoHSOjKfX/ZzSPUn/pYN8avbu', 'user', '2025-07-18 15:36:49', 'active');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('investor','company','admin') NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `status` enum('active','inactive') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`, `status`) VALUES
(2, 'Teoi Youssoufa', 'www.youssoufateoi@gmail.com', '$2y$10$oQ2Sr/glb6xbC.PcJqi/H.msGIRJVtZyRDCszGHPNU318ajidbg62', 'investor', '2025-07-17 09:34:12', 'active'),
(3, 'ange', 'ange@gmail.com', '$2y$10$08Br.qQvfYNrFZd9ZPuGfOxSzpIU9CIfniAR8//KFlii7rv7/.0Fu', 'admin', '2025-07-17 11:41:45', 'active'),
(4, 'Youssoufa', 'munamaster@gmail.com', '$2y$10$.dduSfjWVzPENYVLz3ajG.uHlmHDyBrf6fj2Qbs7kcNjjWLqrY5.C', 'company', '2025-07-17 11:47:34', 'active'),
(6, 'Angelec', 'angelec@gmail.com', '$2y$10$vxwzw54025cRe5O1VazXhelCgO1Oe7/aycUbHNH/0g3zC6v.QzhKq', 'company', '2025-07-17 16:06:13', 'active'),
(7, 'preact', 'preac@gmail.com', '$2y$10$Y0D9KrCyP.azXozcjVxjkOhSHMJKnEy3.bHWq1kU/NH11DVLedo8q', 'company', '2025-07-17 16:08:20', 'active'),
(8, 'couturium', 'couturium@gmail.com', '$2y$10$Te1GUNRtVU9zBBUkCi.ZyOcIaY9JZVzRtBEQxqEicRaLWU9ze.3gW', 'company', '2025-07-17 16:10:47', 'active'),
(9, 'eduka', 'eduka@gmail.com', '$2y$10$Q/Aca3G98mc2YhmM6Lbc4e8CHZYtjWvs3hMQed9brdEVNqYpiAglu', 'company', '2025-07-17 16:12:34', 'active'),
(10, 'afrecanbuilding', 'afrecabuilding@gmail.com', '$2y$10$uZH/Lz7PzurH.Qp2Nlkn4OE6iVSvmLn111bqr9KfJvxROuyoUpFjW', 'company', '2025-07-17 16:14:54', 'active'),
(11, 'Wave', 'wave@gmail.xn--cp-pka', '$2y$10$a2yj8MnYdrAAA00nGwbXNuxOUEIVFRemwm/hcin76wIqfE/TXROuy', 'company', '2025-07-17 16:45:43', 'active'),
(12, 'nanawax', 'nanawax@gmail.cm', '$2y$10$AlcFfoFOTvJqbJvLjEwuI.UzOuIWgQmiAF1o76r4WF1lS/Jo8kfw2', 'company', '2025-07-17 16:48:11', 'active'),
(13, 'tomata', 'tomata@gmail.cm', '$2y$10$v5/fF.zxxcE.2Egc5jk3S.Ohz9B5RCn4F/7bfFS86yu7pnZwwopQK', 'company', '2025-07-17 16:49:41', 'active'),
(14, 'costein', 'costein@gmail.cm', '$2y$10$p2WPX3IjL3aeGBtWe7tTMOxbDPhiu.7uyCw1jOrl/uwn2B8uH7m9u', 'company', '2025-07-17 16:52:36', 'active'),
(15, 'youssouf', 'youssouf@gmail.com', '$2y$10$UhqKj1fI61/0Nt2Eia7vnug7BFz2yIFe5mKbCoTFQW85wWLr67Ldy', '', '2025-07-21 08:51:24', 'active'),
(17, 'Admin Name', 'admin@pmad.com', '$2y$10$8NXD5O/3qsYTDVJ6VLwQOe3wStpqdxivCr6PRB8UgXL0XNe38n8Ta', 'admin', '2025-07-21 09:29:05', 'active');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`id`),
  ADD KEY `author_id` (`author_id`);

--
-- Index pour la table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `investments`
--
ALTER TABLE `investments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `investor_id` (`investor_id`),
  ADD KEY `project_id` (`project_id`);

--
-- Index pour la table `investors`
--
ALTER TABLE `investors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_id` (`company_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `blog`
--
ALTER TABLE `blog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `investments`
--
ALTER TABLE `investments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `investors`
--
ALTER TABLE `investors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `blog`
--
ALTER TABLE `blog`
  ADD CONSTRAINT `blog_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `companies`
--
ALTER TABLE `companies`
  ADD CONSTRAINT `companies_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `investments`
--
ALTER TABLE `investments`
  ADD CONSTRAINT `investments_ibfk_1` FOREIGN KEY (`investor_id`) REFERENCES `investors` (`id`),
  ADD CONSTRAINT `investments_ibfk_2` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`);

--
-- Contraintes pour la table `investors`
--
ALTER TABLE `investors`
  ADD CONSTRAINT `investors_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `projects_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
