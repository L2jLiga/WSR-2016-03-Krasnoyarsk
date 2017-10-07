drop table if exists `users`;
drop table if exists `goods`;
drop table if exists `comms`;

create table `users` (
	`id` int(5) NOT NULL AUTO_INCREMENT,
	`login` varchar(40) NOT NULL,
	`password` varchar(32) NOT NULL,
	`hash` varchar(32) NOT NULL,
  PRIMARY key(`id`),
  UNIQUE KEY `login` (`login`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
create table `goods` (
	`id` int(5) NOT NULL AUTO_INCREMENT,
	`name` varchar(100) NOT NULL,
	`foto` int(100) NOT NULL,
	`price` int(10) NOT NULL,
	`cat` int(2) NOT NULL,
	`desc` text not null,
	PRIMARY key(`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
create table `comms` (
	`id` int(5) NOT NULL AUTO_INCREMENT,
	`author` varchar(40) NOT NULL,
	`mail` varchar(50) NULL,
	`date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`text` text not null,
	`id_goods` int(5) NOT NULL,
	PRIMARY key(`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
create table `cats` (
	`id` int(5) NOT NULL AUTO_INCREMENT,
	`name` varchar(100) NOT NULL,
	PRIMARY key(`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


insert into `cats` (`name`) VALUES('Однокамерные'),('Двукамерные'),('Прочие');
insert into `users` (`login`,`password`) VALUES ('admin','admin');

