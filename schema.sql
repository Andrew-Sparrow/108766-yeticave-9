create database yetiDB
  default CHARACTER SET utf8
  default collate utf8_general_ci;

use yetiDB;

create table categories (
  category_id INT auto_increment primary key ,
  title CHAR(64) not null ,
  code  CHAR(64) not null unique,
  unique INDEX category_index(category_id)
) ;

create table lots (
  lot_id INT auto_increment primary key ,
  dt_add TIMESTAMP  default current_timestamp,
  title CHAR(64) not null ,
  image TEXT not null ,
  start_price INT not null ,
  end_date DATE not null ,
  step SMALLINT not null,
  author_id INT unique not null ,
  winner_id INT unique not null ,
  category_id INT unique not null ,
  INDEX title_index (title),
  unique INDEX author_index (author_id),
  unique INDEX winner_index (winner_id),
  unique INDEX category_index (category_id)
) ;

create table rates (
  rate_id INT auto_increment primary key ,
  dt_add DATETIME not null,
  user_id INT ,
  lot_id INT,
  unique INDEX user_index (user_id),
  unique INDEX lot_index (lot_id)
) ;

create table users (
  user_id INT auto_increment primary key ,
  dt_add TIMESTAMP  default current_timestamp,
  email CHAR(128) not null unique ,
  name CHAR(128) not null ,
  password CHAR(64) not null ,
  image TEXT,
  contact TEXT  not null,
  lot_id INT,
  rate_id INT,
  INDEX name_index (name),
  unique INDEX email_index (email),
  unique INDEX user_index (user_id),
  unique INDEX lot_index (lot_id),
  unique INDEX rate_index (rate_id),
  FOREIGN KEY (lot_id) REFERENCES lots(lot_id),
  FOREIGN KEY (rate_id) REFERENCES rates(rate_id)
) ;

alter table lots ADD
  FOREIGN KEY fk_author (author_id) REFERENCES users(user_id);
alter table lots ADD
  FOREIGN KEY fk_winner (winner_id) REFERENCES users(user_id);
alter table lots ADD
  FOREIGN KEY fk_category (category_id) REFERENCES categories(category_id);

alter table rates add
  FOREIGN KEY fk_user (user_id) REFERENCES users(user_id);
alter table rates add
  FOREIGN KEY fk_lot (lot_id) REFERENCES lots(lot_id);

