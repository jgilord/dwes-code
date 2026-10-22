-- Volcado de datos para la tabla reservas
INSERT INTO reservas (id, nombre, email, pista_id, fecha, hora) VALUES
  ('9be23698', 'Joseda', 'joseda@joseda.com', 'padel-2', '2026-10-16', '18:00:00'),
  ('ef75f9aa', 'Joseda', 'joseda@joseda.com', 'padel-1', '2026-10-16', '16:00:00'),
  ('817847c6', 'Joseda', 'joseda@joseda.com', 'padel-1', '2026-10-16', '17:00:00'),
  ('55dcf596', 'Joseda', 'joseda@joseda.com', 'padel-1', '2026-10-16', '19:00:00'),
  ('4df89690', 'Hugo Cruz', 'hugo@gmail.com', 'padel-2', '2026-10-19', '19:00:00'),
  ('045a07ea', 'Jose', 'admin@admin.com', 'padel-1', '2026-10-27', '19:00:00'),
  ('1af800b7', 'Joseda', 'joseda@joseda.com', 'baloncesto', '2026-10-21', '20:00:00'),
  ('5028f208', 'joseda', 'jgilord0103@gmail.com', 'baloncesto', '2026-10-21', '19:00:00');

-- Volcado de datos para la tabla materiales-reserva
INSERT INTO `materiales-reserva` (reserva_id, material_id) VALUES
  ('9be23698', 'balon'),
  ('9be23698', 'petos'),
  ('ef75f9aa', 'raquetas'),
  ('817847c6', 'raquetas'),
  ('55dcf596', 'raquetas'),
  ('4df89690', 'raquetas'),
  ('4df89690', 'balon'),
  ('4df89690', 'petos'),
  ('5028f208', 'balon'),
  ('5028f208', 'petos');