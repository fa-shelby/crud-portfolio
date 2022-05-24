<?php

session_start();
unset($_COOKIE['token']);
setcookie('token', '', time() - 3600, '/'); // Vide la valeur et l'ancien timestamp
header("Location:login.php");

