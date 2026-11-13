<?php
function dump($str) {
  echo "<pre>".$str."</pre>";
}

function getValidatedRegisterUser(PDO $pdo): array {
  $registerUser = [];
  $registerUser["valid"] = false;
  $registerUser["errors"] = [];

  $registerUser["name"] = filter_input(INPUT_POST, "name", FILTER_UNSAFE_RAW);
  $registerUser["email"] = filter_input(INPUT_POST, "email", FILTER_UNSAFE_RAW);
  $registerUser["passwd"] = filter_input(INPUT_POST, "passwd", FILTER_UNSAFE_RAW);
  $registerUser["passwdConfirm"] = filter_input(INPUT_POST, "passwdConfirm", FILTER_UNSAFE_RAW);

  if (!(isset($registerUser["name"]) && strlen($registerUser["name"]) > 0 && strlen($registerUser["name"]) <= 100)) {
    $registerUser["errors"][] = "El nombre introducido no es válido.";
  }

  if (!(isset($registerUser["email"]) && filter_var($registerUser["email"], FILTER_VALIDATE_EMAIL))) {
    $registerUser["errors"][] = "El email introducido no es válido.";
  } else {
    $userDataFromDDBB = getUserByEmailFromDDBB($pdo, $registerUser["email"]);

    if ($userDataFromDDBB) {
      $registerUser["errors"][] = "Ya existe un usuario registrado con el email introducido.";
    }
  }
  
  if (!(isset($registerUser["passwd"]) && strlen($registerUser["passwd"]) >= 8)) {
    $registerUser["errors"][] = "La contraseña introducida no es válida. Debe contener al menos 8 carácteres.";
  }

  if (!(isset($registerUser["passwd"]) && isset($registerUser["passwdConfirm"]) && $registerUser["passwd"] === $registerUser["passwdConfirm"])) {
    $registerUser["errors"][] = "La contraseña a confirmar debe coincidir con la contraseña.";
  }

  if (count($registerUser["errors"]) < 1) {
    $registerUser["valid"] = true;
  }
  
  return $registerUser;
}

function getConnectionFromDDBB() {
  $res = null;
  $dsn = "mysql:host=db;dbname=login_dwes;charset=utf8mb4";

  try {
    $res = new PDO($dsn, "login_dwes", "Login2026.", [
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      PDO::ATTR_EMULATE_PREPARES => false,
      PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING
    ]);
  } catch (Exception $e) {
    echo "Error en getConnectionFromDDBB(): ".$e;
  }

  return $res;
}

function getUserByEmailFromDDBB(PDO $pdo, string|null $email = null) {
  $res = null;

  try {
    $query = "
      SELECT *
      FROM usuarios
      WHERE email LIKE ?;
    ";

    $statement = $pdo->prepare($query);
    $statement->execute([$email]);
    $res = $statement->fetch();

    if ($statement->rowCount() < 1) {
      $res = false;
    }

  } catch (Exception $e) {
    echo "Error en getConnectionFromDDBB(): ".$e;
    $res = false;
  }

  return $res;
}

function registerUserDDBB(PDO $pdo, array $registerUser) {
  $res = null;

  try {
    $query = "
      INSERT INTO usuarios (email, nombre, contrasena)
      VALUES (?, ?, ?);
    ";

    $contraHasheada = password_hash($registerUser["passwd"], PASSWORD_BCRYPT);
    
    $statement = $pdo->prepare($query);
    $res = $statement->execute([$registerUser["email"], $registerUser["name"], $contraHasheada]);
    
    if ($res) {
      $res = $pdo->lastInsertId();
    }

  } catch (Exception $e) {
    echo "Error en registerUserDDBB(): ".$e;
    $res = false;
  }

  return $res;
}

function getLoggedUserDDBB(PDO $pdo, array $loginUser) {
  $res = null;

  try {
    $query = "
      SELECT id, email, nombre, contrasena
      FROM usuarios
      WHERE email = ?;
    ";
    
    $statement = $pdo->prepare($query);
    $statement->execute([$loginUser["email"]]);
    
    if ($statement->rowCount() > 0) {
      $ddbbUser = $statement->fetch();
      if (password_verify($loginUser["passwd"], $ddbbUser["contrasena"])) {
        unset($ddbbUser["contrasena"]);
        $res = $ddbbUser;
      }
    }

  } catch (Exception $e) {
    echo "Error en getLoggedUserDDBB(): ".$e;
    $res = false;
  }

  return $res;
}

function saveFlashMessage(string $flashMsg) {
  if (!isset($_SESSION["flashMessages"])) {
    $_SESSION["flashMessages"] = [];
  }

  $_SESSION["flashMessages"][] = $flashMsg;
}

function readFlashMessages() {
  $res = [];
  if (isset($_SESSION["flashMessages"]) && count($_SESSION["flashMessages"]) > 0) {
    $res = $_SESSION["flashMessages"];
    $_SESSION["flashMessages"] = [];
  }

  return $res;
}

function getValidatedLoginUser(): array {
  $usuario = [];
  $usuario["valid"] = false;
  $usuario["errors"] = [];

  $usuario["email"] = filter_input(INPUT_POST, "email", FILTER_UNSAFE_RAW);
  $usuario["passwd"] = filter_input(INPUT_POST, "passwd", FILTER_UNSAFE_RAW);

  if (!(isset($usuario["email"]) && filter_var($usuario["email"], FILTER_VALIDATE_EMAIL))) {
    $usuario["errors"][] = "El email introducido no es válido.";
  }
  
  if (!(isset($usuario["passwd"]) && strlen($usuario["passwd"]) >= 8)) {
    $usuario["errors"][] = "La contraseña introducida no es válida. Debe contener al menos 8 carácteres.";
  }

  if (count($usuario["errors"]) < 1) {
    $usuario["valid"] = true;
  }
  
  return $usuario;
}

function saveUserInSession(array $user) {
  $res = false;

  if (!isset($_SESSION["user"])) {
    session_regenerate_id(true);
    $_SESSION["user"] = $user;
    $res = true;
  }

  return $res;
}

function getUserFromSession() {
  $res = null;

  if (isset($_SESSION["user"])) {
    $res = $_SESSION["user"];
  }

  return $res;
}

function logoutUserFromSession() {
  $res = false;

  if (isset($_SESSION["user"])) {
    unset($_SESSION["user"]);
    session_destroy();
    $res = true;
  }

  return $res;
}