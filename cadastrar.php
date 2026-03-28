<?php
include("conexao.php");

// CADASTRAR LIVRO
if ($_POST) {

    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $ano = $_POST['ano'];
    $categoria = $_POST['categoria'];

    $arquivo = $_FILES['arquivo']['name'];
    $caminho = "uploads/" . $arquivo;

    move_uploaded_file($_FILES['arquivo']['tmp_name'], $caminho);

    $sql = "INSERT INTO livros (titulo, autor, ano, categoria, arquivo)
            VALUES ('$titulo', '$autor', '$ano', '$categoria', '$arquivo')";

    mysqli_query($conexao, $sql);

    // 🔥 Redireciona com mensagem
    header("Location: cadastrar.php?sucesso=1");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro</title>
    <link rel="stylesheet" href="style.css">

    <style>
        .msg-sucesso {
            background: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>

<?php include("menu.php"); ?>

<div class="content">
    <div class="card">

        <h2>Cadastro de Novo Livro</h2>

        <!-- MENSAGEM -->
        <?php if (isset($_GET['sucesso'])) { ?>
            <div class="msg-sucesso">
                ✅ Livro cadastrado com sucesso!
            </div>
        <?php } ?>

        <p>
            Adicione uma nova obra ao acervo digital da biblioteca.
            Preencha as informações abaixo e envie o arquivo do livro em formato PDF.
        </p>

        <br>

        <form method="post" enctype="multipart/form-data">

            <label>Título do Livro</label>
            <input type="text" name="titulo" required>

            <label>Autor</label>
            <input type="text" name="autor" required>

            <label>Ano de Publicação</label>
            <input type="number" name="ano" required>

            <label>Categoria</label>
            <select name="categoria" required>
                <option value="">Selecione...</option>
                <option value="autoajuda">Autoajuda</option>
                <option value="biografia">Biografia</option>
                <option value="cientifico">Científico</option>
                <option value="drama">Drama</option>
                <option value="educacao">Educação</option>
                <option value="fantasia">Fantasia</option>
                <option value="ficcao">Ficção</option>
                <option value="infantil">Infantil</option>
                <option value="literatura">Literatura</option>
                <option value="romance">Romance</option>
                <option value="tecnologia">Tecnologia</option>
                <option value="terror">Terror</option>
            </select>

            <br><br>

            <label>Arquivo do Livro (PDF)</label>
            <input type="file" name="arquivo" accept="application/pdf" required>

            <br><br>

            <button class="btn">📚 CADASTRAR LIVRO</button>

        </form>

    </div>
</div>

</body>
</html>