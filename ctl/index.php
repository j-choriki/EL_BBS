<?php

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "EL_BBS";

//投稿時の処理
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $username = $_POST['name'];
    $message = $_POST['post'];

    $sql = "INSERT INTO posts (username, message) VALUES ('$username', '$message')";

    if ($conn->query($sql) === TRUE) {
        // 保存されたIDを取得
        $last_id = $conn->insert_id;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    
    // // 画像アップロード処理
    $img_name = "";
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $file_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION); // 拡張子を取得
        $img_name = basename($_FILES['image']['name']);
        $file_path = "../uploads_img/" . $last_id . "." . $file_extension;
    
        // ディレクトリが存在するか確認し、存在しない場合は作成
        if (!is_dir("../uploads_img/")) {
            mkdir("../uploads_img/", 0777, true);
        }
    
        // if (move_uploaded_file($_FILES['image']['tmp_name'], $file_path)) {
        //     echo "ファイル ". htmlspecialchars($img_name). " がアップロードされました。";
        // } else {
        //     echo "ファイルアップロード中にエラーが発生しました。";
        // }
    } else {
        if (isset($_FILES['image']['error']) && $_FILES['image']['error'] != UPLOAD_ERR_NO_FILE) {
            echo "ファイルアップロードエラー: " . $_FILES['image']['error'];
        }
    }
    


    $sql = "SELECT * FROM posts ORDER BY created_at DESC";
    $result = $conn->query($sql);

    $list = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $post_list = [];
            $post_list['id'] = $row['id'];
            $post_list['name'] = $row['username'];
            $post_list['msg'] = $row['message'];
            $post_list['time'] = $row['created_at'];
             $post_list['good'] = $row['good'];
            $list[] = $post_list;
        }
    } 
    // var_dump($list);
    $conn->close();
    
}else{
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM posts ORDER BY created_at DESC";
    $result = $conn->query($sql);

    $list = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $post_list = [];
            $post_list['id'] = $row['id'];
            $post_list['name'] = $row['username'];
            $post_list['msg'] = $row['message'];
            $post_list['time'] = $row['created_at'];
            $post_list['good'] = $row['good'];

            $list[] = $post_list;
        }
    } 
    $conn->close();
}

require_once('../view/index_html.php');
?>