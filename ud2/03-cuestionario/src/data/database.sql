-- ============================================================
-- Actividad: Cuestionario con progreso en sesión · cuestionario.sql
-- Amplía la base de datos login_dwes con las tablas de preguntas
-- y resultados. Ejecutar después de usuarios.sql.
-- Se puede ejecutar varias veces sin errores.
-- ============================================================

USE login_dwes;

-- Nota sobre permisos: El usuario de la aplicación ('login_dwes'@'localhost')
-- ya cuenta con permisos sobre la base de datos completa (SELECT, INSERT, 
-- UPDATE, DELETE ON login_dwes.*), por lo que tendrá acceso automático 
-- a estas nuevas tablas sin necesidad de otorgar nuevos privilegios.

-- Eliminación de tablas previas si existen (respetando dependencias de claves ajenas)
DROP TABLE IF EXISTS resultados;
DROP TABLE IF EXISTS preguntas;

-- Tabla de preguntas
CREATE TABLE preguntas (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    enunciado TEXT NOT NULL,
    opcion_a VARCHAR(255) NOT NULL,
    opcion_b VARCHAR(255) NOT NULL,
    opcion_c VARCHAR(255) NOT NULL,
    opcion_d VARCHAR(255) NOT NULL,
    correcta ENUM('a', 'b', 'c', 'd') NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_spanish_ci;

-- Tabla de resultados
CREATE TABLE resultados (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT UNSIGNED NOT NULL,
    aciertos INT UNSIGNED NOT NULL,
    total INT UNSIGNED NOT NULL,
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_resultados_usuario FOREIGN KEY (usuario_id) 
        REFERENCES usuarios(id) 
        ON DELETE CASCADE 
        ON UPDATE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_spanish_ci;

-- Inserción de 10 preguntas de prueba sobre el módulo
INSERT INTO preguntas (enunciado, opcion_a, opcion_b, opcion_c, opcion_d, correcta) VALUES
('¿Qué función de PHP se utiliza para iniciar una sesión o recuperar la existente?', 'session_start()', 'start_session()', 'init_session()', 'open_session()', 'a'),
('¿En qué superglobal de PHP se almacenan los datos de la sesión del usuario?', '$_COOKIE', '$_SESSION', '$_SERVER', '$_POST', 'b'),
('¿Qué función destruye toda la información asociada a la sesión actual?', 'session_destroy()', 'session_unset()', 'session_delete()', 'session_stop()', 'a'),
('¿Qué clase de PHP se utiliza habitualmente para conectar con bases de datos de forma segura mediante sentencias preparadas?', 'MySQLi', 'PDO', 'ODBC', 'SQLite', 'b'),
('¿Qué método de PDO se emplea para ejecutar una sentencia preparada con parámetros?', 'execute()', 'run()', 'send()', 'query()', 'a'),
('¿Qué método HTTP es más adecuado para enviar datos sensibles, como una contraseña o un formulario de login?', 'GET', 'POST', 'PUT', 'HEAD', 'b'),
('¿Qué función de PHP se debe utilizar obligatoriamente para escapar el texto que se muestra en el navegador y evitar ataques XSS?', 'strip_tags()', 'md5()', 'htmlspecialchars()', 'urlencode()', 'c'),
('¿Qué patrón de diseño se recomienda al procesar formularios para evitar que al recargar la página se reenvíen los datos?', 'MVC', 'PRG (Post/Redirect/Get)', 'Singleton', 'Observer', 'b'),
('¿Qué función de PHP se utiliza para generar un hash seguro de una contraseña?', 'md5()', 'sha1()', 'password_hash()', 'crypt()', 'c'),
('¿Cuál de las siguientes opciones elimina todas las variables de sesión pero mantiene la sesión activa?', 'session_destroy()', 'session_unset()', 'unset_session()', 'session_clear()', 'b');