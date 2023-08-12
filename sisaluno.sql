CREATE DATABASE sisaluno;

USE sisaluno;

CREATE TABLE Aluno (
  id INT PRIMARY KEY AUTO_INCREMENT,
  nome VARCHAR(100),
  idade INT,
  datanascimento DATE,
  endereco VARCHAR(100),
  estatus CHAR(20)
);

CREATE TABLE Professor (
  id INT PRIMARY KEY AUTO_INCREMENT,
  nome VARCHAR(100),
  cpf VARCHAR(11),
  idade INT,
  datanascimento DATE,
  endereco VARCHAR(100),
  estatus char(20)
);

CREATE TABLE Disciplina (
  id INT PRIMARY KEY AUTO_INCREMENT,
  nomedisciplina VARCHAR(100),
  ch VARCHAR(3),
  semestre VARCHAR(5),
  idprofessor INT,
  FOREIGN KEY (idprofessor) REFERENCES Professor(id)
);

CREATE TABLE DisciplinasAluno (
  id INT PRIMARY KEY AUTO_INCREMENT,
  idaluno INT,
  iddisciplina INT,
  nota1 DECIMAL(5, 2),
  nota2 DECIMAL(5, 2),
  media DECIMAL(5, 2),
  FOREIGN KEY (idaluno) REFERENCES Aluno(id),
  FOREIGN KEY (iddisciplina) REFERENCES Disciplina(id)
);

INSERT INTO `aluno` (`id`, `nome`, `idade`, `datanascimento`, `endereco`, `estatus`) VALUES
(1, 'João Silvah', 20, '2003-03-15', 'Ruas das Flores, 123', 'AP'),
(2, 'Maria Souza', 19, '2004-07-22', 'Avenida Principal, 456', 'AP'),
(3, 'Pedro Santos', 21, '2002-01-10', 'Praça Central', 'RP'),
(4, 'Ana Oliveira', 18, '2005-05-02', 'Rua das Árvores, 789', 'RP'),
(5, 'Lucas Pereira', 22, '2001-11-28', 'Avenida Secundaria, 56', 'TP');

INSERT INTO `professor` (`id`, `nome`, `cpf`, `idade`, `datanascimento`, `endereco`, `estatus`) VALUES
(1, 'João Paulo Glória', '111.111.111', 35, '1988-05-15', 'Avenida Principal, 456', '1'),
(2, 'Fabio Lima', '000.000.000', 45, '1980-10-20', 'Avenida Principal, 456', '0'),
(3, 'Woquiton Lima', '777.777.777', 45, '1985-04-03', 'Rua das Árvores, 789', '1');

INSERT INTO `disciplina` (`id`, `nomedisciplina`, `ch`, `semestre`, `idprofessor`) VALUES
(1, 'Banco de Dados', '80', '2', 1),
(2, 'PSW1', '80', '2', 2),
(3, 'PSW2', '80', '3', 3);

INSERT INTO `disciplinasaluno` (`id`, `idaluno`, `iddisciplina`, `nota1`, `nota2`, `media`) VALUES
(1, 1, 1, 10.00, 8.00, 9.00),
(2, 2, 1, 10.00, 10.00, 10.00),
(3, 1, 2, 5.00, 8.80, 6.90),
(4, 2, 2, 7.00, 9.00, 8.00),
(5, 3, 2, 7.00, 7.00, 7.00),
(6, 4, 2, NULL, NULL, NULL),
(7, 5, 2, NULL, NULL, NULL),
(8, 3, 1, 4.00, 3.00, 3.50),
(9, 4, 1, NULL, NULL, NULL),
(10, 5, 1, NULL, NULL, NULL),
(11, 1, 3, 5.00, 7.00, 6.00),
(12, 2, 3, 7.00, 4.00, 5.50),
(13, 3, 3, NULL, NULL, NULL),
(14, 4, 3, NULL, NULL, NULL),
(15, 5, 3, NULL, NULL, NULL);

