<?php
require_once 'db.php';

if (isset($_GET['delete'])) {
    $idToDelete = (int)$_GET['delete'];

    // Opção (avançada): buscar a imagem para deletar do servidor antes de remover o registro do BD
    // $stmtSelect = $conn->prepare("SELECT image FROM posts WHERE id = ?");
    // $stmtSelect->bind_param("i", $idToDelete);
    // $stmtSelect->execute();
    // $resultSelect = $stmtSelect->get_result();
    // $rowSelect = $resultSelect->fetch_assoc();
    // if (!empty($rowSelect['image'])) {
    //     $filePath = __DIR__ . '/uploads/' . $rowSelect['image'];
    //     if (file_exists($filePath)) {
    //         unlink($filePath); // Exclui o arquivo físico
    //     }
    // }

    // Remove o post do banco de dados
    $stmt = $conn->prepare("DELETE FROM posts WHERE id = ?");
    $stmt->bind_param("i", $idToDelete);
    $stmt->execute();

    header("Location: admin.php");
    exit;
}

$sql   = "SELECT * FROM posts ORDER BY created_at DESC";
$query = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Administração</title>
</head>

<body>
    <h1>Administração do Blog</h1>
    <p><a href="index.php">Voltar à página inicial</a></p>
    <hr>

    <?php if ($query && $query->num_rows > 0): ?>
    <table border="1" cellpadding="8">
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Imagem</th>
                <th>Criado em</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $query->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['title']); ?></td>
                <td>
                    <?php if (!empty($row['image'])): ?>
                    <img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="Imagem" width="100">
                    <?php else: ?>
                    Sem imagem
                    <?php endif; ?>
                </td>
                <td><?php echo $row['created_at']; ?></td>
                <td>
                    <a href="?delete=<?php echo $row['id']; ?>"
                        onclick="return confirm('Deseja mesmo excluir este post?');">
                        Excluir
                    </a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <?php else: ?>
    <p>Não há posts cadastrados.</p>
    <?php endif; ?>
</body>

</html>