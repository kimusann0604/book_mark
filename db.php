<?php
try {

    $pdo = new PDO('mysql:host='ホスト名';dbname='データベース名';port='port選択';charset=utf8', 'root', 'root');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'データベース接続に失敗しました: ' . $e->getMessage();
    exit;
} 
?>
