CREATE DATABASE sistema_petshop_LP;
USE sistema_petshop_LP;

CREATE TABLE clientes (
    nome_cliente VARCHAR(200) NOT NULL PRIMARY KEY,
    email VARCHAR(100) NOT NULL
);

CREATE TABLE pet (
    idpet INT AUTO_INCREMENT PRIMARY KEY,
    nome_pet VARCHAR(200) NOT NULL,
    raca VARCHAR(100) NOT NULL,
    nome_cliente VARCHAR(200) NOT NULL,
    FOREIGN KEY (nome_cliente) REFERENCES clientes(nome_cliente)
);