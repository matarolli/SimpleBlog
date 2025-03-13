<?php
require_once 'db.php';

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title   = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';

    //    Variável para armazenar o nome do arquivo da imagem (caso exista)
    $imageName = null;

    // Verifica se foi enviada alguma imagem pelo formulário
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        // Caminho temporário do arquivo
        $tmpFile  = $_FILES['image']['tmp_name'];
        // Nome original do arquivo (ex: foto.jpg)
        $origName = $_FILES['image']['name'];

        // Para evitar possíveis conflitos de nomes, podemos gerar um nome único
        $imageName = uniqid() . '_' . $origName;

        // Caminho de destino para salvar a imagem (pasta "uploads/")
        $destination = __DIR__ . '/uploads/' . $imageName;

        // Move o arquivo do caminho temporário para a pasta de destino
        if (!move_uploaded_file($tmpFile, $destination)) {
            $erro = "Erro ao salvar a imagem. Verifique as permissões da pasta uploads.";
        }
    }

    if (!empty($title) && !empty($content)) {
        // Preparar e executar o INSERT
        $stmt = $conn->prepare("INSERT INTO posts (title, content, image) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $title, $content, $imageName);
        $stmt->execute();

        // Redireciona para a página inicial
        header("Location: index.php");
        exit;
    } else {
        if (!isset($erro)) {
            $erro = "Por favor, preencha título e conteúdo!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Criar Post</title>
</head>

<body>
    <h1>Criar Novo Post</h1>
    <p><a href="index.php">Voltar à listagem</a></p>
    <hr>

    <?php if (isset($erro)): ?>
        <p style="color:red;"><?php echo $erro; ?></p>
    <?php endif; ?>

    <!-- O enctype="multipart/form-data" é ESSENCIAL para enviar arquivos via POST -->
    <form action="" method="post" enctype="multipart/form-data">
        <label for="title">Título:</label><br>
        <input type="text" name="title" id="title" required><br><br>

        <label for="content">Conteúdo:</label><br>
        <textarea name="content" id="content" rows="5" cols="30" required></textarea><br><br>

        <label for="image">Imagem:</label><br>
        <input type="file" name="image" id="image" accept="image/*"><br><br>

        <button type="submit">Criar Post</button>
    </form>
</body>

</html>