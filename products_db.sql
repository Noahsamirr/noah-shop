<?php
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `type` varchar(60) NOT NULL,
  'sku' varchar(12) NOT NULL,
  'price' int(10) NOT NULL,
  'size' int(10),
  'height' int(10),
  'width' int(10),
  'length' int(10),
  'weight' int(10),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

?>