<?php
include 'processa.php';
$conn = OpenCon();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];

    $stmt = $conn->prepare("UPDATE usuarios SET nome=?, email=? WHERE id=?");
    $stmt->bind_param("ssi", $nome, $email, $id);
    $stmt->execute();
    $stmt->close();

    echo "Atualizado com sucesso!";
    echo "<br><a href='listar.php'>Voltar</a>";
} else {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM usuarios WHERE id=$id");
    $user = $result->fetch_assoc();
?>
    <form method="POST">
      <input type="hidden" name="id" value="<?= $user['id'] ?>">
      Nome: <input type="text" name="nome" value="<?= $user['nome'] ?>"><br>
      Email: <input type="email" name="email" value="<?= $user['email'] ?>"><br>
      <button type="submit">Salvar</button>
    </form>
<?php
}
CloseCon($conn);
?>
