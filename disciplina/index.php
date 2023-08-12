<?php
// Requer o arquivo de conexão com o banco de dados
require_once "../conn.php";

// Prepara e executa a query para selecionar todas as disciplinas
$stmt = $conn->prepare("SELECT * FROM Disciplina");
$stmt->execute();
$disciplinas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Função para obter o nome do professor a partir do ID do professor
function getProfessorNome($conn, $idprofessor)
{
    $stmt = $conn->prepare("SELECT nome FROM Professor WHERE id = :id");
    $stmt->bindParam(':id', $idprofessor);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['nome'];
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Disciplinas</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
</head>

<body class="pagina_fundo">
    <div class="caixa_tabela">
        <h1>Lista de Disciplinas</h1>
        <a class="button" href="inserir.php">Adicionar Disciplina</a>
        <a class="voltar-inicio" href="../index.php">Voltar</a>
        <br><br>
        <table>
            <tr>
                <th>ID</th>
                <th>Nome da Disciplina</th>
                <th>Carga Horária</th>
                <th>Semestre</th>
                <th>Professor</th>
                <th>Ações</th>
            </tr>
            <?php foreach ($disciplinas as $disciplina) { ?>
                <tr>
                    <td><?php echo $disciplina['id']; ?></td>
                    <td><?php echo $disciplina['nomedisciplina']; ?></td>
                    <td><?php echo $disciplina['ch']; ?></td>
                    <td><?php echo $disciplina['semestre']; ?></td>
                    <td><?php echo getProfessorNome($conn, $disciplina['idprofessor']); ?></td>
                    <td>
                        <a class="alterar" href="alterar.php?id=<?php echo $disciplina['id']; ?>">Alterar</a>
                        <a class="matricular-aluno" href="matricular_aluno.php?disciplina=<?php echo $disciplina['id']; ?>">Matricular Aluno</a><br>
                        <a class="excluir" href="excluir.php?id=<?php echo $disciplina['id']; ?>&nome=<?php echo $disciplina['nomedisciplina']; ?>">Excluir</a>
                        <a class="ver-notas-aluno" href="ver_notas_alunos.php?disciplina=<?php echo $disciplina['id']; ?>">Notas dos alunos</a>
                    </td>
                </tr>
            <?php } ?>
        </table>

    </div>
</body>

</html>