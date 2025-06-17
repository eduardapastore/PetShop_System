<?php
include 'processa.php';
$conn = OpenCon();

$id = $_GET['id'] ?? 0;

if($id){

    $stmt = $conn ->prepare("DELETE FROM usuarios WHERE id=?");
    $stmt -> bind_param("i", $id);

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