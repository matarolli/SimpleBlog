<?php
require_once 'db.php';

$sql   = "SELECT * FROM posts ORDER BY created_at DESC";
$query = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Blog Simples</title>
    <!-- <link rel="stylesheet" href="style.css"> -->

</head>

<body class="center">
    <h1>Bem-vindo ao Blog</h1>
    <p><a href=" create_post.php">Criar novo post</a> | <a href="admin.php">Administração</a></p>
    <hr>

    <?php if ($query && $query->num_rows > 0): ?>
        <?php while ($row = $query->fetch_assoc()): ?>
            <h2><?php echo htmlspecialchars($row['title']); ?></h2>

            <!-- Se existir imagem cadastrada, exibe a tag <img> -->
            <?php if (!empty($row['image'])): ?>
                <p><img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="Imagem do post" width="200"></p>
            <?php endif; ?>

            <p><?php echo nl2br(htmlspecialchars($row['content'])); ?></p>
            <small>Criado em: <?php echo $row['created_at']; ?></small>
            <hr>
        <?php endwhile; ?>
    <?php else: ?>
        <p>Não há posts cadastrados.</p>
    <?php endif; ?>

</body>

</html>