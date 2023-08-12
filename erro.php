<!-- PAGINA DE ERRO PARA EXCLUIR -->

<?php
$isAluno = isset($_GET['aluno']) && $_GET['aluno'] === '1';
$isProfessor = isset($_GET['professor']) && $_GET['professor'] === '1';
$isDisciplina = isset($_GET['disciplina']) && $_GET['disciplina'] === '1';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../style.css">
    <title>Erro de Integridade de Dados</title>
    <style>

</style>
</head>

<body class="pagina-erro">
    <div class="error-container">
        <h1>Erro de Integridade de Dados</h1>
        <?php if ($isAluno) : ?>
        <p>Você não pode excluir um Aluno associado a uma disciplina</p>
        <?php elseif ($isProfessor) : ?>
        <p>Você não pode excluir um Professor associado a uma disciplina</p>
        <?php elseif ($isDisciplina) : ?>
            <p>Você não pode excluir uma disciplina cuja notas estão lançadas</p>
        <?php endif; ?>
        
        <a class="voltar-btn" href="aluno/index.php">Voltar</a>
    </div>
</body>

</html>

