<?php

include "infra/conexao.php";

$filtro_cliente = isset($_GET["nome_cliente"]) ? $_GET["nome_cliente"] : "";

if ($filtro_cliente !== "") {
    $sql = "SELECT idpet, nome_pet, raca, idcliente FROM pet WHERE idcliente = ?";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "s", $filtro_cliente);
    mysqli_stmt_execute($stmt);
    $pets = mysqli_stmt_get_result($stmt);
} else {
    $pets = mysqli_query($conexao, "SELECT idpet, nome_pet, raca, idcliente FROM pet");
}

$clientes = mysqli_query($conexao, "SELECT idcliente, nome_cliente FROM clientes");

if (!$clientes) {
    die("Erro na consulta: " . mysqli_error($conexao));
}

$pets = mysqli_query($conexao, "SELECT * FROM pet");

if (!$pets) {
    die("Erro na consulta: " . mysqli_error($conexao));
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
    <header>
        <h1>Sistema PetShop</h1>
    </header>
    <main>

    <button type="button" onclick="window.location.href='publico/cadastrar_pet.php'">Cadastrar Pet</button>
    <button type="button" onclick="window.location.href='publico/cadastrar_cliente.php'">Cadastrar Cliente</button>

        <div>

            <h2>Clientes Cadastrados</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Telefone</th>
                    <th>Ações</th>
                </tr>
                <?php $clientes = mysqli_query($conexao, "SELECT idcliente, nome_cliente, email FROM clientes"); ?>
                <?php while ($cliente = mysqli_fetch_assoc($clientes)) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($cliente["idcliente"]) ?></td>
                        <td><?php echo htmlspecialchars($cliente["nome_cliente"]) ?></td>
                        <td><?php echo htmlspecialchars($cliente["email"]) ?></td>
                        <td>
                            <a href="publico/editar_cliente.php?nome_cliente=<?php echo urlencode($cliente["nome_cliente"]) ?>">Editar</a>
                            <a href="publico/deletar_cliente.php?nome_cliente=<?php echo urlencode($cliente["nome_cliente"]) ?>">Excluir</a>
                        </td>
                    </tr>
                <?php } ?>
            </table>

        </div>



        <div>
            <h2>Pets Cadastrados</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Raça</th>
                    <th>Cliente</th>
                    <th>Ações</th>  
                </tr>

                <form action="" method="GET">
                    <label for="nome_cliente_filtro">Cliente:</label>
                    <select name="nome_cliente" id="nome_cliente_filtro">
                        <option value="">Todos</option>
                        <?php
                        mysqli_data_seek($clientes, 0);
                        while ($cliente = mysqli_fetch_assoc($clientes)) { ?>
                            <option value="<?php echo htmlspecialchars($cliente["nome_cliente"]) ?>" <?php echo ($cliente["nome_cliente"] == $filtro_cliente) ? "selected" : "" ?>>
                                <?php echo htmlspecialchars($cliente["nome_cliente"]) ?>
                            </option>
                        <?php } ?>
                    </select>
                    <button type="submit">Filtrar</button>
                </form>

                <?php while ($pet = mysqli_fetch_assoc($pets)) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($pet["idpet"]) ?></td>
                        <td><?php echo htmlspecialchars($pet["nome_pet"]) ?></td>
                        <td><?php echo htmlspecialchars($pet["raca"]) ?></td>
                        <td><?php echo htmlspecialchars($pet["idcliente"]) ?></td>
                        <td>
                            <a href="public/editar.php?idpet=<?php echo urlencode($pet["idpet"]) ?>">Editar</a>
                            <a href="public/deletar.php?idpet=<?php echo urlencode($pet["idpet"]) ?>">Excluir</a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </main>
    <footer>

    </footer>
</body>

</html>