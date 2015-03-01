-- Création de la base de données
CREATE DATABASE IF NOT EXISTS microcms CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE microcms;

-- Création de l'utilisateur et attribution des droits
GRANT ALL PRIVILEGES ON microcms.* TO 'microcms_user'@'localhost' IDENTIFIED BY 'microcms_pass';
FLUSH PRIVILEGES;
