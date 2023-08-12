<?php

require_once "../conn.php";

$nome = $_GET['nome'];

// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $id = $_POST["id"];

  // Verifica se o aluno está matriculado em alguma disciplina
  $stmt_check = $conn->prepare("SELECT idaluno FROM DisciplinasAluno WHERE idaluno = :id");
  $stmt_check->bindParam(':id', $id);
  $stmt_check->execute();
  $alunoMatriculado = $stmt_check->fetchColumn();

  if ($alunoMatriculado) {
      // Exibir uma notificação pop-up usando JavaScript
      header("Location: ../erro.php?aluno=1");
  } else {
      // Prepara e executa a query para excluir o aluno do banco de dados
      $stmt = $conn->prepare("DELETE FROM Aluno WHERE id = :id");
      $stmt->bindParam(':id', $id);
      $stmt->execute();

      // Redireciona para a página principal de alunos
      header("Location: index.php");
      exit();
  }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Excluir Aluno</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
</head>

<body class="pagina_fundo">
    <div class="caixa_form">
        <a class="voltar" href="index.php">Gerenciar Aluno</a>
        <h1>Excluir o Aluno: <br>
            <spam><?php echo $nome;?></spam>
        </h1>
        <form method="post" action="excluir.php">
            <label for="id">ID do Aluno:</label>
            <input type="number" id="id" name="id" placeholder="Digite o id do aluno para comfirma" required>
            <input type="submit" value="Excluir">
        </form>
    </div>
</body>

</html>
