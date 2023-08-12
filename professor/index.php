<?php
// Requer o arquivo de conexão com o banco de dados
require_once "../conn.php";

// Prepara e executa a query para selecionar todos os professores
$stmt = $conn->prepare("SELECT * FROM Professor");
$stmt->execute();
$professores = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>

<head>
    <title>Professores</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
</head>

<body class="pagina_fundo">
    <div class="caixa_tabela">
        <h1>Lista de Professores</h1>
        <a class="button" href="inserir.php">Adicionar Professor</a>
        <a class="voltar-inicio" href="../index.php">Voltar</a>
        <br><br>
        <table class="aluno-list">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>CPF</th>
                <th>Idade</th>
                <th>Data de Nascimento</th>
                <th>Endereço</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
            <?php foreach ($professores as $professor) { ?>
                <tr>
                    <td><?php echo $professor['id']; ?></td>
                    <td><?php echo $professor['nome']; ?></td>
                    <td><?php echo $professor['cpf']; ?></td>
                    <td><?php echo $professor['idade']; ?></td>
                    <td><?php echo $professor['datanascimento']; ?></td>
                    <td><?php echo $professor['endereco']; ?></td>
                    <td><?php echo $professor['estatus']; ?></td>
                    <td>
                        <a class="alterar" href="alterar.php?id=<?php echo $professor['id']; ?>">Alterar</a>
                        <a class="excluir" href="excluir.php?id=<?php echo $professor['id']; ?>&nome=<?php echo $professor['nome']; ?>">Excluir</a><br>
                        <a class="inserir-nota" href="inserir_notas.php?professor=<?php echo $professor['id']; ?>">Lançar Nota</a>
                    </td>
                </tr>
            <?php } ?>
        </table>

    </div>
</body>

</html>