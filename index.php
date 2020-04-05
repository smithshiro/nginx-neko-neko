<?php
session_start();
if (!isset($_SESSION['count'])) {
    $_SESSION['count'] = 0;
} else {
    $_SESSION['count']++;
}
$access_count = $_SESSION['count'];
?>
<!doctype html>
<html>
  <head>
    <meta charset="utf-8" />
    <link href="css/style.css" rel="stylesheet" />
    <script
      src="https://code.jquery.com/jquery-3.4.1.min.js"
      integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
      crossorigin="anonymous">
    </script>
    <script src="js/main.js"></script>
  </head>
  <body>
    <div class="wrapper">
      <div>
        <h1>猫さん</h1>
        <div class="cat">
          <img src="/image/sample.jpg" />
          <div class="reply js-view-reply">
            <p><?php echo $access_count; ?>回目のアクセスにゃ</p>
          </div>
        </div>
      </div>
      <div>
        <form method="POST" class="js-form form">
          <input type="text" name="name" value="名無しの猫" class="name" />
          <textarea type="text" name="comment" class="comment"></textarea>
          <input type="submit" class="submit-button" value="投稿" />
        </form>
      </div>
      <div class="js-load-posts post-rows">
      </div>
    </div>
  </body>
</html>
