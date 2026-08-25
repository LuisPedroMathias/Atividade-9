<?php

include '../infra/conexao.php';

$cliente = isset($_GET['nome_cliente']) ? $_GET['nome_cliente'] : '';

$sql = "SELECT * FROM clientes WHERE nome_cliente = ?";
$stmt = mysqli_prepare($conexao, $sql);
mysqli_stmt_bind_param($stmt, 's', $cliente);
mysqli_stmt_execute($stmt);
$resultadoCliente = mysqli_stmt_get_result($stmt);
$cliente = mysqli_fetch_assoc($resultadoCliente);

if (!$cliente) {
    die('Cliente não encontrado.');
}

$usuarios = mysqli_query($conexao, "SELECT nome_cliente FROM clientes");

if (!$usuarios) {
    die("Erro na consulta: " . mysqli_error($conexao));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome_cliente = trim($_POST['nome_cliente']);
    $email = trim($_POST['email']);

    $sql = "UPDATE clientes SET nome_cliente = ?, email = ? WHERE nome_cliente = ?";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, 'sss', $nome_cliente, $email, $cliente['nome_cliente']);

    if (mysqli_stmt_execute($stmt)) {
        echo "Cliente atualizado com sucesso!";
        echo "<br><a href='../index.php'>Voltar</a>";
        exit();
    } else {
        echo "Erro ao atualizar cliente: " . mysqli_error($conexao);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <h1>Editar Cliente!</h1>
    <link rel="stylesheet" href="../styles/style.css">
</head>

<body>
    <form method="POST">

        <label for="nome">Nome:</label>
        <input type="text" name="nome_cliente" id="nome_cliente" value="<?php echo htmlspecialchars($cliente['nome_cliente']); ?>" required>
        <br>
        <label for="email">Email:</label>
        <input type="text" name="email" id="email" value="<?php echo htmlspecialchars($cliente['email']); ?>" required>
        <br>
        <button type="submit">Atualizar Cliente</button>
    </form>
    <button type="button" onclick="window.location.href='../index.php'">Voltar</button>

</body>

</html>