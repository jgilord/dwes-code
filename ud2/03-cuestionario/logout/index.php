<?php
include_once("../src/functions.php");

session_start();
logoutUserFromSession();
header("Location: ../login/");