<?php

include "../infra/conexao.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome_pet = $_POST['nome_pet'] ?? '';
    $raca = $_POST['raca'] ?? '';
    $nome_cliente = $_POST['nome_cliente'] ?? '';

    $sql = "INSERT INTO pet (nome_pet, raca, nome_cliente) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conexao, $sql);

    if ($stmt === false) {
        die('Erro ao preparar a consulta: ' . mysqli_error($conexao));
    }

    mysqli_stmt_bind_param($stmt, 'ss', $nome_cliente, $email);

    if (mysqli_stmt_execute($stmt)) {
        echo "Pet cadastrado com sucesso!";
        echo "<br><a href='../index.php'>Voltar</a>";
        mysqli_stmt_close($stmt);
        exit();
    } else {
        echo "Erro ao cadastrar pet: " . mysqli_error($conexao);
    }

    mysqli_stmt_close($stmt);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <h1>Cadastrar Pet!</h1>
    <link rel="stylesheet" href="../styles/style.css">
</head>

<body>

<h2>Cadastrar Pet!</h2>
    <form action="public/cadastrar_pet.php" method="POST">
        <label for="nome_pet">Nome:</label>
        <input type="text" id="nome_pet" name="nome_pet" required>
        <br>
        <label for="raca">Raça:</label>
        <input type="text" id="raca" name="raca" required>
        <br>
        <label for="nome_cliente">Cliente:</label>
        <select name="nome_cliente" id="nome_cliente" required>
            <?php $clientes = mysqli_query($conexao, "SELECT nome_cliente FROM clientes"); ?>
            <?php while ($cliente = mysqli_fetch_assoc($clientes)) { ?>
                <option value="<?php echo $cliente["nome_cliente"] ?>"><?php echo $cliente["nome_cliente"] ?></option>
            <?php } ?>
        </select>
        <br>
        <button type="submit">Cadastrar</button>
    </form>
</body>
</html>
