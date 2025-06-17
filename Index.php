<?php
session_start();
include 'processa.php';

$conn = OpenCon();

if (!$conn) {
    die("Erro na conexão com o banco de dados.");
}

// Consulta cliente
$clientes = $conn->query("SELECT * FROM cliente");

// Consulta animal
$animais = $conn->query("SELECT * FROM animal");

// Consulta produto
$produtos = $conn->query("SELECT * FROM produto");

?>

<h2>Dashboard</h2>

<!-- CLIENTES -->
<h3>Clientes</h3>
<table border="1" cellpadding="8">
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Email</th>
    </tr>
    <?php while ($c = $clientes->fetch_assoc()): ?>
        <tr>
            <td><?= $c['ID'] ?></td>
            <td><?= htmlspecialchars($c['NOME']) ?></td>
            <td><?= htmlspecialchars($c['Email']) ?></td>
        </tr>
    <?php endwhile; ?>
</table>

<!-- ANIMAIS -->
<h3>Animais</h3>
<table border="1" cellpadding="8">
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Tipo</th>
        <th>ID do Cliente</th>
    </tr>
    <?php while ($a = $animais->fetch_assoc()): ?>
        <tr>
            <td><?= $a['ID'] ?></td>
            <td><?= htmlspecialchars($a['Nome']) ?></td>
            <td><?= htmlspecialchars($a['Tipo']) ?></td>
            <td><?= $a['ClienteID'] ?></td>
        </tr>
    <?php endwhile; ?>
</table>

<!-- PRODUTOS -->
<h3>Produtos</h3>
<table border="1" cellpadding="8">
    <tr>
        <th>ID</th>
        <th>Nome do Produto</th>
        <th>Preço</th>
        <th>ID do Cliente</th>
    </tr>
    <?php while ($p = $produtos->fetch_assoc()): ?>
        <tr>
            <td><?= $p['ID'] ?></td>
            <td><?= htmlspecialchars($p['NomeProduto']) ?></td>
            <td>R$ <?= number_format($p['Preco'], 2, ',', '.') ?></td>
            <td><?= $p['ClienteID'] ?></td>
        </tr>
    <?php endwhile; ?>
</table>

<?php
CloseCon($conn);
?>
