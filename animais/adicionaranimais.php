<?php
include '../processa.php';

$conn = OpenCon();
if ($conn instanceof mysqli) {
    echo "<p>Conexão bem-sucedida com MySQLi!</p>";
} else {
    echo "Erro na conexão.";
}
CloseCon($conn);

// Recebe o ID do cliente pela URL
$id_cliente = isset($_GET['id_cliente']) ? (int) $_GET['id_cliente'] : 0;

$conn = OpenCon();
$tipos = $conn->query("SELECT * FROM tipo_animal");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $especie = $_POST['especie'];
    $raca = $_POST['raca'];
    $idade = $_POST['idade'];
    $sexo = $_POST['sexo'];
    $id_tipo = $_POST['id_tipo'];

    $stmt = $conn->prepare("INSERT INTO animal (NOME, ESPECIE, RACA, IDADE, SEXO, ID_TIPO, ID_CLIENTE) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssissi", $nome, $especie, $raca, $idade, $sexo, $id_tipo, $id_cliente);

    if ($stmt->execute()) {
        echo "<p style='color:green;'>Animal cadastrado com sucesso!</p>";
        echo "<a href='../index.php'>Voltar à tela inicial</a>";
    } else {
        echo "<p style='color:red;'>Erro ao cadastrar: " . $stmt->error . "</p>";
    }

    $stmt->close();
    CloseCon($conn);
}
?>

<h2>Cadastro de Animal (Cliente ID <?= $id_cliente ?>)</h2>
<form method="POST">
  Nome: <input type="text" name="nome" required><br>
  Espécie: <input type="text" name="especie" required><br>
  Raça: <input type="text" name="raca" required><br>
  Idade: <input type="number" name="idade"><br>
  Sexo:
  <select name="sexo" required>
    <option value="M">Macho</option>
    <option value="F">Fêmea</option>
  </select><br>
  Tipo:
  <select name="id_tipo" required>
    <?php while ($tipo = $tipos->fetch_assoc()): ?>
      <option value="<?= $tipo['ID'] ?>"><?= htmlspecialchars($tipo['DESCRICAO']) ?></option>
    <?php endwhile; ?>
  </select><br><br>
  <button type="submit">Cadastrar Animal</button>
</form>
