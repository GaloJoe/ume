-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 13, 2014 at 11:35 PM
-- Server version: 5.5.36
-- PHP Version: 5.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `dallnew`
--
CREATE DATABASE IF NOT EXISTS `dallnew` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `dallnew`;

-- --------------------------------------------------------

--
-- Table structure for table `andar`
--

DROP TABLE IF EXISTS `andar`;
CREATE TABLE IF NOT EXISTS `andar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) NOT NULL,
  `bloco` int(11) NOT NULL,
  `posicao` int(11) DEFAULT NULL,
  `ativo` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `bloco` (`bloco`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;

-- --------------------------------------------------------

--
-- Table structure for table `apartamento`
--

DROP TABLE IF EXISTS `apartamento`;
CREATE TABLE IF NOT EXISTS `apartamento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero` int(11) NOT NULL,
  `descricao` varchar(100) NOT NULL,
  `metragem` varchar(20) NOT NULL,
  `valor` float(20,2) NOT NULL,
  `box_estacionamento` int(11) NOT NULL,
  `bloco` int(11) NOT NULL,
  `andar` int(11) DEFAULT NULL,
  `disponivel` tinyint(1) NOT NULL DEFAULT '1',
  `ativo` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `bloco0_idx` (`bloco`),
  KEY `andar` (`andar`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=282 ;

-- --------------------------------------------------------

--
-- Table structure for table `atividade`
--

DROP TABLE IF EXISTS `atividade`;
CREATE TABLE IF NOT EXISTS `atividade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unidade_medida` int(11) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `valor_unitario` float(20,2) NOT NULL,
  `ativo` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `unidade_medida` (`unidade_medida`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- Table structure for table `bloco`
--

DROP TABLE IF EXISTS `bloco`;
CREATE TABLE IF NOT EXISTS `bloco` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(100) NOT NULL,
  `empreendimento` int(11) NOT NULL,
  `modulo` int(11) DEFAULT NULL,
  `disponivel` tinyint(1) NOT NULL DEFAULT '1',
  `ativo` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_empreendimento_idx` (`empreendimento`),
  KEY `modulo` (`modulo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `categoria`
--

DROP TABLE IF EXISTS `categoria`;
CREATE TABLE IF NOT EXISTS `categoria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `empreendimento` int(11) DEFAULT NULL,
  `descricao` varchar(255) NOT NULL,
  `consumo` int(11) DEFAULT NULL,
  `ativo` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `empreendimento` (`empreendimento`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Table structure for table `empreendimento`
--

DROP TABLE IF EXISTS `empreendimento`;
CREATE TABLE IF NOT EXISTS `empreendimento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(60) NOT NULL,
  `logo` varchar(100) NOT NULL,
  `implantacao` varchar(100) NOT NULL,
  `implantacao_full` varchar(100) DEFAULT NULL,
  `dias_reserva` int(11) NOT NULL,
  `comissao_corretor` float(5,5) NOT NULL,
  `comissao_adm_vendas` float(5,5) NOT NULL,
  `andares` int(11) NOT NULL,
  `ativo` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `historico`
--

DROP TABLE IF EXISTS `historico`;
CREATE TABLE IF NOT EXISTS `historico` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `apartamento` int(11) NOT NULL,
  `data` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `data_cancelamento` timestamp NULL DEFAULT NULL,
  `usuario` int(11) NOT NULL,
  `cliente_nome` varchar(256) DEFAULT NULL,
  `cliente_cpf` varchar(20) DEFAULT NULL,
  `status` varchar(30) DEFAULT NULL,
  `em_contratacao` tinyint(1) DEFAULT NULL,
  `vendido` tinyint(1) DEFAULT NULL,
  `corretor_pago_meia` tinyint(1) DEFAULT NULL,
  `corretor_pago` tinyint(1) DEFAULT NULL,
  `valor_pago_corretor` float(20,2) DEFAULT NULL,
  `data_pagamento_corretor` timestamp NULL DEFAULT NULL,
  `data_pagamento_corretor_meia` timestamp NULL DEFAULT NULL,
  `valor_comissao_corretor` float(20,2) DEFAULT NULL,
  `adm_vendas_pago` tinyint(1) DEFAULT NULL,
  `data_pagamento_adm_vendas` timestamp NULL DEFAULT NULL,
  `valor_pagamento_adm_vendas` float(20,2) DEFAULT NULL,
  `valor_venda` varchar(20) DEFAULT NULL,
  `valor_entrada` float(20,2) DEFAULT NULL,
  `valor_financiado_construtora` float(20,2) DEFAULT NULL,
  `valor_financiado_caixa` float(20,2) DEFAULT NULL,
  `data_aprovacao_financiamento` timestamp NULL DEFAULT NULL,
  `ativo` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `apartamento0_idx` (`apartamento`),
  KEY `usuario0_idx` (`usuario`),
  KEY `idx_1` (`apartamento`,`ativo`,`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1329 ;

-- --------------------------------------------------------

--
-- Table structure for table `historico_atividade`
--

DROP TABLE IF EXISTS `historico_atividade`;
CREATE TABLE IF NOT EXISTS `historico_atividade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `atividade` int(11) NOT NULL,
  `referencia` int(11) DEFAULT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `retencao` float DEFAULT NULL,
  `recibo` int(11) DEFAULT NULL,
  `data` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `usuario` int(11) NOT NULL,
  `empreiteiro` int(11) NOT NULL,
  `ativo` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `atividade` (`atividade`,`usuario`),
  KEY `usuario` (`usuario`),
  KEY `usuario_2` (`usuario`),
  KEY `empreiteiro` (`empreiteiro`),
  KEY `recibo` (`recibo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=40 ;

-- --------------------------------------------------------

--
-- Table structure for table `imobiliaria`
--

DROP TABLE IF EXISTS `imobiliaria`;
CREATE TABLE IF NOT EXISTS `imobiliaria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL,
  `telefone` varchar(16) DEFAULT NULL,
  `endereco` varchar(250) DEFAULT NULL,
  `ativo` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- Table structure for table `material`
--

DROP TABLE IF EXISTS `material`;
CREATE TABLE IF NOT EXISTS `material` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) NOT NULL,
  `consumo` float NOT NULL,
  `categoria` int(11) NOT NULL,
  `ativo` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `categoria` (`categoria`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;

-- --------------------------------------------------------

--
-- Table structure for table `modulo`
--

DROP TABLE IF EXISTS `modulo`;
CREATE TABLE IF NOT EXISTS `modulo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) NOT NULL,
  `empreendimento` int(11) NOT NULL,
  `ativo` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `empreendimento` (`empreendimento`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `movimentacao`
--

DROP TABLE IF EXISTS `movimentacao`;
CREATE TABLE IF NOT EXISTS `movimentacao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `material` int(11) NOT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `quantidade` decimal(10,2) NOT NULL,
  `data` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tipo_movimentacao` int(11) NOT NULL,
  `usuario` int(11) NOT NULL,
  `ativo` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `material` (`material`,`tipo_movimentacao`,`usuario`),
  KEY `tipo_movimentacao` (`tipo_movimentacao`),
  KEY `usuario` (`usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=242 ;

-- --------------------------------------------------------

--
-- Table structure for table `recibo`
--

DROP TABLE IF EXISTS `recibo`;
CREATE TABLE IF NOT EXISTS `recibo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `empreiteiro` int(11) NOT NULL,
  `data` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `data_inicial` timestamp NULL DEFAULT NULL,
  `data_final` timestamp NULL DEFAULT NULL,
  `usuario` int(11) NOT NULL,
  `empreendimento` int(11) NOT NULL,
  `ativo` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `empreiteiro` (`empreiteiro`),
  KEY `usuario` (`usuario`),
  KEY `empreendimento` (`empreendimento`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=42 ;

-- --------------------------------------------------------

--
-- Table structure for table `retencao`
--

DROP TABLE IF EXISTS `retencao`;
CREATE TABLE IF NOT EXISTS `retencao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `valor` float NOT NULL,
  `data` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `recibo` int(11) NOT NULL,
  `usuario` int(11) NOT NULL,
  `ativo` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `recibo` (`recibo`),
  KEY `usuario` (`usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- Table structure for table `tipo_movimentacao`
--

DROP TABLE IF EXISTS `tipo_movimentacao`;
CREATE TABLE IF NOT EXISTS `tipo_movimentacao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) NOT NULL,
  `ativo` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `tipo_unidade_medida`
--

DROP TABLE IF EXISTS `tipo_unidade_medida`;
CREATE TABLE IF NOT EXISTS `tipo_unidade_medida` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tabela` varchar(255) NOT NULL,
  `ativo` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `unidade_medida`
--

DROP TABLE IF EXISTS `unidade_medida`;
CREATE TABLE IF NOT EXISTS `unidade_medida` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `empreendimento` int(11) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `tipo_unidade_medida` int(11) NOT NULL,
  `ativo` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `empreendimento` (`empreendimento`,`tipo_unidade_medida`),
  KEY `tipo_unidade_medida` (`tipo_unidade_medida`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(60) NOT NULL,
  `email` varchar(60) NOT NULL,
  `senha` varchar(256) NOT NULL,
  `telefone` varchar(16) NOT NULL,
  `imobiliaria` int(11) DEFAULT NULL,
  `perfil` varchar(20) NOT NULL,
  `corretor_chefe` tinyint(1) NOT NULL DEFAULT '0',
  `ativo` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `imobiliaria0` (`imobiliaria`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=65 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `andar`
--
ALTER TABLE `andar`
  ADD CONSTRAINT `fk_bloco_andar` FOREIGN KEY (`bloco`) REFERENCES `bloco` (`id`);

--
-- Constraints for table `apartamento`
--
ALTER TABLE `apartamento`
  ADD CONSTRAINT `bloco0` FOREIGN KEY (`bloco`) REFERENCES `bloco` (`id`),
  ADD CONSTRAINT `fk_andar_apartamento` FOREIGN KEY (`andar`) REFERENCES `andar` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `atividade`
--
ALTER TABLE `atividade`
  ADD CONSTRAINT `fk_unidade_medida_atividade` FOREIGN KEY (`unidade_medida`) REFERENCES `unidade_medida` (`id`);

--
-- Constraints for table `bloco`
--
ALTER TABLE `bloco`
  ADD CONSTRAINT `empreendimento0` FOREIGN KEY (`empreendimento`) REFERENCES `empreendimento` (`id`),
  ADD CONSTRAINT `fk_modulo_bloco` FOREIGN KEY (`modulo`) REFERENCES `modulo` (`id`);

--
-- Constraints for table `categoria`
--
ALTER TABLE `categoria`
  ADD CONSTRAINT `fk_empreendimento` FOREIGN KEY (`empreendimento`) REFERENCES `empreendimento` (`id`);

--
-- Constraints for table `historico`
--
ALTER TABLE `historico`
  ADD CONSTRAINT `apartamento0` FOREIGN KEY (`apartamento`) REFERENCES `apartamento` (`id`),
  ADD CONSTRAINT `usuario0` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`id`);

--
-- Constraints for table `historico_atividade`
--
ALTER TABLE `historico_atividade`
  ADD CONSTRAINT `fk_atividade_historico_atividade` FOREIGN KEY (`atividade`) REFERENCES `atividade` (`id`),
  ADD CONSTRAINT `fk_empreiteiro_historico_atividade` FOREIGN KEY (`empreiteiro`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `fk_recibo_historico_atividade` FOREIGN KEY (`recibo`) REFERENCES `recibo` (`id`),
  ADD CONSTRAINT `fk_usuario_historico_atividade` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`id`);

--
-- Constraints for table `material`
--
ALTER TABLE `material`
  ADD CONSTRAINT `fk_categoria` FOREIGN KEY (`categoria`) REFERENCES `categoria` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `modulo`
--
ALTER TABLE `modulo`
  ADD CONSTRAINT `fk_empreendimento_modulo` FOREIGN KEY (`empreendimento`) REFERENCES `empreendimento` (`id`);

--
-- Constraints for table `movimentacao`
--
ALTER TABLE `movimentacao`
  ADD CONSTRAINT `fk_material` FOREIGN KEY (`material`) REFERENCES `material` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tipo_movimentacao` FOREIGN KEY (`tipo_movimentacao`) REFERENCES `tipo_movimentacao` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_usuario` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `recibo`
--
ALTER TABLE `recibo`
  ADD CONSTRAINT `fk_empreendimento_recibo` FOREIGN KEY (`empreendimento`) REFERENCES `empreendimento` (`id`),
  ADD CONSTRAINT `fk_empreiteiro_recibo` FOREIGN KEY (`empreiteiro`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `fk_usuario_recibo` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`id`);

--
-- Constraints for table `retencao`
--
ALTER TABLE `retencao`
  ADD CONSTRAINT `fk_recibo_retencao` FOREIGN KEY (`recibo`) REFERENCES `recibo` (`id`),
  ADD CONSTRAINT `fk_usuario_retencao` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`id`);

--
-- Constraints for table `unidade_medida`
--
ALTER TABLE `unidade_medida`
  ADD CONSTRAINT `fk_empreendimento_unidade_medida` FOREIGN KEY (`empreendimento`) REFERENCES `empreendimento` (`id`),
  ADD CONSTRAINT `fk_tipo_unidade_medida` FOREIGN KEY (`tipo_unidade_medida`) REFERENCES `tipo_unidade_medida` (`id`);

--
-- Constraints for table `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `imobiliaria0` FOREIGN KEY (`imobiliaria`) REFERENCES `imobiliaria` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
