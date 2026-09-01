<?php

mysqli_report(MYSQLI_REPORT_OFF);

include "../infra/conexao.php";

$idcliente = $_GET['idcliente'] ?? '';

$stmt = mysqli_prepare($conexao, "DELETE FROM clientes WHERE idcliente = ?");

if ($stmt === false) {
    die('Erro ao preparar a consulta: ' . mysqli_error($conexao));
}

mysqli_stmt_bind_param($stmt, 'i', $idcliente);

if (mysqli_stmt_execute($stmt)) {
    echo "Cliente excluído com sucesso.";
    echo "<br><a href='../index.php'>Voltar</a>";
} else {
    if (mysqli_errno($conexao) == 1451) {
        die("Não é possível excluir este cliente porque ele possui animais cadastrados.");
    } else {
        die("Erro ao excluir cliente: " . mysqli_error($conexao));
    }
}

mysqli_stmt_close($stmt);

?>