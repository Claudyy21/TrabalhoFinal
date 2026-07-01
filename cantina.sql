-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 01/07/2026 às 03:02
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
-- Banco de dados: `cantina`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `estoques`
--

CREATE TABLE `estoques` (
  `id` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL DEFAULT 0,
  `tipo` varchar(10) NOT NULL COMMENT 'entrada ou saida',
  `fornecedor` varchar(255) DEFAULT NULL,
  `observacao` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `estoques`
--

INSERT INTO `estoques` (`id`, `id_produto`, `quantidade`, `tipo`, `fornecedor`, `observacao`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 15, 'entrada', 'Claudy', 'En', '2026-06-24 00:44:00', '2026-06-24 00:44:00', NULL),
(2, 1, 3, 'saida', NULL, 'Errei a quantidade', '2026-06-24 00:44:16', '2026-06-24 00:44:16', NULL),
(3, 6, 10, 'entrada', 'Lucas', '', '2026-06-30 23:16:39', '2026-06-30 23:16:39', NULL),
(9, 8, 10, 'entrada', '', '', '2026-06-30 23:26:30', '2026-06-30 23:26:30', NULL),
(10, 8, 1, 'saida', NULL, '', '2026-06-30 23:26:40', '2026-06-30 23:26:40', NULL),
(11, 3, 2, 'entrada', '', '', '2026-07-01 00:10:17', '2026-07-01 00:10:17', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2026-05-19-224834', 'App\\Database\\Migrations\\TabelaEstoque', 'default', 'App', 1779231822, 1),
(2, '2026-05-19-231121', 'App\\Database\\Migrations\\AddTipoTabelaEstoque', 'default', 'App', 1779232584, 2),
(3, '2026-06-02-221614', 'App\\Database\\Migrations\\TabelaPedidos', 'default', 'App', 1780439647, 3),
(4, '2026-06-02-221641', 'App\\Database\\Migrations\\TabelaPedidosProduto', 'default', 'App', 1780439647, 3),
(5, '2026-07-01-000000', 'App\\Database\\Migrations\\AddTotemFieldsToPedidos', 'default', 'App', 1782867404, 4);

-- --------------------------------------------------------

--
-- Estrutura para tabela `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'novo',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `totem_id` varchar(100) DEFAULT NULL,
  `totem_name` varchar(100) DEFAULT NULL,
  `totem_ip` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `pedidos`
--

INSERT INTO `pedidos` (`id`, `status`, `created_at`, `updated_at`, `deleted_at`, `totem_id`, `totem_name`, `totem_ip`) VALUES
(1, 'finalizado', '2026-06-23 23:46:58', '2026-06-24 00:03:46', NULL, NULL, NULL, NULL),
(2, 'cancelado', '2026-06-23 23:47:59', '2026-06-24 00:03:51', NULL, NULL, NULL, NULL),
(3, 'finalizado', '2026-06-30 22:44:22', '2026-06-30 23:30:25', NULL, NULL, NULL, NULL),
(4, 'novo', '2026-06-30 22:44:49', '2026-06-30 22:44:49', NULL, NULL, NULL, NULL),
(5, 'novo', '2026-06-30 22:44:58', '2026-06-30 22:44:58', NULL, NULL, NULL, NULL),
(6, 'novo', '2026-06-30 23:00:16', '2026-06-30 23:00:16', NULL, NULL, NULL, NULL),
(7, 'finalizado', '2026-06-30 23:29:51', '2026-06-30 23:30:29', NULL, NULL, NULL, NULL),
(8, 'finalizado', '2026-07-01 00:01:29', '2026-07-01 00:02:34', NULL, NULL, NULL, NULL),
(9, 'novo', '2026-07-01 00:15:35', '2026-07-01 00:15:35', NULL, NULL, NULL, NULL),
(10, 'novo', '2026-07-01 00:25:30', '2026-07-01 00:25:30', NULL, NULL, NULL, NULL),
(11, 'novo', '2026-07-01 00:31:20', '2026-07-01 00:31:20', NULL, NULL, NULL, NULL),
(12, 'novo', '2026-07-01 00:33:10', '2026-07-01 00:33:10', NULL, NULL, NULL, NULL),
(13, 'novo', '2026-07-01 00:33:33', '2026-07-01 00:33:33', NULL, NULL, NULL, NULL),
(14, 'novo', '2026-07-01 00:43:23', '2026-07-01 00:43:23', NULL, NULL, NULL, NULL),
(15, 'novo', '2026-07-01 00:45:51', '2026-07-01 00:45:51', NULL, NULL, NULL, NULL),
(16, 'novo', '2026-07-01 00:47:14', '2026-07-01 00:47:14', NULL, NULL, NULL, NULL),
(17, 'novo', '2026-07-01 00:50:57', '2026-07-01 00:50:57', NULL, NULL, NULL, NULL),
(18, 'novo', '2026-07-01 00:57:12', '2026-07-01 00:57:12', NULL, 'totem 01', 'totem 01', 'local');

-- --------------------------------------------------------

--
-- Estrutura para tabela `pedido_produtos`
--

CREATE TABLE `pedido_produtos` (
  `id` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL DEFAULT 1,
  `preco_unitario` decimal(8,2) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `pedido_produtos`
--

INSERT INTO `pedido_produtos` (`id`, `id_pedido`, `id_produto`, `quantidade`, `preco_unitario`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 2, 3, 80.00, '2026-06-23 23:46:58', '2026-06-23 23:46:58', NULL),
(2, 2, 4, 1, 8.00, '2026-06-23 23:47:59', '2026-06-23 23:47:59', NULL),
(3, 3, 2, 2, 80.00, '2026-06-30 22:44:22', '2026-06-30 22:44:22', NULL),
(4, 4, 3, 4, 35.00, '2026-06-30 22:44:49', '2026-06-30 22:44:49', NULL),
(5, 4, 5, 2, 10.00, '2026-06-30 22:44:49', '2026-06-30 22:44:49', NULL),
(6, 4, 4, 1, 8.00, '2026-06-30 22:44:49', '2026-06-30 22:44:49', NULL),
(7, 5, 3, 1, 35.00, '2026-06-30 22:44:58', '2026-06-30 22:44:58', NULL),
(8, 6, 2, 2, 80.00, '2026-06-30 23:00:16', '2026-06-30 23:00:16', NULL),
(9, 7, 4, 2, 8.00, '2026-06-30 23:29:51', '2026-06-30 23:29:51', NULL),
(10, 7, 8, 1, 5.00, '2026-06-30 23:29:51', '2026-06-30 23:29:51', NULL),
(11, 8, 3, 4, 35.00, '2026-07-01 00:01:29', '2026-07-01 00:01:29', NULL),
(12, 9, 3, 1, 35.00, '2026-07-01 00:15:35', '2026-07-01 00:15:35', NULL),
(13, 10, 2, 1, 80.00, '2026-07-01 00:25:30', '2026-07-01 00:25:30', NULL),
(14, 11, 1, 1, 8.00, '2026-07-01 00:31:20', '2026-07-01 00:31:20', NULL),
(15, 12, 4, 1, 8.00, '2026-07-01 00:33:10', '2026-07-01 00:33:10', NULL),
(16, 13, 6, 1, 10.00, '2026-07-01 00:33:33', '2026-07-01 00:33:33', NULL),
(17, 14, 4, 1, 8.00, '2026-07-01 00:43:23', '2026-07-01 00:43:23', NULL),
(18, 15, 5, 2, 10.00, '2026-07-01 00:45:51', '2026-07-01 00:45:51', NULL),
(19, 16, 8, 1, 5.00, '2026-07-01 00:47:14', '2026-07-01 00:47:14', NULL),
(20, 17, 6, 1, 10.00, '2026-07-01 00:50:57', '2026-07-01 00:50:57', NULL),
(21, 18, 5, 1, 10.00, '2026-07-01 00:57:12', '2026-07-01 00:57:12', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

CREATE TABLE `produtos` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `preco` decimal(8,2) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `categoria` varchar(100) DEFAULT NULL,
  `estoque` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `produtos`
--

INSERT INTO `produtos` (`id`, `nome`, `preco`, `created_at`, `updated_at`, `foto`, `categoria`, `estoque`) VALUES
(1, 'Enroladinho de salsicha', 8.00, '2026-05-12 23:46:12', '2026-07-01 00:31:20', '1782861019_f5b6441bd7f560c5abf4.png', 'Lanche', 11),
(2, 'Pizza 30cm', 80.00, '2026-05-12 23:48:51', '2026-07-01 00:25:30', '1782860921_fad53960ad2a0f5db2e5.jpg', 'Lanche', 13),
(3, 'Hambúrguer', 35.00, '2026-05-12 23:49:41', '2026-07-01 00:15:35', '1782860898_b4e8b516d0d159c7c201.jpg', 'Lanche', 1),
(4, 'Coca-Cola', 8.00, '2026-05-12 23:51:47', '2026-07-01 00:43:23', '1782861029_8c25691b007b5d2cdb4c.png', 'Bebida', 18),
(5, 'Crepe', 10.00, '2026-05-13 02:04:38', '2026-07-01 00:57:12', '1782860888_91d8060e318504f78ebd.jpg', 'Lanche', 8),
(6, 'Miojo', 10.00, '2026-06-30 23:05:45', '2026-07-01 00:50:57', '1782860745_2fde33f1fdfe260954cb.jpg', 'Lanche', 8),
(8, 'Água', 5.00, '2026-06-30 23:26:00', '2026-07-01 00:47:14', '1782861960_d4e205a611ac6ae47230.jpg', 'Bebida', 8);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha_hash` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `tipo` varchar(100) DEFAULT 'usuario',
  `bloqueado` tinyint(1) NOT NULL DEFAULT 0,
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_token_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `email`, `senha_hash`, `created_at`, `updated_at`, `tipo`, `bloqueado`, `reset_token`, `reset_token_date`) VALUES
(1, 'teste@gmail.com', '$2y$10$1tASgrR45wSij5rJGyhBduKAVTuEh2GRmAYE9I1r1.JNlCs6u5sGy', '2026-05-12 23:23:00', '2026-06-30 22:55:18', 'usuario', 0, NULL, NULL),
(10, 'admin@gmail.com', '$2y$10$KAd6oLGhF2.b0lXTT57mreuaA36C9SoaRRbt/Uu/Ee3r9XzhZmK8G', '2026-06-24 00:23:58', '2026-06-24 00:32:26', 'admin', 0, NULL, NULL),
(11, 'bloqueado@gmail.com', '$2y$10$P21Ym1LdkC9c24ritWKurO4iYcebgaerWi9MjuMkg/vnNJCPM.uF6', '2026-06-24 00:31:42', '2026-06-24 00:31:52', 'admin', 1, NULL, NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `estoques`
--
ALTER TABLE `estoques`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_produto` (`id_produto`);

--
-- Índices de tabela `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `pedido_produtos`
--
ALTER TABLE `pedido_produtos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pedido` (`id_pedido`),
  ADD KEY `id_produto` (`id_produto`);

--
-- Índices de tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `estoques`
--
ALTER TABLE `estoques`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de tabela `pedido_produtos`
--
ALTER TABLE `pedido_produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `estoques`
--
ALTER TABLE `estoques`
  ADD CONSTRAINT `estoques_ibfk_1` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`id`);

--
-- Restrições para tabelas `pedido_produtos`
--
ALTER TABLE `pedido_produtos`
  ADD CONSTRAINT `pedido_produtos_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id`),
  ADD CONSTRAINT `pedido_produtos_ibfk_2` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
