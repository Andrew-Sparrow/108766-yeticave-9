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
  user_id INT auto_increment primary key ,
  dt_add TIMESTAMP  default current_timestamp,
  email CHAR(128) not null unique ,
  name CHAR(128) not null ,
  password CHAR(64) not null ,
  image TEXT,
  contact TEXT  not null,
  INDEX name_index (name),
  unique INDEX email_index (email)
) ;

create table lots (
  id INT auto_increment primary key ,
  dt_add TIMESTAMP  default current_timestamp,
  title CHAR(64) not null ,
  description TEXT not null ,
  image TEXT not null ,
  start_price INT not null ,
  end_date DATE not null ,
  step SMALLINT not null,
  author_id INT unique not null , #user_id
  winner_id INT unique not null ,
  category_id INT unique not null,
  FOREIGN KEY fk_author (author_id) REFERENCES users(user_id),
  FOREIGN KEY fk_winner (winner_id) REFERENCES users(user_id),
  FOREIGN KEY fk_category (category_id) REFERENCES categories(id)
) ;

create table rates (
  id INT auto_increment primary key ,
  dt_add DATETIME not null,
  user_id INT ,
  lot_id INT,
  unique INDEX user_index (user_id),
  unique INDEX lot_index (lot_id),
  FOREIGN KEY fk_user (user_id) REFERENCES users(user_id),
  FOREIGN KEY fk_lot (lot_id) REFERENCES lots(id)
) ;
