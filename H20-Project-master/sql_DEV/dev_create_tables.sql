--
-- Create all tables need for DEVELOPMENT. User table creds = user: test and password: tester
-- All data is sample data
--

--- CREATE h2o_answers table
CREATE TABLE IF NOT EXISTS `h2o_answers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `surveyby_u_id` varchar(45) DEFAULT NULL,
  `surveyfor_u_id` varchar(45) DEFAULT NULL,
  `sur_type` varchar(45) DEFAULT NULL,
  `answers` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--- CREATE h2o_categories table
CREATE TABLE IF NOT EXISTS `h2o_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--- CREATE h2o_questions table
CREATE TABLE IF NOT EXISTS `h2o_questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` varchar(45) DEFAULT NULL,
  `text` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--- CREATE h2o_survey_type table
CREATE TABLE IF NOT EXISTS `h2o_survey_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--- CREATE h2o_users table
CREATE TABLE IF NOT EXISTS `h2o_users` (
  `id` int(12) NOT NULL,
  `username` varchar(124) DEFAULT NULL,
  `key` varchar(524) DEFAULT NULL,
  `role` enum('admin','user') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--- INSERT h2o_answers table
INSERT INTO `h2o_answers`(`id`,`surveyby_u_id`,`surveyfor_u_id`,`sur_type`,`answers`)
VALUES
('1', '1', '1', '2', '1,5,4,2,2,4,5,2,1,3,5,4,5,4,3,2,5,4,3,4,4,5,2,1,4,3,2,4,2,5,2,1,3,4,2,3,1,3,2,5,3,2,3,2,4,5,2,3,2,1,4,5,2,3,2,1,1,2,3,5,4,2,3,2,3,2,3,4,5,3,3,supervisor dev plans comment here,future goals comment here,employee comments here'),
('2', '2', '1', '1', '4,5,4,3,2,4,5,2,1,3,5,4,5,4,3,2,5,4,3,4,4,5,2,1,4,3,2,4,2,5,2,1,3,4,2,3,1,3,2,5,4,2,3,2,4,5,2,3,2,1,4,2,5,2,3,2,1,1,2,3,5,4,2,3,2,3,2,3,4,5,3,3,employee dev plans comment here,future goals comment here,employee comments here');

--- INSERT h2o_categories table
INSERT INTO `h2o_categories`(`id`,`name`)
VALUES
('1', 'Communications'),
('2', 'Cooperation'),
('3', 'Cost Consciousness'),
('4', 'Dependability'),
('5', 'Initiative'),
('6', 'Job Knowledge'),
('7', 'Judgement'),
('8', 'Planning & Organization'),
('9', 'Problem Solving'),
('10', 'Quality'),
('11', 'Quantity'),
('12', 'Use of Technology'),
('13', 'Development Plans'),
('14', 'Future Goals'),
('15', 'Employee Comments');

--- INSERT h2o_questions
INSERT INTO `h2o_questions` (`id`,`category_id`,`text`)
VALUES
('1', '1', 'Expresses ideas and thoughts verbally'),
('2', '1', 'Expresses ideas and thoughts in written form'),
('3', '1', 'Exhibits good listening and comprehension'),
('4', '1', 'Keeps others adequately informed'),
('5', '1', 'Uses appropriate communication methods'),
('6', '2', 'Establishes and maintians effective relations');

--- INSERT h2o_survey_type
INSERT INTO `h2o_survey_type` (`id`,`type`)
VALUES
('1', 'Supervisor'),
('2', 'Employee');

--- INSERT h2o_users table
INSERT INTO `h2o_users` (`id`, `username`, `key`, `role`) VALUES
('1', 'test', '5adafb7d60ef4c9d0d83b973d309b4dff1e0a5474badb1c16362f2002745839f6e407a2a69daaa63e4a41a74bbf490e03bc367a22030fdbe9474fa13d81f4396', 'user'),
('2', 'admin', 'dac8913013635c906b1e64bdb6919a1717c6f072dac6721989a333541278737f189e1f2dcfab6640bdebad1ad7d7ec2fbc7138974192b6374a1b48d5bc26de28', 'admin');
