create table users
(
    id       uuid                   default uuid() not null
        primary key,
    login    varchar(15)                           not null,
    role     enum ('admin', 'user') default 'user' not null,
    password varchar(255)                          not null,
    email    varchar(255)                          not null,
    constraint users_id_IDX
        unique (id),
    constraint users_unique
        unique (login),
    constraint users_unique_1
        unique (email)
);

