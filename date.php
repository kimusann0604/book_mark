<?php
// データベース接６
// データベース接続
include 'db.php';

// ユーザーの保存したブックマークを取得
$user_id = 1;  // ログインしているユーザーIDを使用
$stmt = $pdo->prepare("SELECT * FROM bookmarks WHERE user_id = ?");
$stmt->execute([$user_id]);
$bookmarks = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>保存されたシミュレーション結果</title>
</head>
<body>
    <h1>保存されたシミュレーション結果</h1>
    <ul>
        <?php foreach ($bookmarks as $bookmark): ?>
            <li>
                <img src="<?= htmlspecialchars($bookmark['image_url'], ENT_QUOTES, 'UTF-8') ?>" alt="シミュレーション結果" width="200">
                <p>保存日時: <?= htmlspecialchars($bookmark['created_at'], ENT_QUOTES, 'UTF-8') ?></p>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>