create database yetiDB
  default CHARACTER SET utf8
  default collate utf8_general_ci;

use yetiDB;

create table categories (
  id INT auto_increment primary key ,
  title CHAR(64) not null unique ,
  code  CHAR(64) not null unique
) ;

create table users (
  id INT auto_increment primary key ,
  dt_add DATETIME,
  email CHAR(128) not null unique ,
  name CHAR(128) not null unique ,
  password CHAR(64) not null ,
  image VARCHAR(2083),
  contact VARCHAR(2083)  not null,
  INDEX name_index (name),
  INDEX email_index(email)
) ;

create table lots (
  id INT auto_increment primary key ,
  dt_add TIMESTAMP  default current_timestamp,
  title CHAR(64) not null ,
  description TEXT not null ,
  image VARCHAR(2083) not null ,
  start_price INT not null ,
  end_date DATE not null ,
  step SMALLINT not null,
  author_id INT unique not null , #user_id
  winner_id INT unique not null ,
  category_id INT unique not null,
  FOREIGN KEY fk_author (author_id) REFERENCES users(id),
  FOREIGN KEY fk_winner (winner_id) REFERENCES users(id),
  FOREIGN KEY fk_category (category_id) REFERENCES categories(id)
) ;

create table rates (
  id INT auto_increment primary key ,
  dt_add DATETIME not null,
  user_id INT not null ,
  lot_id INT not null,
  FOREIGN KEY fk_user (user_id) REFERENCES users(id),
  FOREIGN KEY fk_lot (lot_id) REFERENCES lots(id)
) ;
