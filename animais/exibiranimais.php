<?php
include '../processa.php';

$conn = OpenCon();
if ($conn instanceof mysqli) {
    echo "<p>Conexão bem-sucedida com MySQLi!</p>";
} else {
    die("Erro na conexão.");
}

// Recebe o ID do cliente pela URL
$id_cliente = isset($_GET['id_cliente']) ? (int) $_GET['id_cliente'] : 0;

if ($id_cliente <= 0) {
    echo "<p style='color:red;'>ID de cliente inválido.</p>";
    exit;
}

// Consulta nome do cliente
$clienteQuery = $conn->prepare("SELECT NOME FROM cliente WHERE ID = ?");
$clienteQuery->bind_param("i", $id_cliente);
$clienteQuery->execute();
$resultCliente = $clienteQuery->get_result();

if ($resultCliente->num_rows === 0) {
    echo "<p style='color:red;'>Cliente não encontrado.</p>";
    exit;
}
$cliente = $resultCliente->fetch_assoc();

// Consulta animais desse cliente com JOIN no tipo
$sql = "
SELECT 
    animal.ID,
    animal.NOME,
    animal.ESPECIE,
    animal.RACA,
    animal.IDADE,
    animal.SEXO,
    tipo_animal.DESCRICAO AS tipo
FROM animal
JOIN tipo_animal ON animal.ID_TIPO = tipo_animal.ID
WHERE animal.ID_CLIENTE = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_cliente);
$stmt->execute();
$animais = $stmt->get_result();
?>

<h2>Animais de <?= htmlspecialchars($cliente['NOME']) ?> </h2>

<?php if ($animais->num_rows > 0): ?>
    <table border="1" cellpadding="8">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Espécie</th>
            <th>Raça</th>
            <th>Idade</th>
            <th>Sexo</th>
            <th>Tipo</th>
        </tr>
        <?php while ($a = $animais->fetch_assoc()): ?>
            <tr>
                <td><?= $a['ID'] ?></td>
                <td><?= htmlspecialchars($a['NOME']) ?></td>
                <td><?= htmlspecialchars($a['ESPECIE']) ?></td>
                <td><?= htmlspecialchars($a['RACA']) ?></td>
                <td><?= $a['IDADE'] ?></td>
                <td><?= $a['SEXO'] ?></td>
                <td><?= htmlspecialchars($a['tipo']) ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
<?php else: ?>
    <p>Nenhum animal cadastrado para este cliente.</p>
<?php endif; ?>

<p><a href="../index.php"><button>Voltar</button></a></p>

<?php
CloseCon($conn);
?>
