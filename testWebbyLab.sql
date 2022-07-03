CREATE TABLE IF NOT EXISTS `movie`
(
    `id`     INT  NOT NULL AUTO_INCREMENT,
    `title`  TEXT NULL DEFAULT NULL,
    `year`   TEXT NULL DEFAULT NULL,
    `format` TEXT NULL DEFAULT NULL,
    `actors` TEXT NULL DEFAULT NULL,
    PRIMARY KEY (`id`)
)
    ENGINE = InnoDB
    AUTO_INCREMENT = 0
    DEFAULT CHARACTER SET = utf8
    COLLATE = utf8_bin;


CREATE TABLE IF NOT EXISTS `users`
(
    `id`       INT  NOT NULL AUTO_INCREMENT,
    `username` TEXT NULL DEFAULT NULL,
    `password` TEXT NULL DEFAULT NULL,
    `name`     TEXT NULL DEFAULT NULL,
    PRIMARY KEY (`id`)
)
    ENGINE = InnoDB
    AUTO_INCREMENT = 0
    DEFAULT CHARACTER SET = utf8
    COLLATE = utf8_bin;



INSERT INTO `movie` (`title`, `format`, `actors`, `year`)
VALUES ('Harry Potter and the Cursed Child', 'DVD', 'Emily Dale,Terence Bayler,Eleanor Columbus', '2001');

INSERT INTO `users` (`username`, `name`, `password`)
VALUES ('admin', 'Admin', '21232f297a57a5a743894a0e4a801fc3')
