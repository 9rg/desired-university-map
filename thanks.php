<!DOCTYPE HTML>
<html lang="ja">
<head>
  <meta  charset=UTF-8>
  <meta name="viewpoint" user-scalable=no>
  <title>志望校MAP</title>
  <link href="style.css" rel="stylesheet">
</head>

<body>
  <header>
    <a href="index.php"><h1>志望校MAP</h1></a>
    <nav>
      <ul>
        <li><button type="button" onclick="location.href='map.php'">マップ</button></li>
        <li><button type="button" onclick="location.href='index.php'">条件設定</button></li>
        <li><button type="button" onclick="location.href='aboutsite.html'">当サイトについて</button></li>
        <li><button type="button" onclick="location.href='opinionBox.html'">ご意見箱</button></li>
      </ul>
    </nav>
  </header>

  <main>
    <?php
    $type = $_POST['type'];
    $name = $_POST['name'];
    if(!$name){
      $name .= '匿名';
    }
    $contents = $_POST['opinion'];

    require_once __DIR__.'/vendor/autoload.php';//環境変数から値を取得
    $dotenv = Dotenv\Dotenv::create(__DIR__);
    $dotenv->load();
    $mysqli = new mysqli( getenv('MYSQLHOSTNAME'), getenv('MYSQLUSERNAME'), getenv('MYSQLPASSWORD'), getenv('MYSQLDBNAME'));
    if($mysqli->connect_error){
      echo $mysqli->connect_error;
      exit();
    }
    else{
      $mysqli->set_charset("utf-8");
    }
    /*プリペアードステートメント処理*/
    $stmt = $mysqli->prepare("INSERT INTO opinions (type, name, contents) VALUES (?,?,?)");//SQL文を作成
    $stmt->bind_param('iss', $type, $name, $contents);//変数をバインド(代入っぽい感じ)
    $stmt->execute();//SQL文の実行
    $stmt->close();//stmtクラスを閉じる
    $mysqli->close();//データベースとの接続を閉じる
    ?>

    <section class="thanksMessage">
      <p>ご意見ありがとうございました。</p>
      <button class="toSearch" onclick="location.href='index.php'">ホームに戻る</button>
