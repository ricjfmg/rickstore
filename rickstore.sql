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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

DELETE FROM `busca`;
/*!40000 ALTER TABLE `busca` DISABLE KEYS */;
INSERT INTO `busca` (`id`, `id_cliente`, `busca`, `ip`, `datahora`) VALUES
	(1, 0, 'aaa', '::1', '2020-05-05 21:08:49'),
	(2, 0, 'ccc', '::1', '2020-05-05 21:08:53'),
	(3, 3, 'ccc', '::1', '2020-05-05 21:13:34'),
	(4, 3, 'bbb', '::1', '2020-05-05 21:13:40'),
	(5, 2, 'aaa', '::1', '2020-07-06 06:23:17');
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

DELETE FROM `cliente`;
/*!40000 ALTER TABLE `cliente` DISABLE KEYS */;
INSERT INTO `cliente` (`id`, `nome`, `login`, `senha`, `email`, `id_endereco`, `data`) VALUES
	(1, 'Rick Passos', 'rick', '202cb962ac59075b964b07152d234b70', '', 0, '2020-04-04 16:06:30'),
	(2, 'Admin Admilson', 'admin', '202cb962ac59075b964b07152d234b70', '', 0, '2020-04-04 16:06:30'),
	(3, 'teste', 'teste', '202cb962ac59075b964b07152d234b70', 'teste@a.com', 0, '2020-05-05 21:12:16');
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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

DELETE FROM `cliente_endereco`;
/*!40000 ALTER TABLE `cliente_endereco` DISABLE KEYS */;
INSERT INTO `cliente_endereco` (`id`, `id_cliente`, `telefone`, `endereco`, `cidade`, `estado`, `cep`) VALUES
	(11, 2, '111', 'AA', 'AA', 'AC', '111'),
	(12, 2, '1111', 'BBB', 'BBB', 'AC', '1111'),
	(13, 3, '33333333333', 'AAA', 'CCC', 'AC', '33333333');
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

DELETE FROM `cupom`;
/*!40000 ALTER TABLE `cupom` DISABLE KEYS */;
INSERT INTO `cupom` (`id`, `id_cliente`, `codigo`, `tipo`, `status`) VALUES
	(1, 1, '07EE7A91', 1, 0),
	(2, 1, 'A5C5B7B8', 2, 1),
	(3, 2, '00D12D57', 1, 0),
	(4, 2, '9222DEC1', 2, 1),
	(5, 3, '6D32D256', 2, 1),
	(6, 1, 'BED7D8EF', 1, 0),
	(7, 3, 'B1AF775B', 1, 0),
	(8, 2, 'F037E227', 2, 1);
/*!40000 ALTER TABLE `cupom` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `pedido` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_cliente` int(11) unsigned NOT NULL DEFAULT '0',
  `id_endereco` int(11) unsigned NOT NULL DEFAULT '0',
  `data` datetime NOT NULL,
  `data_pagamento` datetime NOT NULL,
  `data_conclusao` datetime NOT NULL,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `observacoes` varchar(500) NOT NULL,
  `valor` float unsigned NOT NULL DEFAULT '0',
  `taxas` float unsigned NOT NULL DEFAULT '0',
  `tipo_pagamento` varchar(50) NOT NULL,
  `id_cupom` int(11) NOT NULL DEFAULT '0',
  `identificacao_pagamento` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_cliente` (`id_cliente`),
  KEY `id_endereco` (`id_endereco`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

DELETE FROM `pedido`;
/*!40000 ALTER TABLE `pedido` DISABLE KEYS */;
INSERT INTO `pedido` (`id`, `id_cliente`, `id_endereco`, `data`, `data_pagamento`, `data_conclusao`, `status`, `observacoes`, `valor`, `taxas`, `tipo_pagamento`, `id_cupom`, `identificacao_pagamento`) VALUES
	(13, 2, 11, '2020-07-06 05:53:44', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '', 585, 150, '', 8, NULL),
	(14, 2, 11, '2020-07-06 06:11:47', '2020-07-06 06:12:25', '2020-07-06 06:29:10', 2, '', 1017, 210, '', 8, 'LVED66653924-2020'),
	(15, 2, 999, '2020-07-06 06:23:43', '0000-00-00 00:00:00', '2020-07-06 06:29:10', 2, '', 275.6, 99.6, '', 0, NULL);
/*!40000 ALTER TABLE `pedido` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `pedido_produto` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_pedido` int(10) unsigned NOT NULL DEFAULT '0',
  `id_produto` int(10) unsigned NOT NULL DEFAULT '0',
  `qtd` int(10) unsigned NOT NULL DEFAULT '0',
  `valor` float NOT NULL DEFAULT '0',
  `taxas` float unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id_pedido` (`id_pedido`),
  KEY `Coluna 3` (`id_produto`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;

DELETE FROM `pedido_produto`;
/*!40000 ALTER TABLE `pedido_produto` DISABLE KEYS */;
INSERT INTO `pedido_produto` (`id`, `id_pedido`, `id_produto`, `qtd`, `valor`, `taxas`) VALUES
	(28, 13, 2, 1, 160, 60),
	(29, 13, 7, 2, 240, 90),
	(30, 13, 0, 2, -65, 0),
	(31, 14, 3, 2, 320, 120),
	(32, 14, 7, 2, 240, 90),
	(33, 14, 0, 2, -113, 0),
	(34, 15, 2, 1, 265.6, 99.6);
/*!40000 ALTER TABLE `pedido_produto` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `produto` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_vendedor` int(11) unsigned NOT NULL DEFAULT '0',
  `nome` varchar(100) NOT NULL DEFAULT '',
  `tamanho` float unsigned NOT NULL DEFAULT '0',
  `qtd` int(11) NOT NULL DEFAULT '0',
  `valor` float unsigned NOT NULL DEFAULT '0',
  `base` float unsigned NOT NULL DEFAULT '0',
  `descricao` varchar(500) NOT NULL DEFAULT '',
  `img` varchar(100) NOT NULL DEFAULT '',
  `inativo` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id_vendedor` (`id_vendedor`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

DELETE FROM `produto`;
/*!40000 ALTER TABLE `produto` DISABLE KEYS */;
INSERT INTO `produto` (`id`, `id_vendedor`, `nome`, `tamanho`, `qtd`, `valor`, `base`, `descricao`, `img`, `inativo`) VALUES
	(2, 0, '123AAA', 0, 1, 265.6, 166, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam arcu ipsum, tempor non ipsum eget, tincidunt vehicula libero. Etiam mauris mi, semper a suscipit ac, laoreet eget dui. Duis tincidunt, libero nec facilisis pellentesque, sem orci imperdiet lorem, sit amet elementum eros lorem tempor tellus. Cras a egestas erat. Quisque lacinia metus at enim sodales, nec vulputate justo finibus. Cras elementum justo ut enim blandit feugiat. Nullam nec elit vel magna lacinia eleifend maximus eu quam. ', '', 0),
	(3, 0, 'AAACCC', 0, 0, 320, 200, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam arcu ipsum, tempor non ipsum eget, tincidunt vehicula libero. Etiam mauris mi, semper a suscipit ac, laoreet eget dui. Duis tincidunt, libero nec facilisis pellentesque, sem orci imperdiet lorem, sit amet elementum eros lorem tempor tellus. Cras a egestas erat. Quisque lacinia metus at enim sodales, nec vulputate justo finibus. Cras elementum justo ut enim blandit feugiat. Nullam nec elit vel magna lacinia eleifend maximus eu quam. ', '', 0),
	(4, 0, 'BBBDDD', 0, 3, 480, 300, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam arcu ipsum, tempor non ipsum eget, tincidunt vehicula libero. Etiam mauris mi, semper a suscipit ac, laoreet eget dui. Duis tincidunt, libero nec facilisis pellentesque, sem orci imperdiet lorem, sit amet elementum eros lorem tempor tellus. Cras a egestas erat. Quisque lacinia metus at enim sodales, nec vulputate justo finibus. Cras elementum justo ut enim blandit feugiat. Nullam nec elit vel magna lacinia eleifend maximus eu quam. ', '', 0),
	(5, 0, 'AAADDD', 0, 1, 400, 250, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam arcu ipsum, tempor non ipsum eget, tincidunt vehicula libero. Etiam mauris mi, semper a suscipit ac, laoreet eget dui. Duis tincidunt, libero nec facilisis pellentesque, sem orci imperdiet lorem, sit amet elementum eros lorem tempor tellus. Cras a egestas erat. Quisque lacinia metus at enim sodales, nec vulputate justo finibus. Cras elementum justo ut enim blandit feugiat. Nullam nec elit vel magna lacinia eleifend maximus eu quam. ', '', 0),
	(6, 0, 'AAAEEE', 0, 2, 560, 350, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam arcu ipsum, tempor non ipsum eget, tincidunt vehicula libero. Etiam mauris mi, semper a suscipit ac, laoreet eget dui. Duis tincidunt, libero nec facilisis pellentesque, sem orci imperdiet lorem, sit amet elementum eros lorem tempor tellus. Cras a egestas erat. Quisque lacinia metus at enim sodales, nec vulputate justo finibus. Cras elementum justo ut enim blandit feugiat. Nullam nec elit vel magna lacinia eleifend maximus eu quam. ', '', 0),
	(7, 0, 'AAAFFF', 0, 1, 240, 150, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam arcu ipsum, tempor non ipsum eget, tincidunt vehicula libero. Etiam mauris mi, semper a suscipit ac, laoreet eget dui. Duis tincidunt, libero nec facilisis pellentesque, sem orci imperdiet lorem, sit amet elementum eros lorem tempor tellus. Cras a egestas erat. Quisque lacinia metus at enim sodales, nec vulputate justo finibus. Cras elementum justo ut enim blandit feugiat. Nullam nec elit vel magna lacinia eleifend maximus eu quam. ', '', 0),
	(8, 0, 'Teste1', 0, 4, 160, 100, 'Lorem Ipsum', '', 0),
	(9, 0, 'teste2', 0, 10, 320, 200, 'AAAAA', '', 0);
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
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

DELETE FROM `produto_comentario`;
/*!40000 ALTER TABLE `produto_comentario` DISABLE KEYS */;
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
