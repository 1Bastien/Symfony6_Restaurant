CREATE TABLE booking (
  id int(11) NOT NULL PRIMARY KEY,
  customer_id int(11) DEFAULT NULL,
  restaurant_id int(11) NOT NULL,
  `date` datetime NOT NULL,
  nb_guests int(11) NOT NULL,
  first_name varchar(255) DEFAULT NULL,
  last_name varchar(255) DEFAULT NULL,
  mail varchar(255) DEFAULT NULL
);

CREATE TABLE customer (
  id int(11) NOT NULL PRIMARY KEY,
  email varchar(180) NOT NULL UNIQUE KEY,
  roles json NOT NULL,
  `password` varchar(255) NOT NULL,
  first_name varchar(255) NOT NULL,
  last_name varchar(255) NOT NULL,
  nb_guests int(11) DEFAULT NULL
);

CREATE TABLE restaurant (
  id int(11) NOT NULL PRIMARY KEY,
  `name` varchar(255) NOT NULL,
  seating_capacity int(11) NOT NULL,
  opening_time longtext DEFAULT NULL
);

CREATE TABLE menu (
  id int(11) NOT NULL PRIMARY KEY,
  `name` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  image_name varchar(255) DEFAULT NULL,
  updated_at datetime DEFAULT NULL,
  price decimal(10,2) NOT NULL,
  available tinyint(1) NOT NULL
);

ALTER TABLE booking
  ADD KEY `IDX_1` (customer_id),
  ADD KEY `IDX_2` (restaurant_id),
  ADD CONSTRAINT `FK_1` FOREIGN KEY (customer_id) REFERENCES customer (id),
  ADD CONSTRAINT `FK_2` FOREIGN KEY (restaurant_id) REFERENCES restaurant (id);