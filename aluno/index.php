<?php
// Requer o arquivo de conexão com o banco de dados
require_once "../conn.php";

// Prepara e executa a query para selecionar todos os alunos
$stmt = $conn->prepare("SELECT * FROM Aluno");
$stmt->execute();
$alunos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>

<head>
    <title>Alunos</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
</head>

<body class="pagina_fundo">>
    <div class="caixa_tabela">
        <h1>Lista de Alunos</h1>
        <a class="button" href="inserir.php">Adicionar Aluno</a>
        <a class="voltar-inicio" href="../index.php">Voltar</a>
        <br><br>
        <table>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Idade</th>
                <th>Data de Nascimento</th>
                <th>Endereço</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
            <?php foreach ($alunos as $aluno) { ?>
                <tr>
                    <td><?php echo $aluno['id']; ?></td>
                    <td><?php echo $aluno['nome']; ?></td>
                    <td><?php echo $aluno['idade']; ?></td>
                    <td><?php echo $aluno['datanascimento']; ?></td>
                    <td><?php echo $aluno['endereco']; ?></td>
                    <td><?php echo $aluno['estatus']; ?></td>
                    <td>
                        <a class="ver-notas" href="notas.php?id=<?php echo $aluno['id']; ?>&nome=<?php echo $aluno['nome']; ?>">Ver Notas</a>
                        <a class="alterar" href="alterar.php?id=<?php echo $aluno['id']; ?>">Alterar</a>
                        <a class="excluir" href="excluir.php?id=<?php echo $aluno['id']; ?>&nome=<?php echo $aluno['nome']; ?>">Excluir</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>

</html>