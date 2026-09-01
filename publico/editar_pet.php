<?php

include '../infra/conexao.php';

$pet = isset($_GET['idpet']) ? $_GET['idpet'] : '';

$sql = "SELECT * FROM pet WHERE idpet = ?";
$stmt = mysqli_prepare($conexao, $sql);
mysqli_stmt_bind_param($stmt, 'i', $pet);
mysqli_stmt_execute($stmt);
$resultadoPet = mysqli_stmt_get_result($stmt);
$pet = mysqli_fetch_assoc($resultadoPet);

if (!$pet) {
    die('Pet não encontrado.');
}

$clientes = mysqli_query($conexao, "SELECT idcliente, nome_cliente FROM clientes");

if (!$clientes) {
    die("Erro na consulta: " . mysqli_error($conexao));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome_pet = $_POST['nome_pet'] ?? '';
    $raca = $_POST['raca'] ?? '';
    $idcliente = $_POST['idcliente'] ?? '';

    $sql = "UPDATE pet SET nome_pet = ?, raca = ?, idcliente = ? WHERE idpet = ?";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, 'ssii', $nome_pet, $raca, $idcliente, $pet['idpet']);

    if (mysqli_stmt_execute($stmt)) {
        echo "Pet atualizado com sucesso!";
        echo "<br><a href='../index.php'>Voltar</a>";
        exit();
    } else {
        echo "Erro ao atualizar pet: " . mysqli_error($conexao);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <h1>Editar Pet!</h1>
    <link rel="stylesheet" href="../styles/style.css">
</head>

<body>
    <form method="POST">

        <label for="nome">Nome:</label>
        <input type="text" name="nome_pet" id="nome_pet" value="<?php echo htmlspecialchars($pet['nome_pet']); ?>" required>
        <br>
        <label for="raca">Raça:</label>
        <input type="text" name="raca" id="raca" value="<?php echo htmlspecialchars($pet['raca']); ?>" required>
        <br>
        <label for="idcliente">Cliente:</label>
        <select name="idcliente" id="idcliente" required>
            <?php while ($cliente = mysqli_fetch_assoc($clientes)) { ?>
                <option value="<?php echo htmlspecialchars($cliente["idcliente"]); ?>" <?php if ($cliente["idcliente"] == $pet['idcliente']) echo 'selected'; ?>>
                    <?php echo htmlspecialchars($cliente["nome_cliente"]); ?>
                </option>
            <?php } ?>
        </select>
        <button type="submit">Atualizar Pet</button>
    </form>
    <button type="button" onclick="window.location.href='../index.php'">Voltar</button>

</body>

</html>