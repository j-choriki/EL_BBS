<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "EL_BBS";

header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method');
    }

    // デバッグ用: 受信したデータをログに記録
    error_log('$_POST data: ' . print_r($_POST, true));

    $data = json_decode(file_get_contents('php://input'), true);

    // デバッグ用: デコードしたデータをログに記録
    error_log('$data: ' . print_r($data, true));

    if (!isset($data['parentId'])) {
        throw new Exception('parentId is required');
    }

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    $sql = "UPDATE posts SET good = good + 1 WHERE id = ?";

    if ($stmt = $conn->prepare($sql)) {
        // パラメータをバインド
        $stmt->bind_param("i", $data['parentId']);

        // クエリを実行
        if ($stmt->execute()) {
            $updateSuccess = true;
        } else {
            throw new Exception("Error: " . $stmt->error);
        }

        // ステートメントを閉じる
        $stmt->close();
    } else {
        throw new Exception("Error: " . $conn->error);
    }

    if ($updateSuccess) {
        $sql = "SELECT id, good FROM posts WHERE id = ?";
        if ($stmt = $conn->prepare($sql)) {
            // パラメータをバインド
            $stmt->bind_param("i", $data['parentId']);
        
            // クエリを実行
            if ($stmt->execute()) {
                // 結果を取得
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
        
                if ($row) {
                    $response = ['status' => 'success', 'data' => $row];
                } else {
                    $response = ['status' => 'error', 'message' => 'データが見つかりませんでした'];
                }
            } else {
                throw new Exception('クエリの実行に失敗しました: ' . $stmt->error);
            }
        
            // ステートメントを閉じる
            $stmt->close();
        } else {
            throw new Exception('ステートメントの準備に失敗しました: ' . $conn->error);
        }
    }

    // 成功時のレスポンス
    echo json_encode($response);
} catch (Exception $e) {
    // エラーが発生した場合のレスポンス
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
} finally {
    if (isset($conn)) {
        $conn->close();
    }
}
?>
