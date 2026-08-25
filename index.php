<?php

include "infra/conexao.php";

$clientes = mysqli_query($conexao, "SELECT nome_cliente FROM clientes");

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
            <h2>Pets Cadastrados</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Raça</th>
                    <th>Cliente</th>
                    <th>Ações</th>  
                </tr>

                <?php while ($pet = mysqli_fetch_assoc($pets)) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($pet["idpet"]) ?></td>
                        <td><?php echo htmlspecialchars($pet["nome_pet"]) ?></td>
                        <td><?php echo htmlspecialchars($pet["raca"]) ?></td>
                        <td><?php echo htmlspecialchars($pet["nome_cliente"]) ?></td>
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