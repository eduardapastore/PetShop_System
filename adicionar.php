<?php
include 'processa.php';


$conn = OpenCon();
if ($conn instanceof mysqli) {
    echo "<p>Conexão bem-sucedida com MySQLi!</p>";
} else {
    echo "Erro na conexão.";
}
CloseCon($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $cep = $_POST['cep'];
    $email = $_POST['email'];
    $idade = $_POST['idade'];
    $telefone = $_POST['telefone'];

    $conn = OpenCon();
    $stmt = $conn->prepare("INSERT INTO cliente (NOME, CEP, Email, Idade, Telefone) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssds", $nome, $cep, $email, $idade, $telefone);

    if ($stmt->execute()) {
        echo "<p style='color:green;'>Cliente cadastrado com sucesso!</p>";
        echo "<a href='index.php'>Voltar a tela inicial</a>";
    } else {
        echo "<p style='color:red;'>Erro ao cadastrar: " . $stmt->error . "</p>";
    }

    $stmt->close();
    CloseCon($conn);
}
?>

<h2>Cadastro de Cliente</h2>
<form method="POST">
  Nome: <input type="text" name="nome" required><br>
  CEP: <input type="text" name="cep" required><br>
  Email: <input type="email" name="email" required><br>
  Idade: <input type="number" name="idade"><br>
  Telefone: <input type="text" name="telefone"><br>
  <button type="submit">Cadastrar</button>
</form>
