CREATE TABLE user(
                     id_user  integer PRIMARY KEY AUTOINCREMENT unique,
                     name varchar (50),
                     email varchar(50),
                     password varchar(40)
);

CREATE TABLE blog(
                     id_blog integer PRIMARY KEY AUTOINCREMENT unique ,
                     title varchar(42) not null ,
                     image text,
                     content varchar not null ,
                     created_at datetime,
                     user_id integer not null,
                     FOREIGN KEY (user_id) references user(id_user)
);

ALTER TABLE user
    ADD COLUMN admin_role INTEGER DEFAULT 0;
