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

?>