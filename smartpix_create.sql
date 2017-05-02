-- Created by Vertabelo (http://vertabelo.com)
-- Last modification date: 2017-05-02 10:11:57.017

-- tables
-- Table: Albums
CREATE TABLE Albums (
    id int NOT NULL,
    title varchar(100) NOT NULL,
    is_presentation int NOT NULL,
    user_id int NOT NULL,
    is_deleted int NOT NULL,
    created_at timestamp NOT NULL,
    updated_at timestamp NOT NULL,
    Users_id int NOT NULL,
    CONSTRAINT Albums_pk PRIMARY KEY (id)
);

-- Table: Carts
CREATE TABLE Carts (
    id int NOT NULL,
    total int NOT NULL,
    id_user int NOT NULL,
    is_confirmed int NOT NULL,
    created_at timestamp NOT NULL,
    updated_at timestamp NOT NULL,
    CONSTRAINT Carts_pk PRIMARY KEY (id)
);

-- Table: Comments
CREATE TABLE Comments (
    id int NOT NULL,
    content text NOT NULL,
    user_id int NOT NULL,
    picture_id int NOT NULL,
    created_at timestamp NOT NULL,
    updated_at timestamp NOT NULL,
    CONSTRAINT Comments_pk PRIMARY KEY (id)
);

-- Table: Emails
CREATE TABLE Emails (
    id int NOT NULL,
    subject text NOT NULL,
    content text NOT NULL,
    created_at timestamp NOT NULL,
    updated_at timestamp NOT NULL,
    sent_on timestamp NOT NULL,
    CONSTRAINT Emails_pk PRIMARY KEY (id)
);

-- Table: Pictures
CREATE TABLE Pictures (
    id int NOT NULL,
    title varchar(100) NOT NULL,
    description text NOT NULL,
    album_id int NOT NULL,
    url text NOT NULL,
    is_visible int NOT NULL,
    created_at timestamp NOT NULL,
    updated_at timestamp NOT NULL,
    Users_id int NOT NULL,
    Albums_id int NOT NULL,
    CONSTRAINT Pictures_pk PRIMARY KEY (id)
);

-- Table: Pictures_Cart
CREATE TABLE Pictures_Cart (
    cart_id int NOT NULL,
    picture_id int NOT NULL
);

-- Table: Stats
CREATE TABLE Stats (
    id int NOT NULL,
    count int NOT NULL,
    user_id int NULL,
    picture_id int NULL,
    album_id int NULL,
    CONSTRAINT Stats_pk PRIMARY KEY (id)
);

-- Table: Tags
CREATE TABLE Tags (
    id int NOT NULL,
    title varchar(100) NOT NULL,
    CONSTRAINT Tags_pk PRIMARY KEY (id)
);

-- Table: Tags_Albums
CREATE TABLE Tags_Albums (
    tag_id int NOT NULL,
    album_id int NOT NULL
);

-- Table: Tags_Pictures
CREATE TABLE Tags_Pictures (
    tag_id int NOT NULL,
    picture_id int NOT NULL
);

-- Table: Template
CREATE TABLE Template (
    id int NOT NULL,
    name varchar(60) NOT NULL,
    disposition json NOT NULL,
    background int NOT NULL,
    albums_id int NOT NULL,
    CONSTRAINT Template_pk PRIMARY KEY (id)
);

-- Table: Users
CREATE TABLE Users (
    id int NOT NULL,
    email varchar(60) NOT NULL,
    firstname varchar(60) NOT NULL,
    lastname varchar(60) NOT NULL,
    username varchar(20) NOT NULL,
    password varchar(60) NOT NULL,
    avatar text NOT NULL,
    permission int NOT NULL,
    is_deleted int NOT NULL,
    created_at timestamp NOT NULL,
    updated_at timestamp NOT NULL,
    CONSTRAINT Users_pk PRIMARY KEY (id)
);

-- foreign keys
-- Reference: Albums_Users (table: Albums)
ALTER TABLE Albums ADD CONSTRAINT Albums_Users FOREIGN KEY Albums_Users (Users_id)
    REFERENCES Users (id);

-- Reference: Comments_Pictures (table: Comments)
ALTER TABLE Comments ADD CONSTRAINT Comments_Pictures FOREIGN KEY Comments_Pictures (picture_id)
    REFERENCES Pictures (id);

-- Reference: Comments_Users (table: Comments)
ALTER TABLE Comments ADD CONSTRAINT Comments_Users FOREIGN KEY Comments_Users (user_id)
    REFERENCES Users (id);

-- Reference: Pictures_Albums (table: Pictures)
ALTER TABLE Pictures ADD CONSTRAINT Pictures_Albums FOREIGN KEY Pictures_Albums (Albums_id)
    REFERENCES Albums (id);

-- Reference: Pictures_Cart_Carts (table: Pictures_Cart)
ALTER TABLE Pictures_Cart ADD CONSTRAINT Pictures_Cart_Carts FOREIGN KEY Pictures_Cart_Carts (cart_id)
    REFERENCES Carts (id);

-- Reference: Pictures_Cart_Pictures (table: Pictures_Cart)
ALTER TABLE Pictures_Cart ADD CONSTRAINT Pictures_Cart_Pictures FOREIGN KEY Pictures_Cart_Pictures (picture_id)
    REFERENCES Pictures (id);

-- Reference: Pictures_Users (table: Pictures)
ALTER TABLE Pictures ADD CONSTRAINT Pictures_Users FOREIGN KEY Pictures_Users (Users_id)
    REFERENCES Users (id);

-- Reference: Stats_Albums (table: Stats)
ALTER TABLE Stats ADD CONSTRAINT Stats_Albums FOREIGN KEY Stats_Albums (album_id)
    REFERENCES Albums (id);

-- Reference: Stats_Pictures (table: Stats)
ALTER TABLE Stats ADD CONSTRAINT Stats_Pictures FOREIGN KEY Stats_Pictures (picture_id)
    REFERENCES Pictures (id);

-- Reference: Stats_Users (table: Stats)
ALTER TABLE Stats ADD CONSTRAINT Stats_Users FOREIGN KEY Stats_Users (user_id)
    REFERENCES Users (id);

-- Reference: Tags_Albums_Albums (table: Tags_Albums)
ALTER TABLE Tags_Albums ADD CONSTRAINT Tags_Albums_Albums FOREIGN KEY Tags_Albums_Albums (album_id)
    REFERENCES Albums (id);

-- Reference: Tags_Albums_Tags (table: Tags_Albums)
ALTER TABLE Tags_Albums ADD CONSTRAINT Tags_Albums_Tags FOREIGN KEY Tags_Albums_Tags (tag_id)
    REFERENCES Tags (id);

-- Reference: Tags_Pictures_Pictures (table: Tags_Pictures)
ALTER TABLE Tags_Pictures ADD CONSTRAINT Tags_Pictures_Pictures FOREIGN KEY Tags_Pictures_Pictures (picture_id)
    REFERENCES Pictures (id);

-- Reference: Tags_Pictures_Tags (table: Tags_Pictures)
ALTER TABLE Tags_Pictures ADD CONSTRAINT Tags_Pictures_Tags FOREIGN KEY Tags_Pictures_Tags (tag_id)
    REFERENCES Tags (id);

-- Reference: Template_Albums (table: Template)
ALTER TABLE Template ADD CONSTRAINT Template_Albums FOREIGN KEY Template_Albums (albums_id)
    REFERENCES Albums (id);

-- End of file.

