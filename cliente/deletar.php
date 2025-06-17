<?php
include '../processa.php';
$conn = OpenCon();

$id_cliente = isset($_GET['id_cliente']) ? (int) $_GET['id_cliente'] : 0;

if($id_cliente){

    $stmt = $conn ->prepare("DELETE FROM cliente WHERE id=?");
    $stmt -> bind_param("i", $id_cliente);

    if($stmt->execute()){
        echo "cliente deletado";
    }
    else{
        echo "erro ao tentar deletar";
    }

    $stmt->close();
}
else
{
    echo "ID inválido";
}

CloseCon($conn);

?>