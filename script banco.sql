create database BdVidaSaudavel;
use BdVidaSaudavel;

CREATE TABLE usuarios (
    ID_usuario INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(30) UNIQUE NOT NULL,
    tipo ENUM('ADMINISTRADOR', 'COMUM') NOT NULL,
    senha VARCHAR(255) NOT NULL, -- senha salva criptografada em hash
    data_cadastro DATETIME NOT NULL
);

CREATE TABLE produtos (
    ID_produto INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(30) NOT NULL,
    preco DECIMAL(6,2) NOT NULL,
    quantidade INT NOT NULL,
    categoria ENUM(
        'ANALGÉSICOS', 'ANTI-INFLAMATÓRIOS', 'ANTIBIÓTICOS', 'ANTIVIRAIS',
        'ANTIFÚNGICOS', 'ANTIDEPRESSIVOS', 'ANSIOLÍTICOS', 'ANTIPSICÓTICOS', 
        'ANTIHISTAMÍNICOS', 'ANTIHIPERTENSIVOS', 'DIURÉTICOS', 'IMUNOSSUPRESSORES', 'OUTROS'
    ) NOT NULL,
    data_validade DATE NOT NULL
);

CREATE TABLE vendas (
    ID_venda INT AUTO_INCREMENT PRIMARY KEY,
    ID_usuario INT NOT NULL,
    data_venda DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (ID_usuario) REFERENCES usuarios(ID_usuario)
);

CREATE TABLE itens_venda (
    ID_item INT AUTO_INCREMENT PRIMARY KEY,
    ID_venda INT NOT NULL,
    ID_produto INT NOT NULL,
    quantidade INT NOT NULL,
    preco DECIMAL(6, 2) NOT NULL,
    FOREIGN KEY (ID_venda) REFERENCES vendas(ID_venda),
    FOREIGN KEY (ID_produto) REFERENCES produtos(ID_produto)
);

DELIMITER //

CREATE PROCEDURE registrarVenda(
    IN p_id_usuario INT,
    IN p_id_produto INT,
    IN p_quantidade INT,
    IN p_preco DECIMAL(6, 2)
)
BEGIN
    DECLARE v_id_venda INT;

    START TRANSACTION;

    -- Insere um novo registro na tabela vendas
    INSERT INTO vendas (ID_usuario) VALUES (p_id_usuario);
    
    -- Obtém o ID da venda recém-criada
    SET v_id_venda = LAST_INSERT_ID();

    -- Insere o item da venda na tabela itens_venda
    INSERT INTO itens_venda (ID_venda, ID_produto, quantidade, preco)
    VALUES (v_id_venda, p_id_produto, p_quantidade, p_preco);

    -- Atualiza a quantidade do produto vendido
    UPDATE produtos 
    SET quantidade = quantidade - p_quantidade 
    WHERE ID_produto = p_id_produto AND quantidade >= p_quantidade;

    -- Confirma a transação
    COMMIT;
END //

DELIMITER ;
INSERT INTO produtos (nome, preco, quantidade, categoria, data_validade) VALUES
('Paracetamol', 15.99, 100, 'ANALGÉSICOS', '2025-12-31'),
('Ibuprofeno', 20.50, 50, 'ANTI-INFLAMATÓRIOS', '2024-06-30'),
('Amoxicilina', 30.00, 30, 'ANTIBIÓTICOS', '2023-11-15'),
('Oseltamivir', 45.00, 20, 'ANTIVIRAIS', '2024-01-20'),
('Fluconazol', 25.00, 40, 'ANTIFÚNGICOS', '2025-03-10');
