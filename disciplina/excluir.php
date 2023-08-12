<?php

require_once "../conn.php";

$nome = $_GET['nome'];

// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $id = $_POST["id"];

  $stmt_check = $conn->prepare("SELECT iddisciplina FROM disciplinasaluno WHERE iddisciplina = :id");
  $stmt_check->bindParam(':id', $id);
  $stmt_check->execute();
  $disciplinaCadastrada = $stmt_check->fetchColumn();

  if ($disciplinaCadastrada){
    header("Location: ../erro.php?disciplina=1");
    exit();
  } else{

    
    $stmt = $conn->prepare("DELETE FROM disciplina WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    
  }
  // Redireciona para a página principal de professores
  header("Location: index.php");
  exit();
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Excluir Disciplina</title>
  <link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body class="pagina_fundo">
  <div class="caixa_form">
  <a class="voltar" href="index.php">Gerenciar diciplina</a>
      <h1>Excluir a Disciplina <br> <spam><?php echo $nome; ?></spam></h1>
      <form method="post" action="excluir.php">
        <label for="id">ID da Disciplina:</label>
        <input type="number" id="id" name="id" placeholder="Digite o id da diciplina para comfirma" required>
        <input type="submit" value="Excluir">
      </form>
  </div>
</body>
</html>
