CREATE TABLE `user_details` (
  `id` mediumint(8) unsigned NOT NULL,
  `address` varchar(100) NOT NULL,
  `address_cont` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(2) NOT NULL,
  `zip` varchar(10) NOT NULL,
  `phone` varchar(15) NOT NULL,
  PRIMARY KEY  (`id`)
  ) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

# Administrator user
INSERT INTO `user_details` ( `id` , `address` , `address_cont` , `city` , `state` , `zip` , `phone` )
VALUES (
1 , '1234 This St.', 'Suite 123', 'Minneapolis', 'MN' , '12345-1234', ''
);