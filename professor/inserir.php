<!DOCTYPE html>
<html>
<head>
  <title>Inserir Professor</title>
  <link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body class="pagina_fundo">
  <div class="caixa_form">
  <a class="voltar" href="index.php">Gerenciar professor</a>
      <h1>Inserir Professor</h1>
      <form method="post" action="inserir.php">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required>
        <label for="cpf">CPF:</label>
        <input type="text" id="cpf" name="cpf" required>
        <label for="idade">Idade:</label>
        <input type="number" id="idade" name="idade" required>
        <label for="datanascimento">Data de Nascimento:</label>
        <input type="date" id="datanascimento" name="datanascimento" required>
        <label for="endereco">Endereço:</label>
        <input type="text" id="endereco" name="endereco" required>
        <label for="status">Status:</label>
        <input type="text" id="status" name="status" required>
        <input type="submit" value="Inserir">
      </form>
  </div>
</body>
</html>

<?php

require_once "../conn.php";

// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nome = $_POST["nome"];
  $cpf = $_POST["cpf"];
  $idade = $_POST["idade"];
  $datanascimento = $_POST["datanascimento"];
  $endereco = $_POST["endereco"];
  $status = $_POST["status"];

  // Prepara e executa a query para inserir o professor no banco de dados
  $stmt = $conn->prepare("INSERT INTO Professor (nome, cpf, idade, datanascimento, endereco, estatus) VALUES (:nome, :cpf, :idade, :datanascimento, :endereco, :status)");
  $stmt->bindParam(':nome', $nome);
  $stmt->bindParam(':cpf', $cpf);
  $stmt->bindParam(':idade', $idade);
  $stmt->bindParam(':datanascimento', $datanascimento);
  $stmt->bindParam(':endereco', $endereco);
  $stmt->bindParam(':status', $status);

  $stmt->execute();

  // Redireciona para a página principal de professores
  header("Location: index.php");
  exit();
}
?>
