<?php
session_start();

// Verifica se está logado
if (!isset($_SESSION['cliente'])) {
    header("Location: index.php");
    exit;
}

echo "<h1>Bem-vindo à página inicial, " . $_SESSION['cliente'] . "!</h1>";
echo "<p><a href='logout.php'>Sair</a></p>";
?>