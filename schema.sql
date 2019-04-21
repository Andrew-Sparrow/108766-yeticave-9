create database yetiDB
  default CHARACTER SET utf8
  default collate utf8_general_ci;

use yetiDB;

create table categories (
  id INT auto_increment primary key ,
  title CHAR(64) not null ,
  code  CHAR(64) not null unique
);

create table lots (
  id INT auto_increment primary key ,
  dt_add DATETIME  default current_date,
  title CHAR(64) not null ,
  image TEXT not null ,
  start_price INT not null ,
  end_date DATE not null ,
  step SMALLINT not null
);

create table rate (
  id INT auto_increment primary key ,
  dt_add DATETIME not null
);

create table user (
  id INT auto_increment primary key ,
  date_add DATETIME default current_date ,
  email CHAR(128) not null unique ,
  name CHAR(128) not null ,
  password CHAR(64) not null ,
  image TEXT,
  contact TEXT  not null
);



