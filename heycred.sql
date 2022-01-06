-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 06-Jan-2022 às 04:22
-- Versão do servidor: 8.0.27-0ubuntu0.20.04.1
-- versão do PHP: 8.0.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `heycred`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(70) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `token` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `credit` int NOT NULL,
  `session` datetime NOT NULL,
  `type` enum('admin','user') COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `name`, `email`, `password`, `token`, `credit`, `session`, `type`) VALUES
(4, 'Administrador', 'admin@admin.com', '$2y$10$c0P7pWKPg24X.Pt2NPnpGu7l6xkeh96mzm6OC69qmapmuzx6PPE0i', 'ca1d111b86c12ad6c260e982a16bf30c', 10000, '2022-01-06 04:06:03', 'admin'),
(5, 'Marcos Paulo', 'mark.paul@gmail.com', '$2y$10$xbzgY0iyqs2KqmvWVtgKH.AS1Yw2X.iZK.Ti4qt43a6sFIrNrUK7K', '635d35483d66b14374807421ae2995c6', 51313, '2022-01-06 03:47:19', 'user'),
(6, 'Raimundo Ferreira', 'raferreira@gmail.com', '$2y$10$Nbw8arghfBT11LM7uq2koeqOWRfJfzbSZGhcKwS0wGFwB8chEPOba', '6d865a097cccee9cc0d1506b8ac09381', 2901, '2022-01-06 03:47:48', 'user'),
(7, 'Gustavo lima', 'gustavolima@gmail.com', '$2y$10$i27sCdNpCbC2CJfty/vtn.W5XMeqTEkk/zMYiESvv7Jd4YPd2X83C', 'b5650d7761d2aea2a3e89d0c7781a54b', 9616, '2022-01-06 03:48:43', 'user');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
