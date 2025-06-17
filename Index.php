<?php
session_start();
include 'processa.php';


$conn = OpenCon();
if ($conn instanceof mysqli) {
    echo "<p>Conexão bem-sucedida com MySQLi!</p>";
} else {
    echo "Erro na conexão.";
}
CloseCon($conn);

// login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    $conn = OpenCon();
    $stmt = $conn->prepare("SELECT * FROM cliente WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $cliente = $resultado->fetch_assoc();
        $_SESSION['cliente'] = $cliente['NOME'];
        header("Location: inicio.php");
        exit;
    } else {
        echo "<p style='color:red;'>Email não encontrado.</p>";
    }

    $stmt->close();
    CloseCon($conn);
}
?>

<h2>Login do Cliente</h2>
<form method="POST">
  Email: <input type="email" name="email" required><br>
  <button type="submit">Entrar</button>
</form>

<p>Ainda não tem cadastro? <a href="adicionar.php">Cadastre-se aqui</a></p>


