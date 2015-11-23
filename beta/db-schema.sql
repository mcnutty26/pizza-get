CREATE TABLE IF NOT EXISTS `hir2_events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `discount` float NOT NULL,
  `discountSides` tinyint(1) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `live` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
)

CREATE TABLE IF NOT EXISTS `hir2_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `order` varchar(500) CHARACTER SET utf8 NOT NULL,
  `price` int(11) NOT NULL,
  `cardTransaction` tinyint(1) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
)

CREATE TABLE IF NOT EXISTS `hir2_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `order` varchar(500) CHARACTER SET utf8 NOT NULL,
  `price` int(11) NOT NULL,
  `paid` tinyint(1) NOT NULL,
  `entered` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
)

CREATE TABLE IF NOT EXISTS `hir2_pizza` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pizza` varchar(50) CHARACTER SET latin1 NOT NULL,
  `personal` int(11) NOT NULL,
  `small` int(11) NOT NULL,
  `medium` int(11) NOT NULL,
  `large` int(11) NOT NULL,
  PRIMARY KEY (`id`)
)

CREATE TABLE IF NOT EXISTS `hir2_sessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `guid` varchar(13) CHARACTER SET utf8 NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `order` varchar(500) CHARACTER SET utf8 NOT NULL,
  `price` int(11) NOT NULL,
  `price_stripe` int(11) NOT NULL,
  PRIMARY KEY (`id`)
)

CREATE TABLE IF NOT EXISTS `hir2_sides` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `price` int(11) NOT NULL,
  PRIMARY KEY (`id`)
)

CREATE TABLE IF NOT EXISTS `hir2_toppings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
)

INSERT INTO `hir2_events` (`id`, `discount`, `discountSides`, `active`, `live`) VALUES
(1, 1, 1, 1, 0);
INSERT INTO `hir2_pizza` (`id`, `pizza`, `personal`, `small`, `medium`, `large`) VALUES
(1, 'No Pizza - Sides Only', 0, 0, 0, 0);