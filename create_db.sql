drop database if exists JobBoard;
create database JobBoard;

create user if not exists 'admin'@'localhost' identified by 'bddprojet';
create user if not exists 'user'@'localhost' identified by 'bddprojet';
create user if not exists 'visitor'@'localhost' identified by 'bddprojet';


GRANT ALL ON JobBoard.* to 'admin'@'localhost';
grant select, delete on JobBoard.* to 'user'@'localhost';
grant select on JobBoard.* to 'visitor'@'localhost';

use JobBoard;

drop table if exists peoples_advertissements;
drop table if exists advertisements;
drop table if exists companies;
drop table if exists peoples;

create table companies(
    `id` INT AUTO_INCREMENT NOT NULL,
    `name` VARCHAR(250) NOT NULL,
    `description` VARCHAR(1000) NOT NULL,
    PRIMARY KEY(`id`)
) ENGINE=INNODB;

create table advertisements(
    `id` INT AUTO_INCREMENT NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `message` VARCHAR(1000) NOT NULL,
    `date_debut` DATETIME NOT NULL,
    `type_de_poste` VARCHAR(255) NOT NULL,
    `ville` VARCHAR(255) NOT NULL,
    `salaire` DECIMAL(10, 2) NOT NULL,
    `id_companie` INT NOT NULL,
    PRIMARY KEY(`id`),
    FOREIGN KEY(`id`) REFERENCES companies(`id`)
) ENGINE=INNODB;

create table peoples(
    `id` INT AUTO_INCREMENT NOT NULL,
    `mail` VARCHAR(255) NOT NULL UNIQUE,
    `name` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `token` VARCHAR(255) NOT NULL UNIQUE,
    `prenom` VARCHAR(255),
    `telephone` VARCHAR(10),
    `admin` BOOLEAN DEFAULT FALSE,
    PRIMARY KEY(`id`)
) ENGINE=INNODB;

create table peoples_advertissements(
    `id_people` INT NOT NULL,
    `id_advertissements` INT NOT NULL,
    FOREIGN KEY(`id_people`) REFERENCES peoples(`id`),
    FOREIGN KEY(`id_advertissements`) REFERENCES advertisements(`id`),
    PRIMARY KEY(`id_people`, `id_advertissements`)
) ENGINE=INNODB;