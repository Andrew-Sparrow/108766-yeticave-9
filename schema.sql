create database yetiDB
  default CHARACTER SET utf8
  default collate utf8_general_ci;

use yetiDB;

create table categories (
  id          INT auto_increment primary key,
  title       CHAR(64) not null unique,
  symbol_code CHAR(64) not null unique
);

create table users (
  id       INT auto_increment primary key,
  dt_add   DATETIME default CURRENT_TIMESTAMP,
  email    CHAR(128)     not null unique,
  name     CHAR(128)     not null unique,
  password CHAR(64)      not null,
  avatar   VARCHAR(2083),
  contact  VARCHAR(2083) not null,
  INDEX name_index (name),
  INDEX email_index (email)
);

create table lots (
  id          INT auto_increment primary key,
  dt_add      DATETIME default CURRENT_TIMESTAMP,
  title       CHAR(64)      not null,
  description TEXT          not null,
  img_src     VARCHAR(2083) not null,
  start_price INT           not null,
  end_date    DATE          not null,
  step        SMALLINT      not null,
  author_id   INT           not null, #user_id
  winner_id   INT,
  category_id INT           not null,
  FOREIGN KEY fk_author (author_id) REFERENCES users (id),
  FOREIGN KEY fk_winner (winner_id) REFERENCES users (id),
  FOREIGN KEY fk_category (category_id) REFERENCES categories (id)
);

create table rates (
  id      INT auto_increment primary key,
  dt_add  datetime default CURRENT_TIMESTAMP,
  rate    INT not null,
  user_id INT not null,
  lot_id  INT not null,
  UNIQUE (lot_id, rate),
  FOREIGN KEY fk_user (user_id) REFERENCES users (id),
  FOREIGN KEY fk_lot (lot_id) REFERENCES lots (id)
);

CREATE FULLTEXT INDEX lots_search ON lots (title, description);