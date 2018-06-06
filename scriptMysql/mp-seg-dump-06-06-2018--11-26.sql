-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 06, 2018 at 04:25 PM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.0.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mp-seg`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_cliente`
--

CREATE TABLE `tb_cliente` (
  `cli_id` int(11) NOT NULL,
  `cli_nome` varchar(80) NOT NULL,
  `cli_cpf_cnpj` varchar(18) DEFAULT NULL,
  `cli_rg_ie` varchar(20) DEFAULT NULL,
  `cli_tel_ddd` varchar(2) DEFAULT NULL,
  `cli_tel_numero` varchar(14) DEFAULT NULL,
  `cli_cel_ddd` varchar(2) DEFAULT NULL,
  `cli_cel_numero` varchar(14) DEFAULT NULL,
  `cli_end_cep` varchar(10) DEFAULT NULL,
  `cli_end_tp_lgr` varchar(10) DEFAULT NULL,
  `cli_end_logradouro` varchar(80) DEFAULT NULL,
  `cli_end_numero` varchar(15) DEFAULT NULL,
  `cli_end_bairro` varchar(80) DEFAULT NULL,
  `cli_end_cidade` varchar(80) DEFAULT NULL,
  `cli_end_estado` varchar(2) DEFAULT NULL,
  `cli_observacao` text,
  `cli_ativo` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_cliente`
--

INSERT INTO `tb_cliente` (`cli_id`, `cli_nome`, `cli_cpf_cnpj`, `cli_rg_ie`, `cli_tel_ddd`, `cli_tel_numero`, `cli_cel_ddd`, `cli_cel_numero`, `cli_end_cep`, `cli_end_tp_lgr`, `cli_end_logradouro`, `cli_end_numero`, `cli_end_bairro`, `cli_end_cidade`, `cli_end_estado`, `cli_observacao`, `cli_ativo`) VALUES
(1, 'Leandro Parra', '339.118.538-40', '26527089-3', '19', '3468-3244', '19', '98132-4148', '13.477-708', 'Rua', 'Progresso', '317', 'Jdm Boer', 'Americana', 'SP', 'Teste', 1),
(2, 'Carla Parra', '349.641.258-58', '987654321', '99', '8888-8888', '77', '6666-6666', '13450-712', 'Rua', 'José Prando', '135', 'Dona Margarida', 'Santa Bárbara D\'Oeste', 'SP', 'Bloco B, Ap11', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tb_cont_pagar`
--

CREATE TABLE `tb_cont_pagar` (
  `ctp_id` int(11) NOT NULL,
  `ctp_dtvencimento` date NOT NULL,
  `ctp_valor` double NOT NULL,
  `ctp_dtpagamento` date DEFAULT NULL,
  `ctp_valor_pago` double DEFAULT NULL,
  `ctp_fornecedor` varchar(80) DEFAULT NULL,
  `ctp_obs` text,
  `ctp_deletado` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_cont_pagar`
--

INSERT INTO `tb_cont_pagar` (`ctp_id`, `ctp_dtvencimento`, `ctp_valor`, `ctp_dtpagamento`, `ctp_valor_pago`, `ctp_fornecedor`, `ctp_obs`, `ctp_deletado`) VALUES
(1, '2018-05-17', 87.99, '2018-05-18', 88, 'Teste', '', 1),
(3, '2018-05-17', 1.7, '2018-05-18', 1.8, '', 'Observação', 1),
(4, '2018-05-09', 0.8, '2018-05-10', 0.9, 'Fornecedor', '', 1),
(5, '2018-05-02', 49.99, NULL, NULL, 'CPFL', '', 1),
(6, '2018-06-30', 150, NULL, NULL, 'Carros', '', 1),
(7, '2018-06-05', 12, NULL, NULL, 'Oxyconn', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tb_cont_receber`
--

CREATE TABLE `tb_cont_receber` (
  `ctr_id` int(11) NOT NULL,
  `ctr_cli_id` int(11) DEFAULT NULL,
  `ctr_dtvencimento` date NOT NULL,
  `ctr_valor` double NOT NULL,
  `ctr_dtpagamento` date DEFAULT NULL,
  `ctr_valor_pago` double DEFAULT NULL,
  `ctr_obs` text,
  `ctr_deletado` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_cont_receber`
--

INSERT INTO `tb_cont_receber` (`ctr_id`, `ctr_cli_id`, `ctr_dtvencimento`, `ctr_valor`, `ctr_dtpagamento`, `ctr_valor_pago`, `ctr_obs`, `ctr_deletado`) VALUES
(18, 1, '2018-06-01', 1.99, '2018-06-01', 2, 'Teste de observação', 1),
(19, 1, '2018-06-20', 500, NULL, NULL, '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tb_estado`
--

CREATE TABLE `tb_estado` (
  `est_id` int(11) NOT NULL,
  `est_sigla` varchar(2) NOT NULL,
  `est_descricao` varchar(40) NOT NULL,
  `est_codigo` varchar(2) NOT NULL COMMENT 'Códido IBGE'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_estado`
--

INSERT INTO `tb_estado` (`est_id`, `est_sigla`, `est_descricao`, `est_codigo`) VALUES
(1, 'AC', 'Acre', '12'),
(2, 'AL', 'Alagoas', '27'),
(3, 'AP', 'Amapá', '16'),
(4, 'AM', 'Amazonas', '13'),
(5, 'BA', 'Bahia', '29'),
(6, 'CE', 'Ceará', '23'),
(7, 'DF', 'Distrito Federal', '53'),
(8, 'ES', 'Espírito Santo', '32'),
(9, 'GO', 'Goiás', '52'),
(10, 'MA', 'Maranhão', '21'),
(11, 'MT', 'Mato Grosso', '51'),
(12, 'MS', 'Mato Grosso do Sul', '50'),
(13, 'MG', 'Minas Gerais', '31'),
(14, 'PA', 'Pará', '15'),
(15, 'PB', 'Paraíba', '25'),
(16, 'PR', 'Paraná', '41'),
(17, 'PE', 'Pernambuco', '26'),
(18, 'PI', 'Piauí', '22'),
(19, 'RJ', 'Rio de Janeiro', '33'),
(20, 'RN', 'Rio Grande do Norte', '24'),
(21, 'RS', 'Rio Grande do Sul', '43'),
(22, 'RO', 'Rondônia', '11'),
(23, 'RR', 'Roraima', '14'),
(24, 'SC', 'Santa Catarina', '42'),
(25, 'SP', 'São Paulo', '35'),
(26, 'SE', 'Sergipe', '28'),
(27, 'TO', 'Tocantins', '17');

-- --------------------------------------------------------

--
-- Table structure for table `tb_funcionario`
--

CREATE TABLE `tb_funcionario` (
  `fun_id` int(11) NOT NULL,
  `fun_nome` varchar(80) NOT NULL,
  `fun_cpf_cnpj` varchar(18) DEFAULT NULL,
  `fun_rg_ie` varchar(20) DEFAULT NULL,
  `fun_tel_ddd` varchar(2) DEFAULT NULL,
  `fun_tel_numero` varchar(14) DEFAULT NULL,
  `fun_cel_ddd` varchar(2) DEFAULT NULL,
  `fun_cel_numero` varchar(14) DEFAULT NULL,
  `fun_end_cep` varchar(10) DEFAULT NULL,
  `fun_end_tp_lgr` varchar(10) DEFAULT NULL,
  `fun_end_logradouro` varchar(80) DEFAULT NULL,
  `fun_end_numero` varchar(15) DEFAULT NULL,
  `fun_end_bairro` varchar(80) DEFAULT NULL,
  `fun_end_cidade` varchar(80) DEFAULT NULL,
  `fun_end_estado` varchar(2) DEFAULT NULL,
  `fun_observacao` text,
  `fun_ativo` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_funcionario`
--

INSERT INTO `tb_funcionario` (`fun_id`, `fun_nome`, `fun_cpf_cnpj`, `fun_rg_ie`, `fun_tel_ddd`, `fun_tel_numero`, `fun_cel_ddd`, `fun_cel_numero`, `fun_end_cep`, `fun_end_tp_lgr`, `fun_end_logradouro`, `fun_end_numero`, `fun_end_bairro`, `fun_end_cidade`, `fun_end_estado`, `fun_observacao`, `fun_ativo`) VALUES
(4, 'Leandro Parra', '339.118.538-40', '26527089-3', '19', '3468-3244', '19', '98132-4148', '13.450-712', 'Rua', 'José Prando', '135', 'Dona Margarida', 'Santa Bárbara D\'oeste', 'SP', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tb_menu`
--

CREATE TABLE `tb_menu` (
  `men_id` int(11) NOT NULL,
  `men_descricao` varchar(35) NOT NULL,
  `men_controller` varchar(50) NOT NULL,
  `men_action` varchar(50) NOT NULL,
  `men_vars` varchar(100) DEFAULT NULL,
  `men_id_pai` int(11) DEFAULT NULL,
  `men_ativo` tinyint(1) NOT NULL DEFAULT '1',
  `men_icon` varchar(50) DEFAULT NULL,
  `men_order` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_menu`
--

INSERT INTO `tb_menu` (`men_id`, `men_descricao`, `men_controller`, `men_action`, `men_vars`, `men_id_pai`, `men_ativo`, `men_icon`, `men_order`) VALUES
(1, 'Início', 'Start', 'index', NULL, NULL, 1, '<i class=\"icon icon-home\"></i>', 0),
(3, 'Clientes', 'Cliente', 'index', NULL, NULL, 1, '<i class=\"icon icon-user\"></i>', 1),
(4, 'Funcionários', 'Funcionario', 'index', NULL, NULL, 1, '<i class=\"icon icon-briefcase\"></i>', 1),
(9, 'Recebimentos', 'ContaReceber', 'index', NULL, NULL, 1, '<i class=\"icon icon-money\"></i>', 1),
(11, 'Pagamentos', 'ContaPagar', 'index', NULL, NULL, 1, '<i class=\"icon icon-credit-card\"></i>', 1),
(13, 'Relatórios', 'Relatorio', 'index', NULL, NULL, 1, '<i class=\"icon icon-print\"></i>', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_usuario`
--

CREATE TABLE `tb_usuario` (
  `usu_id` int(10) NOT NULL,
  `usu_login` varchar(40) NOT NULL,
  `usu_senha` varchar(40) NOT NULL,
  `usu_nome` varchar(50) DEFAULT NULL,
  `usu_sobrenome` varchar(50) DEFAULT NULL,
  `usu_email` varchar(100) DEFAULT NULL,
  `usu_ativo` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_usuario`
--

INSERT INTO `tb_usuario` (`usu_id`, `usu_login`, `usu_senha`, `usu_nome`, `usu_sobrenome`, `usu_email`, `usu_ativo`) VALUES
(1, 'admin', '213299609efe85beef603ede5c10a508', 'Admin', NULL, 'nixlovemi@gmail.com', 1),
(2, 'luis', '14d777febb71c53630e9e843bedbd4d8', 'Luis', 'Truculo', NULL, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_cliente`
--
ALTER TABLE `tb_cliente`
  ADD PRIMARY KEY (`cli_id`);

--
-- Indexes for table `tb_cont_pagar`
--
ALTER TABLE `tb_cont_pagar`
  ADD PRIMARY KEY (`ctp_id`);

--
-- Indexes for table `tb_cont_receber`
--
ALTER TABLE `tb_cont_receber`
  ADD PRIMARY KEY (`ctr_id`),
  ADD KEY `fk_ctr_cli_id` (`ctr_cli_id`);

--
-- Indexes for table `tb_estado`
--
ALTER TABLE `tb_estado`
  ADD PRIMARY KEY (`est_id`),
  ADD UNIQUE KEY `uk_est_sigla` (`est_sigla`);

--
-- Indexes for table `tb_funcionario`
--
ALTER TABLE `tb_funcionario`
  ADD PRIMARY KEY (`fun_id`);

--
-- Indexes for table `tb_menu`
--
ALTER TABLE `tb_menu`
  ADD PRIMARY KEY (`men_id`);

--
-- Indexes for table `tb_usuario`
--
ALTER TABLE `tb_usuario`
  ADD PRIMARY KEY (`usu_id`),
  ADD UNIQUE KEY `usu_id` (`usu_id`),
  ADD UNIQUE KEY `uk_usu_login` (`usu_login`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_cliente`
--
ALTER TABLE `tb_cliente`
  MODIFY `cli_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_cont_pagar`
--
ALTER TABLE `tb_cont_pagar`
  MODIFY `ctp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tb_cont_receber`
--
ALTER TABLE `tb_cont_receber`
  MODIFY `ctr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tb_estado`
--
ALTER TABLE `tb_estado`
  MODIFY `est_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `tb_funcionario`
--
ALTER TABLE `tb_funcionario`
  MODIFY `fun_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tb_menu`
--
ALTER TABLE `tb_menu`
  MODIFY `men_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tb_usuario`
--
ALTER TABLE `tb_usuario`
  MODIFY `usu_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_cont_receber`
--
ALTER TABLE `tb_cont_receber`
  ADD CONSTRAINT `fk_ctr_cli_id` FOREIGN KEY (`ctr_cli_id`) REFERENCES `tb_cliente` (`cli_id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
