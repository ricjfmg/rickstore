/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE DATABASE IF NOT EXISTS `rickstore` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `rickstore`;

CREATE TABLE IF NOT EXISTS `busca` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_cliente` int(10) unsigned NOT NULL DEFAULT '0',
  `busca` varchar(200) NOT NULL,
  `ip` varchar(16) NOT NULL,
  `datahora` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_cliente` (`id_cliente`)
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=latin1;

/*!40000 ALTER TABLE `busca` DISABLE KEYS */;
INSERT INTO `busca` (`id`, `id_cliente`, `busca`, `ip`, `datahora`) VALUES
	(63, 2, 'aaa', '::1', '2020-04-04 16:13:54'),
	(64, 2, 'aaa', '::1', '2020-04-04 16:14:27'),
	(65, 2, 'aaa', '::1', '2020-04-04 16:15:57');
/*!40000 ALTER TABLE `busca` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `cliente` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `telefone` varchar(20) NOT NULL,
  `endereco` varchar(255) NOT NULL,
  `cidade` varchar(100) NOT NULL,
  `estado` varchar(3) NOT NULL,
  `cep` varchar(10) NOT NULL,
  `login` varchar(50) NOT NULL,
  `senha` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*!40000 ALTER TABLE `cliente` DISABLE KEYS */;
INSERT INTO `cliente` (`id`, `nome`, `telefone`, `endereco`, `cidade`, `estado`, `cep`, `login`, `senha`, `email`) VALUES
	(1, 'Rick Passos', '', '', '', '', '', 'rick', '202cb962ac59075b964b07152d234b70', ''),
	(2, 'Admin Admilson', '', '', '', '', '', 'admin', '202cb962ac59075b964b07152d234b70', '');
/*!40000 ALTER TABLE `cliente` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `pedido` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_cliente` int(11) unsigned NOT NULL DEFAULT '0',
  `data` datetime NOT NULL,
  `data_aprov` datetime NOT NULL,
  `data_pagamento` datetime NOT NULL,
  `data_envio` datetime NOT NULL,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `observacoes` varchar(500) NOT NULL,
  `valor` double unsigned NOT NULL DEFAULT '0',
  `tipo_pagamento` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_cliente` (`id_cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40000 ALTER TABLE `pedido` DISABLE KEYS */;
/*!40000 ALTER TABLE `pedido` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `pedido_produto` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_pedido` int(10) unsigned DEFAULT '0',
  `id_produto` int(10) unsigned DEFAULT '0',
  `quantidade` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id_pedido` (`id_pedido`),
  KEY `Coluna 3` (`id_produto`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40000 ALTER TABLE `pedido_produto` DISABLE KEYS */;
/*!40000 ALTER TABLE `pedido_produto` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `produto` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_vendedor` int(11) unsigned NOT NULL DEFAULT '0',
  `nome` varchar(100) NOT NULL DEFAULT '0',
  `tamanho` float unsigned NOT NULL DEFAULT '0',
  `quantidade` int(11) NOT NULL DEFAULT '0',
  `valor` float unsigned NOT NULL DEFAULT '0',
  `descricao` varchar(500) NOT NULL DEFAULT '0',
  `img` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_vendedor` (`id_vendedor`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*!40000 ALTER TABLE `produto` DISABLE KEYS */;
INSERT INTO `produto` (`id`, `id_vendedor`, `nome`, `tamanho`, `quantidade`, `valor`, `descricao`, `img`) VALUES
	(1, 1, 'AAABBB', 0, 0, 1000, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam arcu ipsum, tempor non ipsum eget, tincidunt vehicula libero. Etiam mauris mi, semper a suscipit ac, laoreet eget dui. Duis tincidunt, libero nec facilisis pellentesque, sem orci imperdiet lorem, sit amet elementum eros lorem tempor tellus. Cras a egestas erat. Quisque lacinia metus at enim sodales, nec vulputate justo finibus. Cras elementum justo ut enim blandit feugiat. Nullam nec elit vel magna lacinia eleifend maximus eu quam. ', NULL),
	(2, 0, 'BBBCCC', 0, 0, 222.22, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam arcu ipsum, tempor non ipsum eget, tincidunt vehicula libero. Etiam mauris mi, semper a suscipit ac, laoreet eget dui. Duis tincidunt, libero nec facilisis pellentesque, sem orci imperdiet lorem, sit amet elementum eros lorem tempor tellus. Cras a egestas erat. Quisque lacinia metus at enim sodales, nec vulputate justo finibus. Cras elementum justo ut enim blandit feugiat. Nullam nec elit vel magna lacinia eleifend maximus eu quam. ', NULL),
	(3, 0, 'AAACCC', 0, 0, 333.33, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam arcu ipsum, tempor non ipsum eget, tincidunt vehicula libero. Etiam mauris mi, semper a suscipit ac, laoreet eget dui. Duis tincidunt, libero nec facilisis pellentesque, sem orci imperdiet lorem, sit amet elementum eros lorem tempor tellus. Cras a egestas erat. Quisque lacinia metus at enim sodales, nec vulputate justo finibus. Cras elementum justo ut enim blandit feugiat. Nullam nec elit vel magna lacinia eleifend maximus eu quam. ', NULL),
	(4, 0, 'BBBDDD', 0, 0, 333.33, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam arcu ipsum, tempor non ipsum eget, tincidunt vehicula libero. Etiam mauris mi, semper a suscipit ac, laoreet eget dui. Duis tincidunt, libero nec facilisis pellentesque, sem orci imperdiet lorem, sit amet elementum eros lorem tempor tellus. Cras a egestas erat. Quisque lacinia metus at enim sodales, nec vulputate justo finibus. Cras elementum justo ut enim blandit feugiat. Nullam nec elit vel magna lacinia eleifend maximus eu quam. ', NULL),
	(5, 0, 'AAADDD', 0, 0, 222.22, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam arcu ipsum, tempor non ipsum eget, tincidunt vehicula libero. Etiam mauris mi, semper a suscipit ac, laoreet eget dui. Duis tincidunt, libero nec facilisis pellentesque, sem orci imperdiet lorem, sit amet elementum eros lorem tempor tellus. Cras a egestas erat. Quisque lacinia metus at enim sodales, nec vulputate justo finibus. Cras elementum justo ut enim blandit feugiat. Nullam nec elit vel magna lacinia eleifend maximus eu quam. ', NULL),
	(6, 0, 'AAAEEE', 0, 0, 111.11, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam arcu ipsum, tempor non ipsum eget, tincidunt vehicula libero. Etiam mauris mi, semper a suscipit ac, laoreet eget dui. Duis tincidunt, libero nec facilisis pellentesque, sem orci imperdiet lorem, sit amet elementum eros lorem tempor tellus. Cras a egestas erat. Quisque lacinia metus at enim sodales, nec vulputate justo finibus. Cras elementum justo ut enim blandit feugiat. Nullam nec elit vel magna lacinia eleifend maximus eu quam. ', NULL),
	(7, 0, 'AAAFFF', 0, 0, 333.33, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam arcu ipsum, tempor non ipsum eget, tincidunt vehicula libero. Etiam mauris mi, semper a suscipit ac, laoreet eget dui. Duis tincidunt, libero nec facilisis pellentesque, sem orci imperdiet lorem, sit amet elementum eros lorem tempor tellus. Cras a egestas erat. Quisque lacinia metus at enim sodales, nec vulputate justo finibus. Cras elementum justo ut enim blandit feugiat. Nullam nec elit vel magna lacinia eleifend maximus eu quam. ', NULL);
/*!40000 ALTER TABLE `produto` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `produto_comentario` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_produto` int(10) unsigned NOT NULL DEFAULT '0',
  `id_cliente` int(10) unsigned NOT NULL DEFAULT '0',
  `texto` varchar(500) NOT NULL,
  `datahora` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_produto` (`id_produto`),
  KEY `id_cliente` (`id_cliente`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

/*!40000 ALTER TABLE `produto_comentario` DISABLE KEYS */;
INSERT INTO `produto_comentario` (`id`, `id_produto`, `id_cliente`, `texto`, `datahora`) VALUES
	(1, 1, 1, 'AAA AAA AAA AAA AAAAAA AAA AAA AAA AAAAAA AAA AAA AAA AAAAAA AAA AAA AAA AAAAAA AAA AAA AAA AAA', NULL),
	(2, 1, 2, 'BBB BBB BBB BBB BBB BBB BBB BBB ', NULL),
	(6, 1, 2, 'CCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCC\n\nCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCC', '2020-04-04 16:06:30'),
	(10, 1, 2, 'DDDDDDDDDDD DDDDDDDDDDD DDDDDDDDDDD DDDDDDDDDDD\n\n\nDDDDDDDDDDD DDDDDDDDDDD DDDDDDDDDDD\n\nDDDDDDDDDDD', '2020-04-04 16:18:03');
/*!40000 ALTER TABLE `produto_comentario` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `produto_img` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_produto` int(10) unsigned NOT NULL DEFAULT '0',
  `url` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_produto` (`id_produto`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40000 ALTER TABLE `produto_img` DISABLE KEYS */;
/*!40000 ALTER TABLE `produto_img` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
