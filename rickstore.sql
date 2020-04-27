/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE DATABASE IF NOT EXISTS `rickstore` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `rickstore`;

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(50) NOT NULL,
  `senha` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

DELETE FROM `admin`;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` (`id`, `login`, `senha`, `email`) VALUES
	(1, 'admin', '202cb962ac59075b964b07152d234b70', 'ricjfmg@gmail.com');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `busca` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_cliente` int(10) unsigned NOT NULL DEFAULT '0',
  `busca` varchar(200) NOT NULL,
  `ip` varchar(16) NOT NULL,
  `datahora` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_cliente` (`id_cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DELETE FROM `busca`;
/*!40000 ALTER TABLE `busca` DISABLE KEYS */;
/*!40000 ALTER TABLE `busca` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `cliente` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `login` varchar(50) NOT NULL,
  `senha` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `id_endereco` int(11) NOT NULL DEFAULT '0',
  `data` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

DELETE FROM `cliente`;
/*!40000 ALTER TABLE `cliente` DISABLE KEYS */;
INSERT INTO `cliente` (`id`, `nome`, `login`, `senha`, `email`, `id_endereco`, `data`) VALUES
	(1, 'Rick Passos', 'rick', '202cb962ac59075b964b07152d234b70', '', 0, '2020-04-04 16:06:30'),
	(2, 'Admin Admilson', 'admin', '202cb962ac59075b964b07152d234b70', '', 0, '2020-04-04 16:06:30');
/*!40000 ALTER TABLE `cliente` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `cliente_endereco` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_cliente` int(11) NOT NULL DEFAULT '0',
  `telefone` varchar(20) NOT NULL,
  `endereco` varchar(300) NOT NULL,
  `cidade` varchar(100) NOT NULL,
  `estado` varchar(3) NOT NULL,
  `cep` varchar(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_cliente_cep` (`id_cliente`,`cep`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

DELETE FROM `cliente_endereco`;
/*!40000 ALTER TABLE `cliente_endereco` DISABLE KEYS */;
INSERT INTO `cliente_endereco` (`id`, `id_cliente`, `telefone`, `endereco`, `cidade`, `estado`, `cep`) VALUES
	(11, 2, '111', 'AA', 'AA', 'AC', '111'),
	(12, 2, '1111', 'BBB', 'BBB', 'AC', '1111');
/*!40000 ALTER TABLE `cliente_endereco` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `cupom` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_cliente` int(11) NOT NULL DEFAULT '0',
  `codigo` varchar(10) NOT NULL,
  `tipo` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1: Fixo; 2: Perc',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: Disp; 1: Usado',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_cliente_codigo` (`id_cliente`,`codigo`),
  KEY `id_cliente` (`id_cliente`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

DELETE FROM `cupom`;
/*!40000 ALTER TABLE `cupom` DISABLE KEYS */;
INSERT INTO `cupom` (`id`, `id_cliente`, `codigo`, `tipo`, `status`) VALUES
	(1, 1, '07EE7A91', 1, 0),
	(2, 1, 'A5C5B7B8', 2, 1),
	(3, 2, '00D12D57', 1, 0),
	(4, 2, '9222DEC1', 2, 1);
/*!40000 ALTER TABLE `cupom` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `pedido` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_cliente` int(11) unsigned NOT NULL DEFAULT '0',
  `id_endereco` int(11) unsigned NOT NULL DEFAULT '0',
  `data` datetime NOT NULL,
  `data_aprov` datetime NOT NULL,
  `data_pagamento` datetime NOT NULL,
  `data_envio` datetime NOT NULL,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `observacoes` varchar(500) NOT NULL,
  `valor` float unsigned NOT NULL DEFAULT '0',
  `tipo_pagamento` varchar(50) NOT NULL,
  `id_cupom` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id_cliente` (`id_cliente`),
  KEY `id_endereco` (`id_endereco`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

DELETE FROM `pedido`;
/*!40000 ALTER TABLE `pedido` DISABLE KEYS */;
INSERT INTO `pedido` (`id`, `id_cliente`, `id_endereco`, `data`, `data_aprov`, `data_pagamento`, `data_envio`, `status`, `observacoes`, `valor`, `tipo_pagamento`, `id_cupom`) VALUES
	(5, 2, 11, '2020-04-26 21:55:30', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '', 308.997, '', 4);
/*!40000 ALTER TABLE `pedido` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `pedido_produto` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_pedido` int(10) unsigned NOT NULL DEFAULT '0',
  `id_produto` int(10) unsigned NOT NULL DEFAULT '0',
  `qtd` int(10) unsigned NOT NULL DEFAULT '0',
  `valor` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id_pedido` (`id_pedido`),
  KEY `Coluna 3` (`id_produto`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

DELETE FROM `pedido_produto`;
/*!40000 ALTER TABLE `pedido_produto` DISABLE KEYS */;
INSERT INTO `pedido_produto` (`id`, `id_pedido`, `id_produto`, `qtd`, `valor`) VALUES
	(12, 5, 2, 1, 222.22),
	(13, 5, 6, 1, 111.11),
	(14, 5, 0, 1, -34.333);
/*!40000 ALTER TABLE `pedido_produto` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `produto` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_vendedor` int(11) unsigned NOT NULL DEFAULT '0',
  `nome` varchar(100) NOT NULL DEFAULT '',
  `tamanho` float unsigned NOT NULL DEFAULT '0',
  `quantidade` int(11) NOT NULL DEFAULT '0',
  `valor` float unsigned NOT NULL DEFAULT '0',
  `descricao` varchar(500) NOT NULL DEFAULT '',
  `img` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `id_vendedor` (`id_vendedor`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

DELETE FROM `produto`;
/*!40000 ALTER TABLE `produto` DISABLE KEYS */;
INSERT INTO `produto` (`id`, `id_vendedor`, `nome`, `tamanho`, `quantidade`, `valor`, `descricao`, `img`) VALUES
	(1, 1, 'AAABBB', 0, 0, 111, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam arcu ipsum, tempor non ipsum eget, tincidunt vehicula libero. Etiam mauris mi, semper a suscipit ac, laoreet eget dui. Duis tincidunt, libero nec facilisis pellentesque, sem orci imperdiet lorem, sit amet elementum eros lorem tempor tellus. Cras a egestas erat. Quisque lacinia metus at enim sodales, nec vulputate justo finibus. Cras elementum justo ut enim blandit feugiat. Nullam nec elit vel magna lacinia eleifend maximus eu quam. ', ''),
	(2, 0, 'BBBCCC', 0, 0, 222.22, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam arcu ipsum, tempor non ipsum eget, tincidunt vehicula libero. Etiam mauris mi, semper a suscipit ac, laoreet eget dui. Duis tincidunt, libero nec facilisis pellentesque, sem orci imperdiet lorem, sit amet elementum eros lorem tempor tellus. Cras a egestas erat. Quisque lacinia metus at enim sodales, nec vulputate justo finibus. Cras elementum justo ut enim blandit feugiat. Nullam nec elit vel magna lacinia eleifend maximus eu quam. ', ''),
	(3, 0, 'AAACCC', 0, 0, 333.33, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam arcu ipsum, tempor non ipsum eget, tincidunt vehicula libero. Etiam mauris mi, semper a suscipit ac, laoreet eget dui. Duis tincidunt, libero nec facilisis pellentesque, sem orci imperdiet lorem, sit amet elementum eros lorem tempor tellus. Cras a egestas erat. Quisque lacinia metus at enim sodales, nec vulputate justo finibus. Cras elementum justo ut enim blandit feugiat. Nullam nec elit vel magna lacinia eleifend maximus eu quam. ', ''),
	(4, 0, 'BBBDDD', 0, 0, 333.33, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam arcu ipsum, tempor non ipsum eget, tincidunt vehicula libero. Etiam mauris mi, semper a suscipit ac, laoreet eget dui. Duis tincidunt, libero nec facilisis pellentesque, sem orci imperdiet lorem, sit amet elementum eros lorem tempor tellus. Cras a egestas erat. Quisque lacinia metus at enim sodales, nec vulputate justo finibus. Cras elementum justo ut enim blandit feugiat. Nullam nec elit vel magna lacinia eleifend maximus eu quam. ', ''),
	(5, 0, 'AAADDD', 0, 0, 222.22, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam arcu ipsum, tempor non ipsum eget, tincidunt vehicula libero. Etiam mauris mi, semper a suscipit ac, laoreet eget dui. Duis tincidunt, libero nec facilisis pellentesque, sem orci imperdiet lorem, sit amet elementum eros lorem tempor tellus. Cras a egestas erat. Quisque lacinia metus at enim sodales, nec vulputate justo finibus. Cras elementum justo ut enim blandit feugiat. Nullam nec elit vel magna lacinia eleifend maximus eu quam. ', ''),
	(6, 0, 'AAAEEE', 0, 0, 111.11, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam arcu ipsum, tempor non ipsum eget, tincidunt vehicula libero. Etiam mauris mi, semper a suscipit ac, laoreet eget dui. Duis tincidunt, libero nec facilisis pellentesque, sem orci imperdiet lorem, sit amet elementum eros lorem tempor tellus. Cras a egestas erat. Quisque lacinia metus at enim sodales, nec vulputate justo finibus. Cras elementum justo ut enim blandit feugiat. Nullam nec elit vel magna lacinia eleifend maximus eu quam. ', ''),
	(7, 0, 'AAAFFF', 0, 0, 333.33, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam arcu ipsum, tempor non ipsum eget, tincidunt vehicula libero. Etiam mauris mi, semper a suscipit ac, laoreet eget dui. Duis tincidunt, libero nec facilisis pellentesque, sem orci imperdiet lorem, sit amet elementum eros lorem tempor tellus. Cras a egestas erat. Quisque lacinia metus at enim sodales, nec vulputate justo finibus. Cras elementum justo ut enim blandit feugiat. Nullam nec elit vel magna lacinia eleifend maximus eu quam. ', '');
/*!40000 ALTER TABLE `produto` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `produto_comentario` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_produto` int(10) unsigned NOT NULL DEFAULT '0',
  `id_cliente` int(10) unsigned NOT NULL DEFAULT '0',
  `texto` varchar(500) NOT NULL,
  `datahora` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_produto` (`id_produto`),
  KEY `id_cliente` (`id_cliente`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

DELETE FROM `produto_comentario`;
/*!40000 ALTER TABLE `produto_comentario` DISABLE KEYS */;
INSERT INTO `produto_comentario` (`id`, `id_produto`, `id_cliente`, `texto`, `datahora`) VALUES
	(1, 1, 1, 'AAA AAA AAA AAA AAAAAA AAA AAA AAA AAAAAA AAA AAA AAA AAAAAA AAA AAA AAA AAAAAA AAA AAA AAA AAA', '2020-04-04 16:06:30'),
	(2, 1, 2, 'BBB BBB BBB BBB BBB BBB BBB BBB ', '2020-04-04 16:06:30'),
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

DELETE FROM `produto_img`;
/*!40000 ALTER TABLE `produto_img` DISABLE KEYS */;
/*!40000 ALTER TABLE `produto_img` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
