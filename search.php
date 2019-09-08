<!DOCTYPE HTML>
<html lang="ja">
<head>
  <meta  charset=UTF-8>
  <title>検索フォーム</title>
  <link href="style.css" rel="stylesheet">
</head>

<body>
  <header>
    <a href="map.php"><h1>志望校MAP</h1></a>
    <nav>
      <ul>
        <li><button type="button" onclick="location.href='map.php'">マップ</button></li>
        <li><button type="button" onclick="location.href='search.php'">条件指定</button></li>
        <li><button type="button" onclick="clickEvent()">当サイトについて</button></li>
        <li><button type="button" onclick="clickEvent()">会員登録・ログイン</button></li>
        <script type="text/javascript">
        function clickEvent(){
          alert('近日公開！');
        }
        </script>
      </ul>
    </nab>
  </header>

  <main>
    <div class="searchForm">
      <h2>検索条件の設定</h2>
      <form method="post" action="map.php">
        <p>
        <label for="type">学校の区分</label>
        <select name="type">
          <option value="私立">私立大学</option>
          <option value="国立">国立大学</option>
          <option value="公立">公立大学</option>
          <option value="指定しない">指定しない</option>
        </select></p><br>
        <p>
        <label for="region">地方区分</label>
        <select name="region">
          <option value=""></option>
          <option value="北海道・東北地区">北海道・東北地区</option>
          <option value="関東（茨木・栃木・群馬）">関東（茨木・栃木・群馬）</option>
          <option value="関東（埼玉・千葉・神奈川）">関東（埼玉・千葉・神奈川）</option>
          <option value="関東（東京）">関東（東京）</option>
          <option value="甲信越地区">甲信越地区</option>
          <option value="東海・北陸地区">東海・北陸地区</option>
          <option value="近畿地区">近畿地区</option>
          <option value="中国・四国地区">中国・四国地区</option>
          <option value="九州・沖縄地区">九州・沖縄地区</option>
          <option value="関東・甲信越地区">(国立のみ)関東・甲信越地区</option>
          <option value="東海・北陸・近畿地区">(国立のみ)東海・北陸・近畿地区</option>
        </select></p><br>
        <p>
        <label for="prefecture">都道府県名</label>
        <select name="prefecture">
          <option value=''></option>
          <?php
          $mysqli = new mysqli( 'localhost', 'kuragane', 'VVmmjcU6TYTKJLQJ' ,'kuragane');
          if( $mysqli->connect_errno ) {
            echo $mysqli->connect_errno . ' : ' . $mysqli->connect_error;
          }

          $dbc = mysqli_connect( 'localhost', 'kuragane', 'VVmmjcU6TYTKJLQJ', 'kuragane')
          or die( 'エラー：MySQLサーバとの接続に失敗しました。');

          $query = "SELECT * FROM prefecture_table";
          $result = mysqli_query($dbc, $query)
          or die( 'エラー：データベースとの問い合わせに失敗しました。');

          while($row = mysqli_fetch_array($result)){
            $prefecture = $row['prefecture_name'];
            echo '<option value="'.$prefecture.'">'.$prefecture.'</option>';
          }
          $mysqli->close();
          ?>
        </select></p><br>
        <p>
        <label for="faculty">学部</label>
        <select name="faculty">
          <option value=""></option>
          <option value="理工学部">理工学部</option>
          <option value="経済学部">経済学部</option>
        </select></p><br>
        <p>
        <label for="大学院">大学院の有無</label>
        <input name="graduate" type="radio" value="有">有
        <input name="graduate" type="radio" value="無">無</p><br>
        <input type="submit" value="この条件で検索" name="submit" class="go">
      </form>
    </div>
  </main>
</body>
</html>
