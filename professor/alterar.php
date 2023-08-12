<?php
// Código para conexão com o banco de dados
require_once "../conn.php";

// Verifica se o ID do professor foi fornecido
if (!isset($_GET["id"])) {
  // Redireciona de volta para a página principal de professores
  header("Location: index.php");
  exit();
}

$id = $_GET["id"];

// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nome = $_POST["nome"];
  $cpf = $_POST["cpf"];
  $idade = $_POST["idade"];
  $datanascimento = $_POST["datanascimento"];
  $endereco = $_POST["endereco"];
  $status = $_POST["status"];

  // Prepara e executa a query para atualizar os dados do professor no banco de dados
  $stmt = $conn->prepare("UPDATE Professor SET nome = :nome, cpf = :cpf, idade = :idade, datanascimento = :datanascimento, endereco = :endereco, estatus = :status WHERE id = :id");
  $stmt->bindParam(':id', $id);
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

// Obtém os dados do professor a serem alterados do banco de dados
$stmt = $conn->prepare("SELECT * FROM Professor WHERE id = :id");
$stmt->bindParam(':id', $id);
$stmt->execute();
$professor = $stmt->fetch(PDO::FETCH_ASSOC);

// Verifica se o professor existe
if (!$professor) {
  // Redireciona de volta para a página principal de professores
  header("Location: index.php");
  exit();
}
?>
<!DOCTYPE html>
<html>

<head>
  <title>Alterar Professor</title>
  <link rel="stylesheet" type="text/css" href="../style.css">
</head>

<body class="pagina_fundo">
  <div class="caixa_form">
    <a class="voltar" href="index.php">Gerenciar professor</a>
    <h1>Alterar Professor</h1>
    <form method="POST">
      <input type="hidden" name="id" value="<?php echo $professor['id']; ?>">
      <label for="nome">Nome:</label>
      <input type="text" name="nome" id="nome" value="<?php echo $professor['nome']; ?>" required>
      <br><br>
      <label for="cpf">CPF:</label>
      <input type="text" name="cpf" id="cpf" value="<?php echo $professor['cpf']; ?>" required>
      <br><br>
      <label for="idade">Idade:</label>
      <input type="number" name="idade" id="idade" value="<?php echo $professor['idade']; ?>" required>
      <br><br>
      <label for="datanascimento">Data de Nascimento:</label>
      <input type="date" name="datanascimento" id="datanascimento" value="<?php echo $professor['datanascimento']; ?>" required>
      <br><br>
      <label for="endereco">Endereço:</label>
      <input type="text" name="endereco" id="endereco" value="<?php echo $professor['endereco']; ?>" required>
      <br><br>
      <label for="status">Status:</label>
      <input type="text" name="status" id="status" value="<?php echo $professor['estatus']; ?>" required>
      <br><br>
      <input type="submit" value="Alterar">
    </form>
  </div>
</body>

</html>