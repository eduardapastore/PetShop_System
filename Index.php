<?php
session_start();
include 'processa.php';
$conn = OpenCon();

$sql = "SELECT * FROM cliente";
$resultado = $conn->query($sql);

echo "<h2>Lista de Clientes</h2>";

if ($resultado->num_rows > 0) {
    echo "<table border='1' cellpadding='8' cellspacing='0'>";
    echo "<tr>
            <th>ID</th>
            <th>Nome</th>
            <th>CEP</th>
            <th>Email</th>
            <th>Idade</th>
            <th>Telefone</th>
          </tr>";
    
    while ($linha = $resultado->fetch_assoc()) {
        echo "<tr>
                <td>{$linha['ID']}</td>
                <td>{$linha['NOME']}</td>
                <td>{$linha['CEP']}</td>
                <td>{$linha['Email']}</td>
                <td>{$linha['Idade']}</td>
                <td>{$linha['Telefone']}</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p>Nenhum cliente encontrado.</p>";
}

CloseCon($conn);
?>

<p>Adicione aqui novo cliente <a href="adicionar.php">Cadastre-se aqui</a></p>
<p><a href='logout.php'>Sair</a></p>

