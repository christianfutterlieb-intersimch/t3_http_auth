-- pages
CREATE TABLE pages (
    tx_httpauthentication_access int(11) unsigned DEFAULT NULL,
);

CREATE TABLE tx_httpauthentication_access (
    username varchar(45) DEFAULT NULL,
    password varchar(255) DEFAULT NULL,
);
