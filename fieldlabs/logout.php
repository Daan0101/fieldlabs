<?php

session_start();

// Unset alle session variabelen
$_SESSION = array();

// Destroy de session
session_destroy();

// Redirect naar de login pagina
header("Location: login.php");
exit();

?>