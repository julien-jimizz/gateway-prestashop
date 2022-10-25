CREATE TABLE IF NOT EXISTS `_PREFIX_jimizz_transaction`
(
  `id_jimizz_transaction` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_cart` INT(11) UNSIGNED NOT NULL,
  `amount` FLOAT(12, 2) NOT NULL,
  `mode` ENUM ('production', 'testApproved', 'testRejected') NOT NULL,
  `status` ENUM ('pending', 'cancelled', 'failed', 'succeed') NOT NULL,
  `tx_hash` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id_jimizz_transaction`) USING BTREE,
  INDEX `id_cart` (`id_cart`) USING BTREE
)
  ENGINE = _MYSQL_ENGINE_
  DEFAULT CHARSET = utf8;
;
