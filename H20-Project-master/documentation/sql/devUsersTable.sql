--
-- Create a users table for development with user: test and password: tester
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `username` varchar(124) DEFAULT NULL,
  `key` varchar(524) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

INSERT INTO `users` (`id`, `username`, `key`) VALUES
(1, 'test', '5adafb7d60ef4c9d0d83b973d309b4dff1e0a5474badb1c16362f2002745839f6e407a2a69daaa63e4a41a74bbf490e03bc367a22030fdbe9474fa13d81f4396');
