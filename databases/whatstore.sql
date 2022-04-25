-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 29/11/2021 às 18:22
-- Versão do servidor: 10.4.18-MariaDB
-- Versão do PHP: 8.0.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `whatstore`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `customers`
--

CREATE TABLE `customers` (
  `IDN` int(11) NOT NULL,
  `name` varchar(80) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura para tabela `discounts`
--

CREATE TABLE `discounts` (
  `code` int(11) NOT NULL,
  `name` varchar(80) NOT NULL,
  `operator` char(1) NOT NULL,
  `factor` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura para tabela `employees`
--

CREATE TABLE `employees` (
  `ID` int(11) NOT NULL,
  `name` varchar(80) NOT NULL,
  `nickname` varchar(80) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura para tabela `employee_roles`
--

CREATE TABLE `employee_roles` (
  `code` int(11) NOT NULL,
  `code_role` int(11) NOT NULL,
  `ID_employee` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura para tabela `inventory`
--

CREATE TABLE `inventory` (
  `code_product` int(11) NOT NULL,
  `amount` int(11) NOT NULL DEFAULT '0',
  `maximum` int(11) NOT NULL DEFAULT '0',
  `miminum` int(11) NOT NULL DEFAULT '0',
  `reserved` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura para tabela `order_items`
--

CREATE TABLE `order_items` (
  `code_order` int(11) NOT NULL,
  `code_product` int(11) NOT NULL,
  `price` float NOT NULL,
  `amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura para tabela `products`
--

CREATE TABLE `products` (
  `code` int(11) NOT NULL,
  `name` varchar(80) NOT NULL,
  `price` double NOT NULL,
  `code_discount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura para tabela `purchase_orders`
--

CREATE TABLE `purchase_orders` (
  `code` int(11) NOT NULL,
  `date` date NOT NULL,
  `status` smallint(6) NOT NULL,
  `IDN` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura para tabela `resources`
--

CREATE TABLE `resources` (
  `code` int(11) NOT NULL,
  `name` varchar(80) NOT NULL,
  `method` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura para tabela `resources_role`
--

CREATE TABLE `resources_role` (
  `code` int(11) NOT NULL,
  `code_role` int(11) NOT NULL,
  `code_resource` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura para tabela `roles`
--

CREATE TABLE `roles` (
  `code` int(11) NOT NULL,
  `name` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura para tabela `transactions`
--

CREATE TABLE `transactions` (
  `code` int(11) NOT NULL,
  `code_product` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `date` date NOT NULL,
  `type` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`IDN`);

--
-- Índices de tabela `discounts`
--
ALTER TABLE `discounts`
  ADD PRIMARY KEY (`code`);

--
-- Índices de tabela `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`ID`);

--
-- Índices de tabela `employee_roles`
--
ALTER TABLE `employee_roles`
  ADD PRIMARY KEY (`code`),
  ADD KEY `code_role` (`code_role`),
  ADD KEY `ID_employee` (`ID_employee`);

--
-- Índices de tabela `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`code_product`);

--
-- Índices de tabela `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`code_order`,`code_product`),
  ADD KEY `code_product` (`code_product`);

--
-- Índices de tabela `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`code`),
  ADD KEY `code_discount` (`code_discount`);

--
-- Índices de tabela `purchase_orders`
--
ALTER TABLE `purchase_orders`
  ADD PRIMARY KEY (`code`),
  ADD KEY `IDN` (`IDN`);

--
-- Índices de tabela `resources`
--
ALTER TABLE `resources`
  ADD PRIMARY KEY (`code`);

--
-- Índices de tabela `resources_role`
--
ALTER TABLE `resources_role`
  ADD PRIMARY KEY (`code`),
  ADD KEY `code_role` (`code_role`),
  ADD KEY `code_resource` (`code_resource`);

--
-- Índices de tabela `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`code`);

--
-- Índices de tabela `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`code`),
  ADD KEY `code_product` (`code_product`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `discounts`
--
ALTER TABLE `discounts`
  MODIFY `code` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `employees`
--
ALTER TABLE `employees`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `employee_roles`
--
ALTER TABLE `employee_roles`
  MODIFY `code` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `products`
--
ALTER TABLE `products`
  MODIFY `code` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `purchase_orders`
--
ALTER TABLE `purchase_orders`
  MODIFY `code` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `resources`
--
ALTER TABLE `resources`
  MODIFY `code` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `resources_role`
--
ALTER TABLE `resources_role`
  MODIFY `code` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `roles`
--
ALTER TABLE `roles`
  MODIFY `code` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `transactions`
--
ALTER TABLE `transactions`
  MODIFY `code` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `discounts`
--
ALTER TABLE `discounts`
  ADD CONSTRAINT `discounts_ibfk_1` FOREIGN KEY (`code`) REFERENCES `products` (`code_discount`);

--
-- Restrições para tabelas `employee_roles`
--
ALTER TABLE `employee_roles`
  ADD CONSTRAINT `employee_roles_ibfk_2` FOREIGN KEY (`code_role`) REFERENCES `roles` (`code`),
  ADD CONSTRAINT `employee_roles_ibfk_3` FOREIGN KEY (`ID_employee`) REFERENCES `employees` (`ID`);

--
-- Restrições para tabelas `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_ibfk_1` FOREIGN KEY (`code_product`) REFERENCES `products` (`code`);

--
-- Restrições para tabelas `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`code_product`) REFERENCES `products` (`code`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`code_order`) REFERENCES `purchase_orders` (`code`);

--
-- Restrições para tabelas `purchase_orders`
--
ALTER TABLE `purchase_orders`
  ADD CONSTRAINT `purchase_orders_ibfk_1` FOREIGN KEY (`IDN`) REFERENCES `customers` (`IDN`);

--
-- Restrições para tabelas `resources_role`
--
ALTER TABLE `resources_role`
  ADD CONSTRAINT `resources_role_ibfk_1` FOREIGN KEY (`code_role`) REFERENCES `roles` (`code`),
  ADD CONSTRAINT `resources_role_ibfk_2` FOREIGN KEY (`code_resource`) REFERENCES `resources` (`code`);

--
-- Restrições para tabelas `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`code_product`) REFERENCES `products` (`code`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
