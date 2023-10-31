--Cria Banco de Dados
CREATE DATABASE TrackerDB
GO

--Seleciona o Banco
USE TrackerDB
GO

--Cria as Tabelas
CREATE TABLE USUARIO (
		ID INT IDENTITY(1,1),
		NOME NVARCHAR(50) NOT NULL,
		"LOGIN" NVARCHAR(50) NOT NULL,
		SENHA NVARCHAR(50) NOT NULL,
		EMAIL NVARCHAR(75) NOT NULL,
		"STATUS" NVARCHAR(10),
		CONSTRAINT PK_USUARIO PRIMARY KEY(ID)
		);
GO

CREATE TABLE TAG(
		ID INT IDENTITY(1,1),
		DESCRICAO NVARCHAR(35) NOT NULL,
		OBS NVARCHAR(500),	
		"STATUS" NVARCHAR(10),
		CONSTRAINT PK_TAG PRIMARY KEY(ID)
		);
GO

CREATE TABLE TIPO_INVESTIMENTO(
		ID INT IDENTITY(1,1),
		DESCRICAO NVARCHAR(75) NOT NULL,
		OBS NVARCHAR(500),
		"STATUS" NVARCHAR(10),
		CONSTRAINT PK_TIPO_INVESTIMENTO PRIMARY KEY(ID)
		);
GO

CREATE TABLE INVESTIMENTO(
		ID INT IDENTITY(1,1),
		ID_USUARIO INT NOT NULL,
		ID_TIPO_INVESTIMENTO INT NOT NULL,
		ID_TAG INT NOT NULL,
		DESCRICAO NVARCHAR(75) NOT NULL,
		QUANTIDADE_TOTAL DECIMAL(18, 8) NOT NULL,
		VALOR_TOTAL_APORTADO MONEY,
		PRECO_MEDIO MONEY,
		OBS VARCHAR(500),
		"STATUS" NVARCHAR(10),
		CONSTRAINT PK_INVESTIMENTO PRIMARY KEY(ID),
		CONSTRAINT FK_INVESTIMENTO_USUARIO FOREIGN KEY(ID_USUARIO) REFERENCES USUARIO(ID),
		CONSTRAINT FK_INVESTIMENTO_TIPO_INVESTIMENTO FOREIGN KEY(ID_TIPO_INVESTIMENTO) REFERENCES TIPO_INVESTIMENTO(ID),
		CONSTRAINT FK_INVESTIMENTO_TAG FOREIGN KEY(ID_TAG) REFERENCES TAG(ID)
);
GO

CREATE TABLE INVESTIMENTO_MOV(
		ID INT IDENTITY(1,1),
		ID_INVESTIMENTO INT NOT NULL,
		VALOR MONEY,
		"DATA" DATE NOT NULL CONSTRAINT INVESTIMENTO_MOV_DATE DEFAULT GETDATE(),
		QUANTIDADE_TOTAL DECIMAL(18, 8) NOT NULL,
		PRECO_MEDIO MONEY,
		OBS NVARCHAR(500),
		STATUS NVARCHAR(10),
		CONSTRAINT PK_INVESTIMENTO_MOV PRIMARY KEY(ID),
		CONSTRAINT FK_INVESTIMENTO_MOV_INVESTIMENTO FOREIGN KEY(ID_INVESTIMENTO) REFERENCES INVESTIMENTO(ID)
);
GO