<?php

include '../infra/conexao.php';

$idprato = isset($_GET['idprato']) ? (int) $_GET['idprato'] : 0;

$sql = "SELECT * FROM pratos WHERE idprato = ?";
$stmt = mysqli_prepare($conexao, $sql);
mysqli_stmt_bind_param($stmt, 'i', $idprato);
mysqli_stmt_execute($stmt);
$resultadoPrato = mysqli_stmt_get_result($stmt);
$prato = mysqli_fetch_assoc($resultadoPrato);

if (!$prato) {
    die('Prato não encontrado.');
}

$usuarios = mysqli_query($conexao, "SELECT nome_user FROM usuarios");

if (!$usuarios) {
    die("Erro na consulta: " . mysqli_error($conexao));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome_prato = trim($_POST['nome_prato']);
    $descricao = trim($_POST['descricao']);
    $preco = $_POST['preco'];
    $categoria = trim($_POST['categoria']);
    $nome_user = trim($_POST['nome_user']);

    $sql = "UPDATE pratos SET nome_prato = ?, descricao = ?, preco = ?, categoria = ?, nome_user = ? WHERE idprato = ?";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, 'ssdsss', $nome_prato, $descricao, $preco, $categoria, $nome_user, $idprato);

    if (mysqli_stmt_execute($stmt)) {
        echo "Prato atualizado com sucesso!";
        echo "<br><a href='../index.php'>Voltar</a>";
        exit();
    } else {
        echo "Erro ao atualizar prato: " . mysqli_error($conexao);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <h1>Editar Prato!</h1>
    <link rel="stylesheet" href="../styles/style.css">
</head>

<body>
    <form method="POST">

        <label for="nome">Nome:</label>
        <input type="text" name="nome_prato" id="nome_prato" value="<?php echo htmlspecialchars($prato['nome_prato']); ?>" required>
        <br>
        <label for="descricao">Descrição:</label>
        <input type="text" name="descricao" id="descricao" value="<?php echo htmlspecialchars($prato['descricao']); ?>" required>
        <br>
        <label for="categoria">Categoria:</label>
        <input type="text" name="categoria" id="categoria" value="<?php echo htmlspecialchars($prato['categoria']); ?>" required>
        <br>
        <label for="preco">Preço:</label>
        <input type="number" name="preco" id="preco" value="<?php echo htmlspecialchars($prato['preco']); ?>" step="0.01" required>
        <br>
        <label for="usuario">Usuário:</label>
        <select name="nome_user" id="nome_user" required>
            <?php while ($usuario = mysqli_fetch_assoc($usuarios)) { ?>
                <option 
                    value="<?php echo htmlspecialchars($usuario["nome_user"]) ?>"
                    <?php if ($usuario["nome_user"] === $prato["nome_user"]) echo "selected"; ?>
                >
                    <?php echo htmlspecialchars($usuario["nome_user"]) ?>
                </option>
            <?php } ?>
        </select>
        <br>
        <button type="submit">Atualizar Prato</button>
    </form>
    <button type="button" onclick="window.location.href='../index.php'">Voltar</button>

</body>

</html>