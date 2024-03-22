CREATE TABLE users
(
    id              INT(10) PRIMARY KEY AUTO_INCREMENT,
    login           VARCHAR(30) UNIQUE,
    password_hashed VARCHAR(255)
);

INSERT INTO users (id, login, password_hashed)
VALUES ('1', 'test', '$2y$10$vZk144sPicCwukNMQNiuRuQY7vROOzUnJzA78yh09vZvw/5wQCtLK');


CREATE TABLE articles
(
    id      INT(10) PRIMARY KEY AUTO_INCREMENT,
    title   VARCHAR(60),
    content TEXT,
    user_id INT(10)
);

INSERT INTO articles (id, title, content, user_id)
VALUES ('1', 'Title 1', 'CONTENT CONTENT CONTENT CONTENT CONTENT CONTENT', '1'),
       ('2', 'Title 2', 'CONTENT CONTENT CONTENT CONTENT CONTENT CONTENT', '1'),
       ('3', 'Title 3', 'CONTENT CONTENT CONTENT CONTENT CONTENT CONTENT', '1'),
       ('4', 'Title 4', 'CONTENT CONTENT CONTENT CONTENT CONTENT CONTENT', '1'),
       ('5', 'Title 5', 'CONTENT CONTENT CONTENT CONTENT CONTENT CONTENT', '1'),
       ('6', 'Title 6', 'CONTENT CONTENT CONTENT CONTENT CONTENT CONTENT', '1');