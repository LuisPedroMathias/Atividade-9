<?php

include '../infra/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome_cliente = $_POST['nome_cliente'] ?? '';
    $email = $_POST['email'] ?? '';

    $sql = "INSERT INTO clientes (nome_cliente, email) VALUES (?, ?)";
    $stmt = mysqli_prepare($conexao, $sql);

    if ($stmt === false) {
        die('Erro ao preparar a consulta: ' . mysqli_error($conexao));
    }

    mysqli_stmt_bind_param($stmt, 'ss', $nome_cliente, $email);

    if (mysqli_stmt_execute($stmt)) {
        echo "Cliente cadastrado com sucesso!";
        echo "<br><a href='../index.php'>Voltar</a>";
        mysqli_stmt_close($stmt);
        exit();
    } else {
        echo "Erro ao cadastrar cliente: " . mysqli_error($conexao);
    }

    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema PetShop</title>
    <link rel="stylesheet" href="style/styles.css">
</head>

<body>
<h2>Cadastrar Cliente!</h2>

    <form method="POST">
        <label for="nome_cliente">Nome:</label>
        <input type="text" id="nome_cliente" name="nome_cliente" required>
        <br>
        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" required>
        <br>
        <button type="submit">Cadastrar</button>

</form>
</body>
</html>
