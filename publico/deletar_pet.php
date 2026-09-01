<?php

mysqli_report(MYSQLI_REPORT_OFF);

include "../infra/conexao.php";

$idpet = $_GET['idpet'] ?? '';

$stmt = mysqli_prepare($conexao, "DELETE FROM pet WHERE idpet = ?");

if ($stmt === false) {
    die('Erro ao preparar a consulta: ' . mysqli_error($conexao));
}

mysqli_stmt_bind_param($stmt, 'i', $idpet);

if (mysqli_stmt_execute($stmt)) {
    echo "Pet excluído com sucesso.";
    echo "<br><a href='../index.php'>Voltar</a>";
} else {
    if (mysqli_errno($conexao) == 1451) {
        die("Não é possível excluir este pet porque ele possui animais cadastrados.");
    } else {
        die("Erro ao excluir pet: " . mysqli_error($conexao));
    }
}

mysqli_stmt_close($stmt);

?>