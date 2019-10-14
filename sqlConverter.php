<?php

$text = '';

/*学校区分の言語化*/
if($type){
  switch ($type) {
    case '1':
    $type = '私立';// code...
    break;
    case '2':
    $type = '国立';
    break;
    case '3':
    $type = '公立';
    break;
    default:
    $type = '';
    break;
  }
  $text .= ' 学校区分：'.$type;
}

/*地方の言語化*/
if($region){
  switch ($region) {
    case '1':
    $region = '北海道・東北地方';
    break;
    case '2':
    $region = '関東地方';
    break;
    case '3':
    $region = '中部地方';
    break;
    case '4':
    $region = '近畿地方';
    break;
    case '5':
    $region = '中国地方';
    break;
    case '6':
    $region = '四国地方';
    break;
    case '7':
    $region = '九州地方';
    break;
    default:
    $region = '';
    break;
  }
  $text .= ' 地方区分：'.$region;
}

/*県の言語化*/
if($prefecture){
  require_once __DIR__.'/vendor/autoload.php';//環境変数から値を取得
  $dotenv = Dotenv\Dotenv::create(__DIR__);
  $dotenv->load();
  $mysqli = new mysqli( getenv('MYSQLHOSTNAME'), getenv('MYSQLUSERNAME'), getenv('MYSQLPASSWORD'), getenv('MYSQLDBNAME'));
  if( $mysqli->connect_error) {
    echo $mysqli->connect_error;
    exit();
  }
  else{
    $mysqli->set_charset("utf-8");
  }
  $sql = "SELECT * FROM prefecture_table";
  if($result = $mysqli->query($sql)){
    while($row = $result->fetch_assoc()){
      if($row['prefecture_id'] == $prefecture){
        $prefecture = $row['prefecture_name'];
      }
    }
    $text .= ' 都道府県：'.$prefecture;
  }
  $mysqli->close();
}

/*学部キーワード付け加える*/
if($faculty){
  $text .= '<br>学部キーワード：'.$faculty;
}

return $text;

?>
