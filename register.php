<?php
require 'db.php';

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!empty($username) && !empty($password)) {
        $checkUser = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $checkUser->execute(['username' => $username]);
        
        if ($checkUser->rowCount() > 0) {
            echo "このユーザー名は既に使用されています。";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['username' => $username, 'password' => $hashedPassword]);

            echo "ユーザー登録が完了しました";
        }
    } else {
        echo "すべてのフィールドを入力してください。";
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ユーザー登録</title>
</head>
<body>
    <h2>ユーザー登録</h2>
    <form action="register.php" method="POST">
        <label for="username">ユーザー名:</label>
        <input type="text" name="username" required><br>

        <label for="password">パスワード:</label>
        <input type="password" name="password" required><br>

        <button type="submit">登録</button>
    </form>
    <form action="login.php" method="GET">
        <button type="submit">ログインページへ戻る</button>
    </form>
</body>
</html>
