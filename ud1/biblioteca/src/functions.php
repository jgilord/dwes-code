<?php 
  include_once(__DIR__."/vars.php");

  function dump($str) {
    echo "<pre>".$str."</pre>";
  }

  function conectar() {
    $dsn = "mysql:host=db;dbname=biblioteca;charset=utf8mb4";

    $pdo = null;

    try {
      $pdo = new PDO(
        $dsn,
        "root",
        "zYk8U77FkzRcDjV4NQ9cr6WKHAFNIg91",
        [PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
      );
    } catch (Exception $e) {
      dump("No se puede conectar con la base de datos");
    }

    return $pdo;
  }

  $pdo = conectar();

  function contarLibrosDisponible(PDO $pdo) {
    try {
      $query = "
        SELECT count(disponible) AS libros_disponibles
        FROM libros
        WHERE disponible = 1
        GROUP BY disponible;
      ";

      return $pdo->query($query)->fetchColumn();
    } catch (Exception $e) {
      dump("Error en contarLibrosDisponible()".$e);
      return null;
    }
  }

  function obtenerLibro(PDO $pdo, int $id) {
    try {
      $query = "
        SELECT *
        FROM libros
        WHERE id = ?;
      ";

      $statement = $pdo->prepare($query);
      $statement->execute([$id]);
      $libro = $statement->fetch();

      return $libro;
    } catch (Exception $e) {
      dump("Error en obtenerLibro()".$e);
      return null;
    }
  }

  function listarLibros(PDO $pdo, ?string $genero = null) {
    try {
      $query = "
        SELECT *
        FROM libros
      ";

      $libros = [];

      if ($genero) {
        if (in_array($genero, GENEROS_VALIDOS)) {
          $query .= "
            WHERE genero = ?;
          ";

          $statement = $pdo->prepare($query);
          $statement->execute([$genero]);
          $libros = $statement->fetchAll();
        }
      } else {
        $query .= ";";
        
        $libros = $pdo->query($query)->fetchAll();
      }

      return $libros;
    } catch (Exception $e) {
      dump("Error en listarLibros()".$e);
      return null;
    }
  }

  function insertarLibro(PDO $pdo, array $datos): int|null {
    $resultado = null;

    try {
      $query = "
        INSERT INTO libros (isbn, titulo, autor, anio, genero)
				VALUES (?, ?, ?, ?, ?);
      ";

      $statement = $pdo->prepare($query);
      $statement->execute([$datos["ISBN"], $datos["titulo"], $datos["autor"], $datos["anio"], $datos["genero"]]);
      $resultado = $pdo->lastInsertId();
    } catch (PDOException $e) {
      if (isset($e->errorInfo[1]) && $e->errorInfo[1] == 1062) {
        dump("Ya existe un libro con ese ISBN");
      } else {
        dump("Error en 1062()".$e);
      }
    }

    return $resultado;
  }

  function generoValidadoGET() {
    $categoria = filter_input(INPUT_GET, "genero", FILTER_UNSAFE_RAW);
    if ($categoria && in_array($categoria, GENEROS_VALIDOS)) {
      return $categoria;
    } else {
      return false;
    }
  }

  function libroValidadoPOST() {
    $libro["ISBN"] = filter_input(INPUT_POST, "ISBN", FILTER_UNSAFE_RAW);
    $libro["titulo"] = filter_input(INPUT_POST, "titulo", FILTER_UNSAFE_RAW);
    $libro["autor"] = filter_input(INPUT_POST, "autor", FILTER_UNSAFE_RAW);
    $libro["anio"] = filter_input(INPUT_POST, "anio", FILTER_SANITIZE_NUMBER_INT);
    $libro["genero"] = filter_input(INPUT_POST, "genero", FILTER_UNSAFE_RAW);

    $libro["errores"] = [];
    $libro["valido"] = true;

    if (!isset($libro["ISBN"]) || empty($libro["ISBN"])) {
      $libro["errores"][] = "El ISBN del libro no puede estar vacío.";
      $libro["valido"] = false;
    }

    if (!isset($libro["titulo"]) || empty($libro["titulo"])) {
      $libro["errores"][] = "El título del libro no puede estar vacío.";
      $libro["valido"] = false;
    }

    if (!isset($libro["autor"]) || empty($libro["autor"])) {
      $libro["errores"][] = "El autor del libro no puede estar vacío.";
      $libro["valido"] = false;
    }

    $fechaActual = new DateTime();
    $anioActual = $fechaActual->format("Y");

    if (isset($libro["anio"])) {
      if (!($libro["anio"] >= 1450 && $libro["anio"] <= intval($anioActual))) {
        $libro["errores"][] = "El año del libro debe estar entre 1450 y ".$anioActual.".";
        $libro["valido"] = false;
      }
    } else {
      $libro["errores"][] = "El año del libro no puede estar vacío y debe ser un entero.";
      $libro["valido"] = false;
    }

    if (isset($libro["genero"])) {
      if (!in_array($libro["genero"], GENEROS_VALIDOS)) {
        $libro["errores"][] = "El género del libro debe ser uno válido.";
        $libro["valido"] = false;
      }
    } else {
      $libro["errores"][] = "El género del libro no puede estar vacío.";
      $libro["valido"] = false;
    }

    return $libro;
  }

  function cambiarDisponible(PDO $pdo, int $id, int $disponible): int {
    try {
      $estadoActual = ($disponible == 1) ? 0 : 1;

      $query = "
        UPDATE libros 
        SET disponible = ? 
        WHERE id = ? AND disponible = ?;
      ";

      $statement = $pdo->prepare($query);
      $statement->execute([$disponible, $id, $estadoActual]);
      
      return $statement->rowCount();
    } catch (Exception $e) {
      dump("Error en cambiarDisponible()".$e);
      return 0;
    }
  }

  function borrarLibro(PDO $pdo, int $id): int {
    try {
      $query = "
        DELETE FROM libros 
        WHERE id = ?;
      ";

      $statement = $pdo->prepare($query);
      $statement->execute([$id]);
      
      return $statement->rowCount();
    } catch (PDOException $e) {
      if (isset($e->errorInfo[1]) && $e->errorInfo[1] == 1451) {
        dump("No se puede borrar: el libro tiene préstamos registrados");
      } else {
        dump("Error en borrarLibro()".$e);
      }
      return 0;
    }
  }
?>