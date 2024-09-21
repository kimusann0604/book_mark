<?php
// データベース接続
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 受け取ったJSONデータを取得
    $data = json_decode(file_get_contents('php://input'), true);
    
    // JSONデータのキーが存在するか確認
    if (isset($data['imageUrl']) && isset($data['userId'])) {
        $imageUrl = $data['imageUrl'];
        $userId = $data['userId'];
        
        try {
            // シミュレーション結果をデータベースに保存
            $stmt = $pdo->prepare("INSERT INTO bookmarks (user_id, image_url) VALUES (?, ?)");
            $stmt->execute([$userId, $imageUrl]);
            
            echo json_encode(['message' => '保存完了']);
        } catch (PDOException $e) {
            // データベース操作でエラーが発生した場合
            echo json_encode(['message' => '保存に失敗しました', 'error' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['message' => '不正なデータ']);
    }
} else {
    echo json_encode(['message' => 'POSTリクエストのみ対応']);
}
?>
