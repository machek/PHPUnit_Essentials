CREATE TABLE `users` (
  `userid` INT NOT NULL AUTO_INCREMENT,
  `firstname` VARCHAR(45) NULL,
  `lastname` VARCHAR(45) NULL,
  `email` VARCHAR(45) NULL,
  `password` VARCHAR(45) NULL,
  `salt` VARCHAR(45) NULL,
  PRIMARY KEY (`userid`));
