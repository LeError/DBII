-- -----------------------------------------------------
-- Author:  Robin Herder
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `survey_site`;
CREATE SCHEMA IF NOT EXISTS `survey_site` DEFAULT CHARACTER SET utf8;
USE `survey_site`;

-- -----------------------------------------------------
-- Author: Moritz Bürkle
-- -----------------------------------------------------
DROP TABLE IF EXISTS `survey_site`.`user`;
CREATE TABLE `survey_site`.`user`
(
    `username` VARCHAR(50) PRIMARY KEY,
    `password` VARCHAR(50) NOT NULL
);

-- -----------------------------------------------------
-- Author: Moritz Bürkle
-- -----------------------------------------------------
DROP TABLE IF EXISTS `survey_site`.`survey`;
CREATE TABLE `survey_site`.`survey`
(
    `title_short` VARCHAR(10) PRIMARY KEY,
    `title`       VARCHAR(100) NOT NULL UNIQUE,
    `username`    VARCHAR(50),
    CONSTRAINT `cstr_survey_user`
        FOREIGN KEY (`username`)
            REFERENCES `survey_site`.`user` (`username`)
            ON UPDATE CASCADE
            ON DELETE CASCADE
);

-- -----------------------------------------------------
-- Author: Moritz Bürkle
-- -----------------------------------------------------
DROP TABLE IF EXISTS `survey_site`.`question`;
CREATE TABLE `survey_site`.`question`
(
    `id`          INT AUTO_INCREMENT PRIMARY KEY,
    `question`    TEXT(500) NOT NULL,
    `title_short` VARCHAR(10),
    CONSTRAINT `cstr_question_survey`
        FOREIGN KEY (`title_short`)
            REFERENCES `survey_site`.`survey` (`title_short`)
            ON UPDATE CASCADE
            ON DELETE CASCADE
);


-- -----------------------------------------------------
-- Author: Leonie Rauch
-- -----------------------------------------------------
DROP TABLE IF EXISTS `survey_site`.`survey_user_group`;
CREATE TABLE `survey_site`.`survey_user_group`
(
    `course_short` VARCHAR(8) PRIMARY KEY,
    `course`       VARCHAR(50) NOT NULL
);

-- -----------------------------------------------------
-- Author: Robin Herder
-- -----------------------------------------------------
DROP TABLE IF EXISTS `survey_site`.`survey_user`;
CREATE TABLE IF NOT EXISTS `survey_site`.`survey_user`
(
    `matricule_number` CHAR(7) PRIMARY KEY,
    `username`         VARCHAR(50) NOT NULL,
    `course_short`     VARCHAR(8),
    CONSTRAINT `cstr_survey_user_survey_user_group`
        FOREIGN KEY (`course_short`)
            REFERENCES `survey_site`.`survey_user_group` (`course_short`)
            ON UPDATE CASCADE
            ON DELETE CASCADE
);

-- -----------------------------------------------------
-- Author: Leonie Rauch
-- -----------------------------------------------------
DROP TABLE IF EXISTS `survey_site`.`assigned`;
CREATE TABLE `survey_site`.`assigned`
(
    `title_short`  VARCHAR(10),
    `course_short` VARCHAR(8),
    PRIMARY KEY (`title_short`, `course_short`),
    CONSTRAINT `cstr_assigned_survey`
        FOREIGN KEY (`title_short`)
            REFERENCES `survey_site`.`survey` (`title_short`)
            ON UPDATE CASCADE
            ON DELETE CASCADE,
    CONSTRAINT `cstr_assigned_survey_user_group`
        FOREIGN KEY (`course_short`)
            REFERENCES `survey_site`.`survey_user_group` (`course_short`)
            ON UPDATE CASCADE
            ON DELETE CASCADE
);

-- -----------------------------------------------------
-- Author: Malik Press
-- -----------------------------------------------------
DROP TABLE IF EXISTS `survey_site`.`assigned_status`;
CREATE TABLE IF NOT EXISTS `survey_site`.`assigned_status`
(
    `title_short`      VARCHAR(10),
    `matricule_number` CHAR(7),
    PRIMARY KEY (`title_short`, `matricule_number`),
    CONSTRAINT `cstr_assigned_status_survey`
        FOREIGN KEY (`title_short`)
            REFERENCES `survey_site`.`survey` (`title_short`)
            ON UPDATE CASCADE
            ON DELETE CASCADE,
    CONSTRAINT `cstr_assigned_status_survey_user`
        FOREIGN KEY (`matricule_number`)
            REFERENCES `survey_site`.`survey_user` (`matricule_number`)
            ON UPDATE CASCADE
            ON DELETE CASCADE
);

-- -----------------------------------------------------
-- Author: Robin Herder
-- -----------------------------------------------------
DROP TABLE IF EXISTS `survey_site`.`assigned_comment`;
CREATE TABLE IF NOT EXISTS `survey_site`.`assigned_comment`
(
    `title_short`      VARCHAR(10),
    `matricule_number` CHAR(7),
    `comment`          VARCHAR(500) NOT NULL,
    PRIMARY KEY (`title_short`, `matricule_number`),
    CONSTRAINT `cstr_assigned_comment_survey`
        FOREIGN KEY (`title_short`)
            REFERENCES `survey_site`.`survey` (`title_short`)
            ON UPDATE CASCADE
            ON DELETE CASCADE,
    CONSTRAINT `cstr_assigned_comment_survey_user`
        FOREIGN KEY (`matricule_number`)
            REFERENCES `survey_site`.`survey_user` (`matricule_number`)
            ON UPDATE CASCADE
            ON DELETE CASCADE
);

-- -----------------------------------------------------
-- Author: Press Malik
-- -----------------------------------------------------
DROP TABLE IF EXISTS `survey_site`.`answer`;
CREATE TABLE IF NOT EXISTS `survey_site`.`answer`
(
    `id`               INT,
    `matricule_number` CHAR(7),
    `value`            INT NOT NULL,
    PRIMARY KEY (`id`, `matricule_number`),
    CONSTRAINT `cstr_answer_question`
        FOREIGN KEY (`id`)
            REFERENCES `survey_site`.`question` (`id`)
            ON UPDATE CASCADE
            ON DELETE CASCADE,
    CONSTRAINT `cstr_answer_survey_user`
        FOREIGN KEY (`matricule_number`)
            REFERENCES `survey_site`.`survey_user` (`matricule_number`)
            ON UPDATE CASCADE
            ON DELETE CASCADE
);
