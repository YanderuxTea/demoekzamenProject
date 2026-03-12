create table orders
(
    id            uuid                                                  default uuid()              not null
        primary key,
    course        varchar(100)                                                                      not null,
    user_id       uuid                                                                              not null,
    status        enum ('pending', 'rejected', 'training', 'completed') default 'pending'           null,
    createdAt     datetime                                              default current_timestamp() null,
    dateEducation datetime                                                                          not null,
    feedback      varchar(255)                                                                      null,
    constraint orders_users_FK
        foreign key (user_id) references users (id)
            on delete cascade
);

