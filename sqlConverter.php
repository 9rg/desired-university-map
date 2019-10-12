<?php

$text = '';

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

if($prefecture){
  $mysqli = new mysqli( 'localhost', 'kuragane', 'VVmmjcU6TYTKJLQJ' ,'kuragane');
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

if($faculty){
  $text .= '<br>学部キーワード：'.$faculty;
}

return $text;

?>
