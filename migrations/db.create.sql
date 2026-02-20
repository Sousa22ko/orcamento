PRAGMA foreign_keys = OFF;

DROP TABLE IF EXISTS aplicacao;
CREATE TABLE aplicacao (
  id_aplicacao INTEGER PRIMARY KEY,
  id_descricao_aplicacao INTEGER,
  valor NUMERIC,
  ocorrencia TEXT,
  obs BLOB,
  valido TEXT
);

DROP TABLE IF EXISTS categoria;
CREATE TABLE categoria (
  categoria INTEGER PRIMARY KEY AUTOINCREMENT,
  nome_categoria TEXT
);

DROP TABLE IF EXISTS configuracao;
CREATE TABLE configuracao (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  min TEXT NOT NULL,
  max TEXT NOT NULL,
  valor1 TEXT NOT NULL,
  valor2 TEXT NOT NULL,
  modulo TEXT NOT NULL
);

DROP TABLE IF EXISTS descricao;
CREATE TABLE descricao (
  id_descricao INTEGER PRIMARY KEY AUTOINCREMENT,
  descricao TEXT,
  descricao_abreviada TEXT,
  debito TEXT DEFAULT 'N',
  dia_vencimento TEXT,
  valido TEXT DEFAULT 'S'
);

DROP TABLE IF EXISTS descricao_aplicacao;
CREATE TABLE descricao_aplicacao (
  id_descricao_aplicacao INTEGER PRIMARY KEY AUTOINCREMENT,
  descricao_aplicacao TEXT,
  descricao_aplicacao_abreviada TEXT
);

DROP TABLE IF EXISTS despesa;
CREATE TABLE despesa (
  id_despesa INTEGER PRIMARY KEY AUTOINCREMENT,
  despesa TEXT,
  data TEXT,
  valor NUMERIC,
  valor_casa NUMERIC,
  ocorrencia TEXT,
  parcela TEXT,
  id_descricao INTEGER,
  vencimento TEXT,
  pago TEXT,
  valido TEXT DEFAULT 'S',
  obs BLOB,
  categoria INTEGER DEFAULT 1
);

DROP TABLE IF EXISTS despesa_cartao;
CREATE TABLE despesa_cartao (
  id_despesa_cartao INTEGER PRIMARY KEY AUTOINCREMENT,
  valor NUMERIC,
  id_descricao INTEGER,
  ocorrencia TEXT,
  ano TEXT
);

DROP TABLE IF EXISTS receita;
CREATE TABLE receita (
  id_receita INTEGER PRIMARY KEY AUTOINCREMENT,
  receita NUMERIC,
  ocorrencia TEXT
);

DROP TABLE IF EXISTS tabela_imagens;
CREATE TABLE tabela_imagens (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  id_despesa_imagem INTEGER NOT NULL,
  nome_imagem TEXT NOT NULL,
  tamanho_imagem TEXT NOT NULL,
  tipo_imagem TEXT NOT NULL,
  imagem BLOB NOT NULL
);