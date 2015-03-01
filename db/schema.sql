-- Création de la table des utilisateurs
DROP TABLE IF EXISTS t_user;
CREATE TABLE t_user (
    usr_id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
    usr_name VARCHAR(50) NOT NULL,
    usr_password VARCHAR(88) NOT NULL,
    usr_salt VARCHAR(23) NOT NULL,
    usr_role VARCHAR(50) NOT NULL,
    PRIMARY KEY(usr_id)
)
ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci;

-- Création de la table des articles
DROP TABLE IF EXISTS t_article;
CREATE TABLE t_article (
    art_id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
    art_title VARCHAR(100) NOT NULL,
    art_content TEXT NOT NULL,
    PRIMARY KEY(art_id)
)
ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci;

-- Création de la table des commentaires
DROP TABLE IF EXISTS t_comment;
CREATE TABLE t_comment (
    com_id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
    com_content VARCHAR(500) NOT NULL,
    art_id INTEGER UNSIGNED NOT NULL,
    usr_id INTEGER UNSIGNED NOT NULL,
    PRIMARY KEY(com_id),
    FOREIGN KEY(art_id) REFERENCES t_article(art_id),
    FOREIGN KEY(usr_id) REFERENCES t_user(usr_id)
)
ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci;