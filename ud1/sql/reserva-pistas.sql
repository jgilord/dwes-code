CREATE DATABASE IF NOT EXISTS `reserva-pistas`;
USE `reserva-pistas`;

DROP TABLE IF EXISTS `materiales-reserva`;
DROP TABLE IF EXISTS reservas;
DROP TABLE IF EXISTS `lista-materiales`;
DROP TABLE IF EXISTS `lista-pistas`;

CREATE TABLE `lista-materiales` (
  id varchar(50) NOT NULL,
  nombre varchar(100) NOT NULL,
  PRIMARY KEY (id)
);

INSERT INTO `lista-materiales` (id, nombre) VALUES
  ('balon', 'Balón'),
  ('petos', 'Petos'),
  ('raquetas', 'Raquetas');

CREATE TABLE `lista-pistas` (
  id varchar(50) NOT NULL,
  nombre varchar(100) NOT NULL,
  PRIMARY KEY (id)
);

INSERT INTO `lista-pistas` (id, nombre) VALUES
  ('baloncesto', 'Baloncesto'),
  ('padel-1', 'Pádel 1'),
  ('padel-2', 'Pádel 2'),
  ('tenis', 'Tenis');

CREATE TABLE reservas (
  id varchar(32) NOT NULL,
  nombre varchar(60) NOT NULL,
  email varchar(255) NOT NULL,
  pista_id varchar(50) NOT NULL,
  fecha date NOT NULL,
  hora time NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uk_pista_fecha_hora (pista_id, fecha, hora),
  KEY idx_fecha (fecha),
  CONSTRAINT fk_reservas_pista
    FOREIGN KEY (pista_id) REFERENCES `lista-pistas` (id)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT chk_nombre_longitud
    CHECK (char_length(nombre) >= 2),
  CONSTRAINT chk_hora_franja
    CHECK (hora IN ('16:00:00', '17:00:00', '18:00:00', '19:00:00', '20:00:00', '21:00:00'))
);

CREATE TABLE `materiales-reserva` (
  reserva_id varchar(32) NOT NULL,
  material_id varchar(50) NOT NULL,
  PRIMARY KEY (reserva_id, material_id),
  KEY idx_material_id (material_id),
  CONSTRAINT fk_mat_res_reserva
    FOREIGN KEY (reserva_id) REFERENCES reservas (id)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT fk_mat_res_material
    FOREIGN KEY (material_id) REFERENCES `lista-materiales` (id)
    ON DELETE RESTRICT
    ON UPDATE CASCADE
);