<?php
require_once "../conn.php";

// Verifica se o parâmetro disciplina está presente na URL
if (isset($_GET['disciplina'])) {
    $disciplinaId = $_GET['disciplina'];

    // Prepara e executa a query para selecionar a disciplina
    $stmt = $conn->prepare("SELECT * FROM Disciplina WHERE id = :iddisciplina");
    $stmt->bindParam(':iddisciplina', $disciplinaId);
    $stmt->execute();
    $disciplina = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$disciplina) {
        echo "Disciplina não encontrada.";
        exit;
    }
} else {
    echo "ID da disciplina não especificado.";
    exit;
}

// Variável para armazenar a notificação
$notification = "";

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $alunoId = $_POST['aluno'];

    // Verifica se o aluno já está matriculado na disciplina
    $stmt = $conn->prepare("SELECT COUNT(*) FROM DisciplinasAluno WHERE idaluno = :idaluno AND iddisciplina = :iddisciplina");
    $stmt->bindParam(':idaluno', $alunoId);
    $stmt->bindParam(':iddisciplina', $disciplinaId);
    $stmt->execute();
    $count = $stmt->fetchColumn();

    if ($count === 0) {
        // Insere o aluno na disciplina apenas se não estiver matriculado
        $stmt = $conn->prepare("INSERT INTO DisciplinasAluno (idaluno, iddisciplina) VALUES (:idaluno, :iddisciplina)");
        $stmt->bindParam(':idaluno', $alunoId);
        $stmt->bindParam(':iddisciplina', $disciplinaId);

        if ($stmt->execute()) {
            // Redireciona para a página principal de alunos
            header("Location: index.php");
            exit();
        }
    } else {
        $notification = "Aluno já está matriculado nesta disciplina.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Matricular Aluno</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body class="pagina_fundo">
    <div class="caixa_form">
        <a class="voltar" href="index.php">Voltar</a>
        <h1>Matricular Aluno</h1>
        
        <form method="post">
            <input type="hidden" name="disciplina" value="<?php echo $disciplinaId; ?>">
            <?php if (!empty($notification)) { ?>
                <h3 class="aviso"><?php echo $notification; ?></h3>
                <br>
            <?php } ?>
            <label for="aluno">Selecione o Aluno:</label>
            <select name="aluno" id="aluno" required>
                <option value="">Selecione o Aluno</option>
                <?php
                // Carrega todos os alunos
                $stmt = $conn->prepare("SELECT * FROM Aluno");
                $stmt->execute();
                $alunos = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($alunos as $aluno) {
                    echo "<option value=\"{$aluno['id']}\">{$aluno['nome']}</option>";
                }
                ?>
            </select>
            
            <br><br>
            
            <input type="submit" value="Matricular Aluno">
        </form>
    </div>
</body>
</html>




