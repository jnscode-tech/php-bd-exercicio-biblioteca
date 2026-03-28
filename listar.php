<?php
include("conexao.php");
include("menu.php");

// EXCLUIR LIVRO
if (isset($_GET['excluir'])) {
    $id = intval($_GET['excluir']); // segurança básica

    // Buscar arquivo
    $busca = mysqli_query($conexao, "SELECT arquivo FROM livros WHERE id = $id");
    $dados = mysqli_fetch_assoc($busca);

    // Deletar arquivo (se existir)
    if (!empty($dados['arquivo']) && file_exists("uploads/" . $dados['arquivo'])) {
        unlink("uploads/" . $dados['arquivo']);
    }

    // Deletar do banco
    mysqli_query($conexao, "DELETE FROM livros WHERE id = $id");

    // Redirecionar para evitar repetir exclusão ao atualizar
    header("Location: listar.php");
    exit;
}

// LISTAR LIVROS (somente quando clicar no botão)
$mostrarTabela = false;

if (isset($_GET['listar'])) {
    $mostrarTabela = true;

    $sql = "SELECT * FROM livros ORDER BY data_cadastro DESC";
    $resultado = mysqli_query($conexao, $sql);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Listar</title>
    <link rel="stylesheet" href="style.css">

    <style>

    </style>
</head>

<body>

<div class="content">
    <div class="card">
        <h2>Livros Cadastrados</h2>

        <!-- BOTÃO -->
        <form method="GET">
            <button type="submit" name="listar" class="btnListar">📚 Listar Livros</button>
        </form>

        <?php if ($mostrarTabela) { ?>

            <table border="1" width="100%">
                <tr>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Ano</th>
                    <th>Categoria</th>
                    <th>Arquivo</th>
                    <th>Data</th>
                    <th>Ações</th>
                </tr>

                <?php while($livro = mysqli_fetch_assoc($resultado)) { ?>

                    <tr>
                        <td><?php echo $livro['titulo']; ?></td>
                        <td><?php echo $livro['autor']; ?></td>
                        <td><?php echo $livro['ano']; ?></td>
                        <td><?php echo $livro['categoria']; ?></td>

                        <td>
                            <a href="uploads/<?php echo $livro['arquivo']; ?>" target="_blank">
                                Ver PDF
                            </a>
                        </td>

                        <td>
                            <?php echo date("d/m/Y H:i", strtotime($livro['data_cadastro'])); ?>
                        </td>

                        <td>
                            <a href="?excluir=<?php echo $livro['id']; ?>" 
                               onclick="return confirm('Tem certeza que deseja excluir?')">
                               ❌ Excluir
                            </a>
                        </td>
                    </tr>

                <?php } ?>

            </table>

        <?php } ?>

    </div>
</div>

</body>
</html>