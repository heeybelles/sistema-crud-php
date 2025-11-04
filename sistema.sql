-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 04/11/2025 às 06:13
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `sistema`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `avaliacao`
--

CREATE TABLE `avaliacao` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `estrelas` int(11) NOT NULL,
  `comentario` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `avaliacao`
--

INSERT INTO `avaliacao` (`id`, `nome`, `estrelas`, `comentario`) VALUES
(3, 'Gabi2', 3, 'mais ou menos'),
(11, 'Ana', 5, 'Perfeitooo'),
(11, 'Ana', 4, 'Ameii');

-- --------------------------------------------------------

--
-- Estrutura para tabela `compras`
--

CREATE TABLE `compras` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_servico` int(11) NOT NULL,
  `data_compra` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `compras`
--

INSERT INTO `compras` (`id`, `id_usuario`, `id_servico`, `data_compra`) VALUES
(1, 11, 6, '2025-11-04 01:25:14'),
(2, 11, 6, '2025-11-04 01:30:48'),
(3, 11, 6, '2025-11-04 01:43:52'),
(4, 11, 5, '2025-11-04 01:44:29'),
(5, 13, 5, '2025-11-04 02:05:38');

-- --------------------------------------------------------

--
-- Estrutura para tabela `contato`
--

CREATE TABLE `contato` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mensagem` text NOT NULL,
  `data_envio` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `contato`
--

INSERT INTO `contato` (`id`, `nome`, `email`, `mensagem`, `data_envio`) VALUES
(1, 'Ana', 'ana@gmail.com', 'Seu trabalho é incrível!', '2025-11-04 03:45:07'),
(3, 'katia', 'katia@gmail.com', 'incrivel', '2025-11-04 05:06:42');

-- --------------------------------------------------------

--
-- Estrutura para tabela `servico`
--

CREATE TABLE `servico` (
  `id` int(11) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `descricao` text NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `preco` double(6,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `servico`
--

INSERT INTO `servico` (`id`, `titulo`, `descricao`, `foto`, `preco`) VALUES
(2, 'Perfume Lindoo', 'Muito perfumadooo', 'images/product/produto_6907c8630ffb21.97081360.webp', 40.00),
(5, 'Boss', 'Marcante', 'images/product/produto_690975ce671d27.10812113.png', 50.00),
(6, 'Irresistible', 'Irresistivél', 'images/product/produto_6909760282e837.06445743.jpg', 60.00),
(7, 'Perfume Lindoo', 'bom', 'images/product/produto_69098a4aa2f139.42170871.jpg', 300.00);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `nivel` enum('admin','usuario') NOT NULL DEFAULT 'usuario'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`id`, `nome`, `email`, `senha`, `foto`, `nivel`) VALUES
(3, 'Gabi2', 'gabi@gmai.com', '$2y$10$2qgxYmZCDWBKyj.lnPeEyeWx6FGxRmvm8j.NOGLHBfQ00j/q8n3SC', 'images/users/6907d20d60d14.PNG', 'usuario'),
(7, 'Carol', 'carol@gmail.com', '$2y$10$SgCajdTueKrx/5OdO7Qr8OH6/DQ9aow9Y9K.pPk8kEscpNHw/Cbna', 'https://cdn.pixabay.com/photo/2020/07/01/12/58/icon-5359554_1280.png', 'admin'),
(9, 'Dudaa', 'du@gmail.com', '$2y$10$jHUWI5GXAj/kmjhIOiPYde93sYSdc0Gzne3YlrxqyzlUSR0WyTaJO', 'images/users/user_6907beb0c3fcb4.93981450.PNG', 'usuario'),
(11, 'Ana', 'ana@gmail.com', '$2y$10$6iHMVEh1gN87LnhECQq85.wE1T.h9ZxgeUSL1wOL8KufURRHhztz6', NULL, 'usuario'),
(13, 'katia', 'katia@gmail.com', '$2y$10$pbhi3OJ/EBMkmjIVG2DI0.GV4.6cyiUIfXEF4HTQ7V.vS2yBzRl72', 'images/users/user_690989663e2a90.38383010.jpg', 'usuario');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_servico` (`id_servico`);

--
-- Índices de tabela `contato`
--
ALTER TABLE `contato`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `servico`
--
ALTER TABLE `servico`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `compras`
--
ALTER TABLE `compras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `contato`
--
ALTER TABLE `contato`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `servico`
--
ALTER TABLE `servico`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `compras`
--
ALTER TABLE `compras`
  ADD CONSTRAINT `compras_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `compras_ibfk_2` FOREIGN KEY (`id_servico`) REFERENCES `servico` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
