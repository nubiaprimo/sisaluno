<?php
require_once "../conn.php";

// Verifica se o parâmetro professor está presente na URL
if (isset($_GET['professor'])) {
    $professorId = $_GET['professor'];

    // Prepara e executa a query para selecionar as disciplinas do professor
    $stmt = $conn->prepare("SELECT Disciplina.id, Disciplina.nomedisciplina 
                            FROM Disciplina
                            WHERE Disciplina.idprofessor = :idprofessor");
    $stmt->bindParam(':idprofessor', $professorId);
    $stmt->execute();
    $disciplinas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($disciplinas) === 0) {
        echo "Professor não está associado a nenhuma disciplina.";
        exit;
    }
} else {
    echo "ID do professor não especificado.";
    exit;
}

$media = "";
// Verifica se o formulário foi submetido
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $alunoId = $_POST['aluno'];
    $nota1 = $_POST['nota1'];
    $nota2 = $_POST['nota2'];
    $disciplinaId = $_POST['disciplina'];

    // Calcula a média das notas
    $media = ($nota1 + $nota2) / 2;

    // Verifica se o aluno está matriculado na disciplina
    $stmt = $conn->prepare("SELECT id FROM DisciplinasAluno WHERE idaluno = :idaluno AND iddisciplina = :iddisciplina");
    $stmt->bindParam(':idaluno', $alunoId);
    $stmt->bindParam(':iddisciplina', $disciplinaId);
    $stmt->execute();
    $idRegistroExistente = $stmt->fetchColumn();

    if ($idRegistroExistente) {
        // Atualiza as notas e a média na tabela DisciplinasAluno
        $stmt = $conn->prepare("UPDATE DisciplinasAluno SET nota1 = :nota1, nota2 = :nota2, media = :media WHERE id = :idRegistroExistente");
        $stmt->bindParam(':nota1', $nota1);
        $stmt->bindParam(':nota2', $nota2);
        $stmt->bindParam(':media', $media);
        $stmt->bindParam(':idRegistroExistente', $idRegistroExistente);
        $stmt->execute();
    } else {
        // Insere um novo registro com as notas e a média na tabela DisciplinasAluno
        $stmt = $conn->prepare("INSERT INTO DisciplinasAluno (idaluno, iddisciplina, nota1, nota2, media)
                                VALUES (:idaluno, :iddisciplina, :nota1, :nota2, :media)");
        $stmt->bindParam(':idaluno', $alunoId);
        $stmt->bindParam(':iddisciplina', $disciplinaId);
        $stmt->bindParam(':nota1', $nota1);
        $stmt->bindParam(':nota2', $nota2);
        $stmt->bindParam(':media', $media);
        $stmt->execute();

        // Redireciona para a página principal de disciplinas
        header("Location: index.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Inserir Nota</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body class="pagina_fundo">
    <div class="caixa_form">
        <a class="voltar" href="index.php">Voltar</a>
        <h1>Inserir Nota</h1>
      
        <h4 class="aviso">Para lançar as notas os alunos precisam estar matriculados na disciplina</h4>
        <br>
        <form method="post" action="">
            <input type="hidden" name="professor" value="<?php echo $professorId; ?>">
            
            <label for="disciplina">Disciplina:</label>
            <select name="disciplina" id="disciplina" required>
                <option value="">Selecione a Disciplina</option>
                <?php foreach ($disciplinas as $disciplina) { ?>
                    <option value="<?php echo $disciplina['id']; ?>"><?php echo $disciplina['nomedisciplina']; ?></option>
                <?php } ?>
            </select>
            
            <br><br>
            
            <label for="aluno">Aluno:</label>
            <select name="aluno" id="aluno" required>
                <option value="">Selecione o Aluno</option>
                <?php
                // Carrega os alunos da disciplina selecionada
                foreach ($disciplinas as $disciplina) {
                    $stmt = $conn->prepare("SELECT Aluno.id, Aluno.nome 
                                            FROM Aluno
                                            INNER JOIN DisciplinasAluno ON Aluno.id = DisciplinasAluno.idaluno
                                            WHERE DisciplinasAluno.iddisciplina = :iddisciplina");
                    $stmt->bindParam(':iddisciplina', $disciplina['id']);
                    $stmt->execute();
                    $alunos = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    
                    foreach ($alunos as $aluno) { ?>
                        <option value="<?php echo $aluno['id']; ?>"><?php echo $aluno['nome']; ?></option>
                    <?php }
                }
                ?>
            </select>
            
            <br><br>
            
            <label for="nota1">Insira a 1ª Nota:</label>
            <input type="text" name="nota1" id="nota1">
            
            <br><br>
            
            <label for="nota2">Insira a 2ª Nota:</label>
            <input type="text" name="nota2" id="nota2">
            
            <br><br>
            
            <label for="media">Média:</label>
            <input type="text" name="media" id="media" value="<?php echo $media; ?>" readonly>
            
            <br><br>
            
            <input type="submit" value="Inserir Nota">
        </form>
    </div>
</body>
</html>
