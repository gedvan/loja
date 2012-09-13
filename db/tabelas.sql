
CREATE TABLE usuarios (
    id_usuario      INT PRIMARY KEY AUTO_INCREMENT,
    nome            VARCHAR(100) NOT NULL,
    login           VARCHAR(50) NOT NULL UNIQUE,
    senha           VARCHAR(50) NOT NULL,
    data_cadastro   TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE produtos (
    id_produto      INT PRIMARY KEY AUTO_INCREMENT,
    nome            VARCHAR(100) NOT NULL,
    descricao       TEXT,
    preco           DECIMAL(10,2) NOT NULL,
    imagem          VARCHAR(100),
    fk_usuario      INT NOT NULL,
    FOREIGN KEY (fk_usuario) REFERENCES usuarios (id_usuario)
        ON UPDATE CASCADE ON DELETE RESTRICT
);
