Digite isso no seu banco de dados.
Meu caso foi o Wampp e o InfinityFree (no InfinityFree, tem que criar separado e apagar as 5 primeiras linhas):

-- Cria a base de dados (opcional, pode usar uma existente)
CREATE DATABASE IF NOT EXISTS lista_tarefas_db;

-- Usa a base de dados
USE lista_tarefas_db;

-- Tabela para guardar os utilizadores (baseado no nome)
CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL UNIQUE,
    -- UNIQUE garante que não há dois utilizadores com o mesmo nome
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela para guardar as tarefas
CREATE TABLE tarefas (
    id_tarefa INT AUTO_INCREMENT PRIMARY KEY,
    descricao TEXT NOT NULL,
    concluida TINYINT(1) DEFAULT 0, -- 0 = não concluída, 1 = concluída
    id_usuario INT NOT NULL, -- "Chave estrangeira" que liga à tabela usuarios
    
    -- Define a ligação oficial entre as tabelas
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
        ON DELETE CASCADE -- Se o utilizador for apagado, apaga as suas tarefas
);
