Create DATABASE chilidataweb;
USE chilidataweb:

CREATE TABLE users (
  id INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
  username VARCHAR(16) NOT NULL unique,
  password VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL unique,
  nome VARCHAR(50) NOT NULL,
  cognome VARCHAR(50) NOT NULL,
  gender ENUM('uomo','donna','preferisco non specificare') NOT NULL

  
);

CREATE TABLE slider_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    type ENUM('desktop', 'smart') NOT NULL,
    url VARCHAR(255) NOT NULL
);


INSERT INTO slider_images (type, url) VALUES
('desktop', './slide/slide1.jpg'),
('desktop', './slide/slide2.jpg'),
('desktop', './slide/slide3.jpg'),
('smart', './slide/slide8.jpg'),
('smart', './slide/slide9.jpg'),
('smart', './slide/slide10.jpg');


CREATE TABLE wishlist (
    id integer primary key auto_increment,
    user_id integer not null,
    foreign key (user_id) references users(id),
    film_id varchar(255),
    content json
);