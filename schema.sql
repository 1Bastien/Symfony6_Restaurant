CREATE TABLE booking
(
    booking_id             int(11)  NOT NULL PRIMARY KEY AUTO_INCREMENT,
    customer_id            int(11)  DEFAULT NULL,
    restaurant_id          int(11)  NOT NULL,
    booking_datetime       datetime NOT NULL,
    nb_guests              int(11)  NOT NULL,
    last_minute_first_name varchar(35)  DEFAULT NULL,
    last_minute_last_name  varchar(35)  DEFAULT NULL,
    last_minute_email      varchar(180) DEFAULT NULL,

    CONSTRAINT fk_booking_customer_id FOREIGN KEY (customer_id) REFERENCES customer (customer_id),
    CONSTRAINT fk_booking_restaurant_id FOREIGN KEY (restaurant_id) REFERENCES restaurant (restaurant_id),

    CONSTRAINT ck_booking_nb_guests CHECK (nb_guests > 0)
);

CREATE TABLE customer
(
    customer_id        int(11)      NOT NULL PRIMARY KEY AUTO_INCREMENT,
    email              varchar(180) NOT NULL UNIQUE KEY,
    roles              enum ('ROLE_ADMIN', 'ROLE_USER') DEFAULT 'ROLE_USER',
    pass               varchar(255) NOT NULL,
    first_name         varchar(35)  NOT NULL,
    last_name          varchar(35)  NOT NULL,
    favorite_nb_guests int(11)      DEFAULT NULL,

    CONSTRAINT ck_customer_nb_guests CHECK (favorite_nb_guests > 0)
);

CREATE TABLE restaurant
(
    restaurant_id    int(11)      NOT NULL PRIMARY KEY AUTO_INCREMENT,
    restaurant_name  varchar(255) NOT NULL,
    seating_capacity tinyint      NOT NULL,
    opening_time     longtext     DEFAULT NULL
);

CREATE TABLE menu
(
    menu_id          int(11)        NOT NULL PRIMARY KEY AUTO_INCREMENT,
    menu_name        varchar(255)   NOT NULL,
    menu_description longtext       NOT NULL,
    image_name       varchar(255)   DEFAULT NULL,
    updated_at       datetime       DEFAULT NULL,
    price            decimal(10, 2) NOT NULL,
    available        boolean        NOT NULL
);