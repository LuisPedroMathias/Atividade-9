CREATE DATABASE sistema_petshop_LP;
USE sistema_petshop_LP;

CREATE TABLE clientes (
    idcliente INT AUTO_INCREMENT PRIMARY KEY,
    nome_cliente VARCHAR(200) NOT NULL,
    email VARCHAR(100) NOT NULL
);

CREATE TABLE pet (
    idpet INT AUTO_INCREMENT PRIMARY KEY,
    nome_pet VARCHAR(200) NOT NULL,
    raca VARCHAR(100) NOT NULL,
    idcliente INT,
    nome_cliente VARCHAR(200) NOT NULL,
    FOREIGN KEY (idcliente) REFERENCES clientes(idcliente),
    FOREIGN KEY (nome_cliente) REFERENCES clientes(nome_cliente)
);