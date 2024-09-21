<?php
// データベース接続
require_once __DIR__ . '/db.php';

// デバッグモード（本番環境ではfalseにする）
$debug = true;

function debug_log($message) {
    global $debug;
    if ($debug) {
        error_log("デバッグ: $message");
    }
}

// エラーメッセージを格納する変数
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // POSTメソッドで送信された場合
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // 入力チェック
    if (empty($username) || empty($password)) {
        $error = '全てのフィールドを入力してください。';
    } else {
        try {
            // データベースからユーザー情報を取得
            $sql = 'SELECT * FROM users WHERE username = :username';
            $stmt = $pdo->prepare($sql);  // $db を $pdo に変更
            $stmt->execute(['username' => $username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                // 認証成功
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                header('Location: saving.html');
                exit;
            } else {
                $error = 'ユーザー名またはパスワードが間違っています。';
            }
        } catch (PDOException $e) {
            debug_log("データベースエラー: " . $e->getMessage());
            $error = 'システムエラーが発生しました。管理者にお問い合わせください。';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 300px; margin: 0 auto; padding: 20px; }
        .error { color: red; margin-bottom: 15px; }
        form { display: flex; flex-direction: column; }
        label { margin-top: 10px; }
        input { margin-bottom: 10px; padding: 5px; }
        button { margin-top: 10px; padding: 10px; cursor: pointer; }
    </style>
</head>
<body>
    <h2>ログイン</h2>
    <?php if ($error): ?>
        <div class="error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
        <label for="username">ユーザー名:</label>
        <input type="text" id="username" name="username" required>

        <label for="password">パスワード:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">ログイン</button>
    </form>
    <form action="register.php" method="get">
        <button type="submit">新規登録</button>
    </form>
</body>
</html>