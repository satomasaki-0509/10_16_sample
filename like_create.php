<?php
// var_dump($_GET);
// exit();

session_start();
include("functions.php");
check_session_id();

$todo_id = $_GET['todo_id'];
$user_id = $_GET['user_id'];

// DB接続
$pdo = connect_to_db();

// データ登録SQL作成
// `created_at`と`updated_at`には実行時の`sysdate()`関数を用いて実行時の日時を入力する
$sql = 'INSERT INTO like_table(id, user_id, todo_id, created_at,) 
VALUES(NULL, :user_id, :todo_id, sysdate())';

// SQL準備&実行
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':todo_id', $todo_id, PDO::PARAM_STR);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
$status = $stmt->execute();

// データ登録処理後
if ($status == false) {
  // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
} else {
  // 正常にSQLが実行された場合は入力ページファイルに移動し，入力ページの処理を実行する
  header("Location:todo_read.php");
  exit();
}
