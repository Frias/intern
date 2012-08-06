<?php
session_start(); //Inicia a sessão atual
session_destroy(); //Destrói a sessão
header("location:login.php"); // Redireciona para a página inicial sem login
?>