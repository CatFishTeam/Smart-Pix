-- Created by Vertabelo (http://vertabelo.com)
-- Last modification date: 2017-05-02 15:15:54.595

-- tables
-- Table: album
CREATE TABLE album (
    id int NOT NULL AUTO_INCREMENT,
    users_id int NOT NULL,
    title varchar(100) NOT NULL,
    description text NOT NULL,
    is_presentation int NOT NULL,
    is_deleted int NOT NULL,
    created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT album_pk PRIMARY KEY (id)
);

-- Table: cart
CREATE TABLE cart (
    id int NOT NULL AUTO_INCREMENT,
    users_id int NOT NULL,
    total int NOT NULL,
    is_confirmed int NOT NULL,
    created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT cart_pk PRIMARY KEY (id)
);

-- Table: comment
CREATE TABLE comment (
    id int NOT NULL AUTO_INCREMENT,
    picture_id int NOT NULL,
    users_id int NOT NULL,
    content text NOT NULL,
    created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT comment_pk PRIMARY KEY (id)
);

-- Table: email
CREATE TABLE email (
    id int NOT NULL AUTO_INCREMENT,
    subject text NOT NULL,
    content text NOT NULL,
    created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    sent_on timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT email_pk PRIMARY KEY (id)
);

-- Table: picture
CREATE TABLE picture (
    id int NOT NULL AUTO_INCREMENT,
    albums_id int NOT NULL,
    users_id int NOT NULL,
    title varchar(100) NOT NULL,
    description text NOT NULL,
    url text NOT NULL,
    is_visible int NOT NULL,
    created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT picture_pk PRIMARY KEY (id)
);

-- Table: picture_cart
CREATE TABLE picture_cart (
    picture_id int NOT NULL,
    carts_id int NOT NULL,
    CONSTRAINT picture_cart_pk PRIMARY KEY (picture_id,carts_id)
);

-- Table: stat
CREATE TABLE stat (
    id int NOT NULL AUTO_INCREMENT,
    user_id int NULL,
    picture_id int NULL,
    album_id int NULL,
    count int NOT NULL,
    CONSTRAINT stat_pk PRIMARY KEY (id)
);

-- Table: tag
CREATE TABLE tag (
    id int NOT NULL AUTO_INCREMENT,
    title varchar(100) NOT NULL,
    CONSTRAINT tag_pk PRIMARY KEY (id)
);

-- Table: tag_album
CREATE TABLE tag_album (
    tag_id int NOT NULL,
    album_id int NOT NULL,
    CONSTRAINT tag_album_pk PRIMARY KEY (tag_id,album_id)
);

-- Table: tag_picture
CREATE TABLE tag_picture (
    tag_id int NOT NULL,
    picture_id int NOT NULL,
    CONSTRAINT tag_picture_pk PRIMARY KEY (tag_id,picture_id)
);

-- Table: template
CREATE TABLE template (
    id int NOT NULL AUTO_INCREMENT,
    albums_id int NOT NULL,
    name varchar(60) NOT NULL,
    disposition json NOT NULL,
    background int NOT NULL,
    CONSTRAINT template_pk PRIMARY KEY (id)
);

-- Table: user
CREATE TABLE user (
    id int NOT NULL AUTO_INCREMENT,
    email varchar(60) NOT NULL,
    firstname varchar(60) NOT NULL,
    lastname varchar(60) NOT NULL,
    username varchar(20) NOT NULL,
    password varchar(60) NOT NULL,
    avatar text NOT NULL,
    permission int NOT NULL,
    is_deleted int NOT NULL,
    created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT user_pk PRIMARY KEY (id)
);

-- foreign keys
-- Reference: Albums_Users (table: album)
ALTER TABLE album ADD CONSTRAINT Albums_Users FOREIGN KEY Albums_Users (users_id)
    REFERENCES user (id);

-- Reference: Comments_Pictures (table: comment)
ALTER TABLE comment ADD CONSTRAINT Comments_Pictures FOREIGN KEY Comments_Pictures (picture_id)
    REFERENCES picture (id);

-- Reference: Pictures_Albums (table: picture)
ALTER TABLE picture ADD CONSTRAINT Pictures_Albums FOREIGN KEY Pictures_Albums (albums_id)
    REFERENCES album (id);

-- Reference: Pictures_Cart_Pictures (table: picture_cart)
ALTER TABLE picture_cart ADD CONSTRAINT Pictures_Cart_Pictures FOREIGN KEY Pictures_Cart_Pictures (picture_id)
    REFERENCES picture (id);

-- Reference: Pictures_Users (table: picture)
ALTER TABLE picture ADD CONSTRAINT Pictures_Users FOREIGN KEY Pictures_Users (users_id)
    REFERENCES user (id);

-- Reference: Stats_Albums (table: stat)
ALTER TABLE stat ADD CONSTRAINT Stats_Albums FOREIGN KEY Stats_Albums (album_id)
    REFERENCES album (id);

-- Reference: Stats_Pictures (table: stat)
ALTER TABLE stat ADD CONSTRAINT Stats_Pictures FOREIGN KEY Stats_Pictures (picture_id)
    REFERENCES picture (id);

-- Reference: Stats_Users (table: stat)
ALTER TABLE stat ADD CONSTRAINT Stats_Users FOREIGN KEY Stats_Users (user_id)
    REFERENCES user (id);

-- Reference: Tags_Albums_Albums (table: tag_album)
ALTER TABLE tag_album ADD CONSTRAINT Tags_Albums_Albums FOREIGN KEY Tags_Albums_Albums (album_id)
    REFERENCES album (id);

-- Reference: Tags_Albums_Tags (table: tag_album)
ALTER TABLE tag_album ADD CONSTRAINT Tags_Albums_Tags FOREIGN KEY Tags_Albums_Tags (tag_id)
    REFERENCES tag (id);

-- Reference: Tags_Pictures_Pictures (table: tag_picture)
ALTER TABLE tag_picture ADD CONSTRAINT Tags_Pictures_Pictures FOREIGN KEY Tags_Pictures_Pictures (picture_id)
    REFERENCES picture (id);

-- Reference: Tags_Pictures_Tags (table: tag_picture)
ALTER TABLE tag_picture ADD CONSTRAINT Tags_Pictures_Tags FOREIGN KEY Tags_Pictures_Tags (tag_id)
    REFERENCES tag (id);

-- Reference: Template_Albums (table: template)
ALTER TABLE template ADD CONSTRAINT Template_Albums FOREIGN KEY Template_Albums (albums_id)
    REFERENCES album (id);

-- Reference: carts_users (table: cart)
ALTER TABLE cart ADD CONSTRAINT carts_users FOREIGN KEY carts_users (users_id)
    REFERENCES user (id);

-- Reference: comments_users (table: comment)
ALTER TABLE comment ADD CONSTRAINT comments_users FOREIGN KEY comments_users (users_id)
    REFERENCES user (id);

-- Reference: pictures_carts_carts (table: picture_cart)
ALTER TABLE picture_cart ADD CONSTRAINT pictures_carts_carts FOREIGN KEY pictures_carts_carts (carts_id)
    REFERENCES cart (id);

-- End of file.

