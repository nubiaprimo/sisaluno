<?php

require_once "../conn.php";

// Verifica se o ID do aluno foi fornecido
if (!isset($_GET["id"])) {
  // Redireciona de volta para a página principal de alunos
  header("Location: index.php");
  exit();
}

$id = $_GET["id"];

// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nome = $_POST["nome"];
  $idade = $_POST["idade"];
  $datanascimento = $_POST["datanascimento"];
  $endereco = $_POST["endereco"];
  $status = $_POST["status"];

  // Validação dos campos
  $errors = array();

  if ($idade < 0) {
    $errors[] = "A idade não pode ser negativa.";
  }

  if (count($errors) > 0) {
    // Se houver erros, exibe a mensagem de erro e não executa a atualização no banco de dados.
    foreach ($errors as $error) {
      echo "<p style='color: red;'>$error</p>";
    }
  } else {
    // Prepara e executa a query para atualizar os dados do aluno no banco de dados
    $stmt = $conn->prepare("UPDATE Aluno SET nome = :nome, idade = :idade, datanascimento = :datanascimento, endereco = :endereco, estatus = :status WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':idade', $idade);
    $stmt->bindParam(':datanascimento', $datanascimento);
    $stmt->bindParam(':endereco', $endereco);
    $stmt->bindParam(':status', $status);

    $stmt->execute();

    // Redireciona para a página principal de alunos
    header("Location: index.php");
    exit();
  }
}

// Obtém os dados do aluno a serem alterados do banco de dados
$stmt = $conn->prepare("SELECT * FROM Aluno WHERE id = :id");
$stmt->bindParam(':id', $id);
$stmt->execute();
$aluno = $stmt->fetch(PDO::FETCH_ASSOC);

// Verifica se o aluno existe
if (!$aluno) {
  // Redireciona de volta para a página principal de alunos
  header("Location: index.php");
  exit();
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Alterar Aluno</title>
  <link rel="stylesheet" type="text/css" href="../style.css">
</head>

<body class="pagina_fundo">
  <div class="caixa_form">
    <a class="voltar" href="index.php">Gerenciar Aluno</a>
    <h1>Alterar Aluno</h1>
    <form method="POST">
      <input type="hidden" name="id" value="<?php echo $aluno['id']; ?>">
      <label for="nome">Nome:</label>
      <input type="text" name="nome" id="nome" value="<?php echo $aluno['nome']; ?>" required>
      <br><br>
      <label for="idade">Idade:</label>
      <input type="number" name="idade" id="idade" value="<?php echo $aluno['idade']; ?>" required>
      <br><br>
      <label for="datanascimento">Data de Nascimento:</label>
      <input type="date" name="datanascimento" id="datanascimento" value="<?php echo $aluno['datanascimento']; ?>" required>
      <br><br>
      <label for="endereco">Endereço:</label>
      <input type="text" name="endereco" id="endereco" value="<?php echo $aluno['endereco']; ?>" required>
      <br><br>
      <label for="status">Status:</label>
      <select name="status" id="status" required>
          <option value="<?php echo $aluno['estatus']; ?>"><?php echo $aluno['estatus']; ?></option>
          <option value="AP">Aprovado</option>
          <option value="RP">Reprovado</option>
          <option value="TP">Trancado</option>
      </select>
      <br><br>
      <input type="submit" value="Alterar">
    </form>
  </div>
</body>

</html>
