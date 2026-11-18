<?php
include_once(__DIR__."/src/functions.php");

session_start();

$match = getMatchFromSession();

// session_destroy();

include_once(__DIR__."/src/templates/index.tpl.php");