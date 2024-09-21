<?php
try {
    // PDOでデータベースに接続
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=test;port=8889;charset=utf8', 'root', 'root');
    // エラーモードを例外に設定
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // エラーが発生した場合、エラーメッセージを表示して終了
    echo 'データベース接続に失敗しました: ' . $e->getMessage();
    exit;
}
?>
