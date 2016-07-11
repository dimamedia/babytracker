# Babytracker
Track your baby's nutrition and health progress

Version 2016.7

See: http://loki.dima.fi/babytracker

## Database table

```sql
CREATE TABLE `babytracker` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `time` datetime NOT NULL,
  `weight` int(6) DEFAULT '0',
  `height` decimal(5,2) DEFAULT '0.00',
  `headcirc` decimal(5,2) DEFAULT '0.00',
  `temperature` decimal(3,1) DEFAULT '0.0',
  `pee` int(4) DEFAULT '0',
  `poo` varchar(45) COLLATE utf8_swedish_ci DEFAULT '0',
  `breast` int(4) DEFAULT '0',
  `bottleBreast` int(4) DEFAULT '0',
  `bottleSubstitute` int(4) DEFAULT '0',
  `bottleOther` int(4) DEFAULT '0',
  `info` varchar(255) COLLATE utf8_swedish_ci DEFAULT NULL,
  `additions` varchar(255) COLLATE utf8_swedish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=369 DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

```
