CREATE TABLE IF NOT EXISTS `de_sports` (
  `sport_id` int(11) NOT NULL AUTO_INCREMENT,
  `sport_name` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`sport_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `de_product` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `sports_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `product_price` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `de_actvities` (
  `activities_id` int(11) NOT NULL AUTO_INCREMENT,
  `sport_id` int(11) NOT NULL,
  `class_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `class_price` int NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`activies_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `de_apply` (
  `apply_id` int(11) NOT NULL AUTO_INCREMENT,
  `sport_id` int(11) NOT NULL,
  `activities_id` int(11) NOT NULL,
  `user_num` int(11) NOT NULL,
  `class_name` varchar(255) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`userclass_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `de_classUser`(
	`user_num` int(11) not null auto_increment,
    `user_id` varchar(200) NOT NULL,
    `user_name` varchar(200) NOT NULL,
    `id` varchar(200) NOT NULL,
    `last_login` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    primary key(`user_num`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

