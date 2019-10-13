<!DOCTYPE HTML>
<html lang="ja">
<head>
  <meta  charset=UTF-8>
  <meta name="viewpoint" user-scalable=no>
  <title>志望校MAP</title>
  <link href="style.css" rel="stylesheet">
  <script type="text/javascript">
  function check(){//１項目以上入力しているかチェックする関数
    var flag = 0;
    if(document.form1.type.value == ""){
      flag += 1;
    }
    if(document.form1.region.value == ""){
      flag += 1;
    }
    if(document.form1.prefecture.value == ""){
      flag += 1;
    }
    if(document.form1.faculty.value == ""){
      flag += 1;
    }
    if(flag == 4){
      alert('最低１項目、条件を指定してください。');
      return false;
    }
    else{
      return true;
    }
  }
  </script>
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
    <div class="searchForm">
      <h2>検索条件の設定</h2>
      <form method="post" action="map.php" name="form1">
        <p>
          <label for="type">学校の区分</label>
          <select name="type">
            <option value=""></option>
            <option value="1">私立大学</option>
            <option value="2">国立大学</option>
            <option value="3">公立大学</option>
          </select>
        </p><br>
        <p>
          <label for="region">地方区分</label>
          <select name="region">
            <option value=""></option>
            <option value="1">北海道・東北地方</option>
            <option value="2">関東地方</option>
            <option value="3">中部地方</option>
            <option value="4">近畿地方</option>
            <option value="5">中国地方</option>
            <option value="6">四国地方</option>
            <option value="7">九州地方</option>
          </select>
        </p><br>
        <p>
        <label for="prefecture">都道府県名</label>
        <select name="prefecture">
          <option value=''></option>
          <?php//prefecture_tableテーブルからデータを取り出してセレクトボックスに表示
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
              $prefecture = $row['prefecture_name'];
              $id = $row['prefecture_id'];
              echo '<option value="'.$id.'">'.$prefecture.'</option>';
            }
          }
          $mysqli->close();
          ?>
        </select>
      </p><br>
      <p>
        <label for="faculty">学部</label>
        <input type="text" name="faculty" class="faculty" value="" placeholder="検索したい学部系統のキーワードを入力してください。 例：理工">
      </p><br>
      <!--
      <p>
      <label for="大学院">大学院の有無</label>
      <input name="graduate" type="radio" value="有">有
      <input name="graduate" type="radio" value="無">無</p><br>
      -->
      <input type="submit" value="この条件で検索" name="submit" class="go" onclick="return check()">
    </form>
    </div>
  </main>
</body>
</html>
