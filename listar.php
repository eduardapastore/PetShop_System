<?php
include 'processa.php';
$conn = OpenCon();
$result = $conn->query("SELECT * FROM usuarios");

echo "<table border='1'>
<tr><th>ID</th><th>Nome</th><th>Email</th><th>Ações</th></tr>";
while ($row = $result->fetch_assoc()) {
    echo "<tr>
    <td>{$row['id']}</td>
    <td>{$row['nome']}</td>
    <td>{$row['email']}</td>
    <td>
        <a href='editar.php?id={$row['id']}'>Editar</a> |
        <a href='excluir.php?id={$row['id']}'>Excluir</a>
    </td>
    </tr>";
}
echo "</table>";

CloseCon($conn);
?>
