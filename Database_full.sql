create table migrations
(
    id        serial
        primary key,
    migration varchar(255) not null,
    batch     integer      not null
);

alter table migrations
    owner to postgres;

create table password_reset_tokens
(
    email      varchar(255) not null
        primary key,
    token      varchar(255) not null,
    created_at timestamp(0)
);

alter table password_reset_tokens
    owner to postgres;

create table sessions
(
    id            varchar(255) not null
        primary key,
    user_id       bigint,
    ip_address    varchar(45),
    user_agent    text,
    payload       text         not null,
    last_activity integer      not null
);

alter table sessions
    owner to postgres;

create index sessions_user_id_index
    on sessions (user_id);

create index sessions_last_activity_index
    on sessions (last_activity);

create table cache
(
    key        varchar(255) not null
        primary key,
    value      text         not null,
    expiration integer      not null
);

alter table cache
    owner to postgres;

create table cache_locks
(
    key        varchar(255) not null
        primary key,
    owner      varchar(255) not null,
    expiration integer      not null
);

alter table cache_locks
    owner to postgres;

create table jobs
(
    id           bigserial
        primary key,
    queue        varchar(255) not null,
    payload      text         not null,
    attempts     smallint     not null,
    reserved_at  integer,
    available_at integer      not null,
    created_at   integer      not null
);

alter table jobs
    owner to postgres;

create index jobs_queue_index
    on jobs (queue);

create table job_batches
(
    id             varchar(255) not null
        primary key,
    name           varchar(255) not null,
    total_jobs     integer      not null,
    pending_jobs   integer      not null,
    failed_jobs    integer      not null,
    failed_job_ids text         not null,
    options        text,
    cancelled_at   integer,
    created_at     integer      not null,
    finished_at    integer
);

alter table job_batches
    owner to postgres;

create table failed_jobs
(
    id         bigserial
        primary key,
    uuid       varchar(255)                           not null
        constraint failed_jobs_uuid_unique
            unique,
    connection text                                   not null,
    queue      text                                   not null,
    payload    text                                   not null,
    exception  text                                   not null,
    failed_at  timestamp(0) default CURRENT_TIMESTAMP not null
);

alter table failed_jobs
    owner to postgres;

create table books
(
    id           serial
        primary key,
    title        varchar(255)           not null,
    author       varchar(255)           not null,
    description  text,
    price        numeric(10, 2)         not null,
    quantity     integer      default 0 not null,
    pages_count  integer,
    release_year integer,
    language     varchar(50),
    format       varchar(50),
    publisher    varchar(100),
    isbn         varchar(20)
        unique,
    edition      varchar(50),
    dimensions   varchar(100),
    weight       numeric(10, 2),
    updated_at   timestamp(0) default CURRENT_TIMESTAMP,
    created_at   timestamp(0) default CURRENT_TIMESTAMP
);

alter table books
    owner to postgres;

create table book_images
(
    id         serial
        primary key,
    book_id    integer not null
        references books
            on delete cascade,
    image_url  text    not null,
    sort_order integer      default 0,
    updated_at timestamp(0) default CURRENT_TIMESTAMP,
    created_at timestamp(0) default CURRENT_TIMESTAMP
);

alter table book_images
    owner to postgres;

create table categories
(
    id          serial
        primary key,
    name        varchar(100) not null
        unique,
    description text,
    updated_at  timestamp(0) default CURRENT_TIMESTAMP,
    created_at  timestamp(0) default CURRENT_TIMESTAMP
);

alter table categories
    owner to postgres;

create table book_categories
(
    id          serial
        primary key,
    book_id     integer not null
        references books
            on delete cascade,
    category_id integer not null
        references categories
            on delete cascade,
    updated_at  timestamp(0) default CURRENT_TIMESTAMP,
    created_at  timestamp(0) default CURRENT_TIMESTAMP
);

alter table book_categories
    owner to postgres;

create table genres
(
    id          serial
        primary key,
    name        varchar(100) not null
        unique,
    description text,
    updated_at  timestamp(0) default CURRENT_TIMESTAMP,
    created_at  timestamp(0) default CURRENT_TIMESTAMP
);

alter table genres
    owner to postgres;

create table book_genres
(
    id         serial
        primary key,
    book_id    integer not null
        references books
            on delete cascade,
    genre_id   integer not null
        references genres
            on delete cascade,
    updated_at timestamp(0) default CURRENT_TIMESTAMP,
    created_at timestamp(0) default CURRENT_TIMESTAMP
);

alter table book_genres
    owner to postgres;

create table roles
(
    id          serial
        primary key,
    name        varchar(50) not null,
    description text,
    updated_at  timestamp(0) default CURRENT_TIMESTAMP,
    created_at  timestamp(0) default CURRENT_TIMESTAMP
);

alter table roles
    owner to postgres;

create table users
(
    id             serial
        primary key,
    username       varchar(50)  not null
        unique,
    email          varchar(100) not null
        unique,
    password_hash  varchar(255) not null,
    address_line   varchar(255),
    city           varchar(100),
    state          varchar(100),
    postal_code    varchar(20),
    country        varchar(100),
    updated_at     timestamp(0) default CURRENT_TIMESTAMP,
    created_at     timestamp(0) default CURRENT_TIMESTAMP,
    remember_token varchar(100)
);

alter table users
    owner to postgres;

create table orders
(
    id                   serial
        primary key,
    user_id              integer
        references users
            on delete cascade,
    guest_email          varchar(100),
    order_date           timestamp(0) default CURRENT_TIMESTAMP,
    total_amount         numeric(10, 2) not null,
    status               varchar(50)  default 'New'::character varying,
    shipping_name        varchar(255),
    shipping_address     varchar(255),
    shipping_city        varchar(100),
    shipping_state       varchar(100),
    shipping_postal_code varchar(20),
    shipping_country     varchar(100),
    shipping_method      varchar(100),
    payment_method       varchar(100),
    updated_at           timestamp(0) default CURRENT_TIMESTAMP,
    created_at           timestamp(0) default CURRENT_TIMESTAMP
);

alter table orders
    owner to postgres;

create table order_items
(
    id         serial
        primary key,
    order_id   integer        not null
        references orders
            on delete cascade,
    book_id    integer        not null
        references books
            on delete cascade,
    quantity   integer        not null,
    price      numeric(10, 2) not null,
    updated_at timestamp(0) default CURRENT_TIMESTAMP,
    created_at timestamp(0) default CURRENT_TIMESTAMP
);

alter table order_items
    owner to postgres;

create table role_user
(
    role_id integer not null
        references roles
            on delete cascade,
    user_id integer not null
        references users
            on delete cascade,
    primary key (role_id, user_id)
);

alter table role_user
    owner to postgres;

