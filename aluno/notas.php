<!-- VER TODAS AS NOTAS DE TODAS AS MATERIAS QUE UM ALUNO ESTA MATRICULADO -->
<?php
require_once "../conn.php";

// Verifica se o parâmetro id está presente na URL
if (isset($_GET['id'])) {
    $idAluno = $_GET['id'];

    // Prepara e executa a query para selecionar as notas do aluno
    $stmt = $conn->prepare("SELECT DisciplinasAluno.id AS id_nota, Disciplina.nomedisciplina, DisciplinasAluno.nota1, DisciplinasAluno.nota2, DisciplinasAluno.media
                            FROM DisciplinasAluno
                            INNER JOIN Disciplina ON DisciplinasAluno.iddisciplina = Disciplina.id
                            WHERE DisciplinasAluno.idaluno = :idAluno");
    $stmt->bindParam(':idAluno', $idAluno);
    $stmt->execute();
    $notas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Recupera o nome do aluno para exibir no título
    $stmt = $conn->prepare("SELECT nome FROM Aluno WHERE id = :idAluno");
    $stmt->bindParam(':idAluno', $idAluno);
    $stmt->execute();
    $nomeAluno = $stmt->fetchColumn();
} else {
    echo "ID do aluno não especificado.";
    exit;
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Notas do Aluno</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
</head>

<body class="pagina_fundo">
    <div class="caixa_tabela" >
        <h1>Notas do Aluno: <?php echo $nomeAluno; ?></h1>

        <a class="voltar" href="index.php">Voltar</a>

        <br><br>
        <table>
            <tr>
                <th>ID da Nota</th>
                <th>Disciplina</th>
                <th>Nota 1</th>
                <th>Nota 2</th>
                <th>Média</th>
            </tr>
            <?php foreach ($notas as $nota) { ?>
                <tr>
                    <td><?php echo $nota['id_nota']; ?></td>
                    <td><?php echo $nota['nomedisciplina']; ?></td>
                    <td><?php echo $nota['nota1']; ?></td>
                    <td><?php echo $nota['nota2']; ?></td>
                    <td><?php echo $nota['media']; ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>

</html>
