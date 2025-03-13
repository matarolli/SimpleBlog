<?php
$host = 'localhost';   // Normalmente "localhost"
$db   = 'blog';        // Nome do seu banco (criado acima)
$user = 'root';        // Usuário do MySQL
$pass = '';            // Senha do MySQL

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
?>