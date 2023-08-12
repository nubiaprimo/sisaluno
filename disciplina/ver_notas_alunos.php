<!-- VER AS NOTAS DE TODOS OS ALUNOS MATRICULADOS NA DISCIPLINA-->
<?php
require_once "../conn.php";

// Verifica se o parâmetro id da disciplina está presente na URL
if (isset($_GET['disciplina'])) {
    $disciplinaId = $_GET['disciplina'];

    // Prepara e executa a query para selecionar os alunos e suas notas na disciplina
    $stmt = $conn->prepare("SELECT Aluno.id AS id_aluno, Aluno.nome, DisciplinasAluno.nota1, DisciplinasAluno.nota2, DisciplinasAluno.media
                            FROM Aluno
                            INNER JOIN DisciplinasAluno ON Aluno.id = DisciplinasAluno.idaluno
                            WHERE DisciplinasAluno.iddisciplina = :disciplinaId");
    $stmt->bindParam(':disciplinaId', $disciplinaId);
    $stmt->execute();
    $alunosNotas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Recupera o nome da disciplina para exibir no título
    $stmt = $conn->prepare("SELECT nomedisciplina FROM Disciplina WHERE id = :disciplinaId");
    $stmt->bindParam(':disciplinaId', $disciplinaId);
    $stmt->execute();
    $nomeDisciplina = $stmt->fetchColumn();
} else {
    echo "ID da disciplina não especificado.";
    exit;
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Notas dos Alunos na Disciplina</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
</head>

<body class="pagina_fundo">
    <div class="caixa_tabela">
        <h1>Notas dos Alunos na Disciplina: <?php echo $nomeDisciplina; ?></h1>

        <a class="voltar" href="index.php">Voltar</a>

        <br><br>
        <table>
            <tr>
                <th>ID do Aluno</th>
                <th>Nome do Aluno</th>
                <th>Nota 1</th>
                <th>Nota 2</th>
                <th>Média</th>
            </tr>
            <?php foreach ($alunosNotas as $alunoNota) { ?>
                <tr>
                    <td><?php echo $alunoNota['id_aluno']; ?></td>
                    <td><?php echo $alunoNota['nome']; ?></td>
                    <td><?php echo $alunoNota['nota1']; ?></td>
                    <td><?php echo $alunoNota['nota2']; ?></td>
                    <td><?php echo $alunoNota['media']; ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>

</html>
