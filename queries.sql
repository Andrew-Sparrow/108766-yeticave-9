use yetiDB;

# вставка категорий
insert into categories (title, code)
values ('Доски и лыжи', 'boards'),
       ('Крепления', 'attachment'),
       ('Ботинки', 'boots'),
       ('Одежда', 'clothing'),
       ('Инструменты', 'tools'),
       ('Разное', 'other');

# добавление пользователей
insert into users (email, name, password, image, contact)
values ('111@mail.com', 'Jon', '111', 'image', '+7-111-222-33-44'),
       ('222@mail.com', 'Emma', '222', 'image', '+7-222-222-33-44'),
       ('333@mail.com', 'Mia', '333', 'image', '+7-333-222-33-44'),
       ('444@mail.com', 'Ellie', '444', 'image', '+7-444-222-33-44'),
       ('555@mail.com', 'Genesis', '555', 'image', '+7-555-222-33-44');

# добавление лотов
insert lots (title, description, image, start_price, end_date, step, author_id, category_id)
values ('2014 Rossignol District Snowboard',
        'Легкий маневренный сноуборд, готовый дать жару в любом парке, растопив снег мощным щелчком и четкими дугами. Стекловолокно Bi-Ax, уложенное в двух направлениях, наделяет этот снаряд отличной гибкостью и отзывчивостью, а симметричная геометрия в сочетании с классическим прогибом кэмбер позволит уверенно держать высокие скорости. А если к концу катального дня сил совсем не останется, просто посмотрите на Вашу доску и улыбнитесь, крутая графика от Шона Кливера еще никого не оставляла равнодушным.',
        'image', 10999, '2019-05-01', 100, 1, 1),
       ('DC Ply Mens 2016/2017 Snowboard',
        'Легкий маневренный сноуборд, готовый дать жару в любом парке, растопив снег мощным щелчком и четкими дугами. Стекловолокно Bi-Ax, уложенное в двух направлениях, наделяет этот снаряд отличной гибкостью и отзывчивостью, а симметричная геометрия в сочетании с классическим прогибом кэмбер позволит уверенно держать высокие скорости. А если к концу катального дня сил совсем не останется, просто посмотрите на Вашу доску и улыбнитесь, крутая графика от Шона Кливера еще никого не оставляла равнодушным.',
        'image', 159999, '2019-05-01', 100, 1, 1),
       ('Крепления Union Contact Pro 2015 года размер L/XL',
        'Легкий маневренный сноуборд, готовый дать жару в любом парке, растопив снег мощным щелчком и четкими дугами. Стекловолокно Bi-Ax, уложенное в двух направлениях, наделяет этот снаряд отличной гибкостью и отзывчивостью, а симметричная геометрия в сочетании с классическим прогибом кэмбер позволит уверенно держать высокие скорости. А если к концу катального дня сил совсем не останется, просто посмотрите на Вашу доску и улыбнитесь, крутая графика от Шона Кливера еще никого не оставляла равнодушным.',
        'image', 8000, '2019-05-01', 100, 1, 2),
       ('супер Ботинки для сноуборда DC Mutiny Charocal',
        'Легкий маневренный сноуборд, готовый дать жару в любом парке, растопив снег мощным щелчком и четкими дугами. Стекловолокно Bi-Ax, уложенное в двух направлениях, наделяет этот снаряд отличной гибкостью и отзывчивостью, а симметричная геометрия в сочетании с классическим прогибом кэмбер позволит уверенно держать высокие скорости. А если к концу катального дня сил совсем не останется, просто посмотрите на Вашу доску и улыбнитесь, крутая графика от Шона Кливера еще никого не оставляла равнодушным.',
        'image', 10999, '2019-05-01', 100, 1, 3);

# добавление лотов с победителями
insert lots (title, description, image, start_price, end_date, step, author_id, winner_id, category_id)
values ('Куртка для сноуборда DC Mutiny Charocal',
        'Легкий маневренный сноуборд, готовый дать жару в любом парке, растопив снег мощным щелчком и четкими дугами. Стекловолокно Bi-Ax, уложенное в двух направлениях, наделяет этот снаряд отличной гибкостью и отзывчивостью, а симметричная геометрия в сочетании с классическим прогибом кэмбер позволит уверенно держать высокие скорости. А если к концу катального дня сил совсем не останется, просто посмотрите на Вашу доску и улыбнитесь, крутая графика от Шона Кливера еще никого не оставляла равнодушным.',
        'image', 7500, '2019-05-01', 10, 1, 5, 4),
       ('Маска Oakley Canopy',
        'Легкий маневренный сноуборд, готовый дать жару в любом парке, растопив снег мощным щелчком и четкими дугами. Стекловолокно Bi-Ax, уложенное в двух направлениях, наделяет этот снаряд отличной гибкостью и отзывчивостью, а симметричная геометрия в сочетании с классическим прогибом кэмбер позволит уверенно держать высокие скорости. А если к концу катального дня сил совсем не останется, просто посмотрите на Вашу доску и улыбнитесь, крутая графика от Шона Кливера еще никого не оставляла равнодушным.',
        'image', 5400, '2019-05-01', 10, 1, 5, 5);

# добавление ставок
insert rates (rate, user_id, lot_id)
values (12000, 2, 1),
       (8500, 2, 3),
       (15000, 3, 1),
       (16000, 4, 1);


#получить все категории;
select title from categories ;

/*получить самые новые, открытые лоты. Каждый лот должен включать название,
 стартовую цену, ссылку на изображение, цену, название категории;*/
SELECT lots.title as lot_title, any_value(start_price) as start_price , any_value(image) as link, MAX(rate) as max_rate, any_value(categories.title) AS category
FROM lots
JOIN categories ON lots.category_id = categories.id
left JOIN rates ON lots.category_id = rates.lot_id
WHERE lots.winner_id IS NULL AND lots.dt_add >= CURDATE()
GROUP BY lots.title
LIMIT 4;

#показать лот по его id. Получите также название категории, к которой принадлежит лот;
SELECT lots.id AS lot_id , categories.title AS category
FROM lots
JOIN categories ON categories.id = lots.category_id;

#обновить название лота по его идентификатору;
update lots set title = 'Ботинки для сноуборда DC Mutiny Charocal' where id = 4;

#получить список самых свежих ставок для лота по его идентификатору.
select rates.id AS rate_id, rates.dt_add AS data_rate, rate AS rate  #добавил поле с датой, что бы видно было время ставки
FROM rates
WHERE lot_id = 1 AND rates.dt_add > '2019-04-25 23:40:00'
order by rates.dt_add desc
;

