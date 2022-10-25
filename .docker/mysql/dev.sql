CREATE DATABASE IF NOT EXISTS ift_test;
CREATE DATABASE IF NOT EXISTS ift_support;

USE ift_support;

drop table if exists `cache`;
create table `cache`
(
    `id`  varchar(128) not null,
    `expire` integer,
    `data`   LONGBLOB,
    primary key (`id`)
) engine InnoDB;

drop table if exists `log`;
create table `log`
(
   `id`          bigint(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
   `level`       integer,
   `category`    varchar(255),
   `log_time`    double,
   `prefix`      text,
   `message`     text,
   key `idx_log_level` (`level`),
   key `idx_log_category` (`category`)
) engine InnoDB;