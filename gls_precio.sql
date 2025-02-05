CREATE DATABASE IF NOT EXISTS gls_precio;
USE gls_precio;

CREATE TABLE ochoservice (
    `id` int(11) PRIMARY KEY AUTO_INCREMENT,
    `peso` varchar(50),
    `provincia` decimal(5,2),
    `peninsula` decimal(5,2)
);

CREATE TABLE diezservice(
    `id` int(11) PRIMARY KEY AUTO_INCREMENT,
    `peso` varchar(50),
    `provincia` decimal(5,2),
    `peninsula` decimal(5,2),
    `baleares` decimal(5,2),
    `canarias` decimal(5,2)
);

CREATE TABLE dosservice(
    `id` int(11) PRIMARY KEY AUTO_INCREMENT,
    `peso` varchar(50),
    `provincia` decimal(5,2),
    `peninsula` decimal(5,2),
    `baleares` decimal(5,2),
    `baleares_menor` decimal(5,2),
    `canarias` decimal(5,2),
    `canarias_menor` decimal(5,2)
);

CREATE TABLE businessparcel(
    `id` int(11) PRIMARY KEY AUTO_INCREMENT,
    `peso` varchar(50),
    `provincia` decimal(5,2),
    `regional` decimal(5,2),
    `peninsula` decimal(5,2),
    `ceuta_melilla` decimal(5,2),
    `baleares` decimal(5,2),
    `baleares_menor` decimal(5,2),
    `canarias` decimal(5,2),
    `canarias_menor` decimal(5,2)
);

INSERT INTO ochoservice(peso, provincia, peninsula) VALUES 
    (1,7.14,9.59),
    (3,8.18,11.05),
    (5,9.22,12.51),
    (10,11.82,12.51),
    (15,14.42,19.81),
    ('hilo adicional',0.52,0.73);

INSERT INTO diezservice(peso,provincia,peninsula,baleares,canarias) VALUES
    (1,3.01,4.06,6.16,8.57),
    (3,3.08,4.14,null,null),
    (5,3.44,4.74,null,null),
    (10,3.94,5.71,null,null),
    (15,4.72,7.83,null,null),
    ('kilo adicional',0.26,0.47,1.53,3.19);

INSERT INTO dosservice(peso,provincia,peninsula,baleares,baleares_menor,canarias,canarias_menor) VALUES 
    (1,2.26,3.31,5.41,7.00,7.82,9.97),
    (3,2.39,3.45,null,null,null,null),
    (5,2.56,3.86,null,null,null,null),
    (10,2.81,4.58,null,null,null,null),
    (15,3.25,6.36,null,null,null,null),
    ('kilo adicional', 0.21,0.42,1.48,1.85,3.14,3.41);

INSERT INTO businessparcel(peso, provincia, regional, peninsula, ceuta_melilla, baleares,baleares_menor,canarias,canarias_menor) VALUES 
    (1,2.11,2.48,3.16,13.96,5.21,6.75,7.81,9.97),
    (3,2.17,2.60,3.28,null,null,null,null,null),
    (5,2.27,2.88,3.66,null,null,null,null,null),
    (10,2.52,3.34,4.28,null,null,null,null,null),
    (15,2.93,4.68,5.69,null,null,null,null,null),
    ('kilo adicional',0.19,0.30,0.37,2.91,1.43,1.79,3.31,3.40);