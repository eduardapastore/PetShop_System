<?php
include '../processa.php';

$conn = OpenCon();
if (!$conn) {
    die("Erro na conexão.");
}

// Receber o ID do cliente pela URL
$id_cliente = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id_cliente <= 0) {
    echo "<p style='color:red;'>ID de cliente inválido.</p>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Dados do formulário
    $nome = $_POST['nome'];
    $cep = $_POST['cep'];
    $email = $_POST['email'];
    $idade = $_POST['idade'];
    $telefone = $_POST['telefone'];

    // Atualiza no banco
    $stmt = $conn->prepare("UPDATE cliente SET NOME = ?, CEP = ?, Email = ?, Idade = ?, Telefone = ? WHERE ID = ?");
    $stmt->bind_param("sssisi", $nome, $cep, $email, $idade, $telefone, $id_cliente);

    if ($stmt->execute()) {
        echo "<p style='color:green;'>Cliente atualizado com sucesso!</p>";
        echo "<a href='../index.php'>Voltar à tela inicial</a>";
    }

    $stmt->close();
} else {
    // Primeira vez: busca os dados para preencher o formulário
    $stmt = $conn->prepare("SELECT * FROM cliente WHERE ID = ?");
    $stmt->bind_param("i", $id_cliente);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 0) {
        echo "<p style='color:red;'>Cliente não encontrado.</p>";
        exit;
    }

    $cliente = $resultado->fetch_assoc();
}

CloseCon($conn);
?>

<h2>Editar Cliente (ID <?= $id_cliente ?>)</h2>
<form method="POST">
  Nome: <input type="text" name="nome" value="<?= htmlspecialchars($cliente['NOME']) ?>" required><br>
  CEP: <input type="text" name="cep" value="<?= htmlspecialchars($cliente['CEP']) ?>" required><br>
  Email: <input type="email" name="email" value="<?= htmlspecialchars($cliente['Email']) ?>" required><br>
  Idade: <input type="number" name="idade" value="<?= $cliente['Idade'] ?>"><br>
  Telefone: <input type="text" name="telefone" value="<?= htmlspecialchars($cliente['Telefone']) ?>"><br>
    <button type="submit">Salvar Alterações</button>
</form>
