CREATE DATABASE yota_db;
USE yota_db;

CREATE TABLE activities(
        `id` int(11) not null auto_increment primary key,
        `approved` boolean not null default false;
        `specialCall` varchar(50) not null,
        `fromTime` datetime not null,
        `toTime` datetime not null,
        `frequencies` varchar(255) not null,
        `modes` varchar(255) not null,
        `operatorCall` varchar(50) not null,
        `operatorName` varchar(50) not null,
        `operatorEmail` varchar(100) not null,
        `operatorPhone` varchar(50) not null
        `qso` int not null default 0;
      ) charset=utf8;

CREATE TABLE admins(
        `id` int(11) not null auto_increment primary key,
        `email` varchar(100) not null,
        `password` varchar(255) not null
      ) charset=utf8;

GRANT ALL PRIVILEGES ON `yota_db`.* TO `yota_admin`@`localhost` IDENTIFIED BY 'quaequaquagh6ahwoh6Chahx1EiFooGh';
GRANT SELECT ON `yota_db`.* TO `yota_user`@`localhost` IDENTIFIED BY 'gahdeer6shai9hogai2sai4quuaj1eVu';
GRANT INSERT ON `yota_db`.`activities` TO `yota_requester`@`localhost` IDENTIFIED BY 'oon5iraeghaidoShi5sheefie2uuz3gu';
