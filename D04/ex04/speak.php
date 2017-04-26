<?php

session_start();
if ($_SESSION['logged_on_user'] == "") {
  echo "ERROR\n";
  return ;
}
if ($_POST['submit'] == 'OK' && $_POST['msg']) {
  $message['login'] = $_SESSION['logged_on_user'];
  $message['time'] = time();
  $message['msg'] = $_POST['msg'];
  $new_message[] = $message;
  $dir = "../private";
  $chat_file = $dir . "/chat";
  if (file_exists($dir) == FALSE)
    mkdir($dir);
  else if (file_exists($chat_file) == FALSE) {
    $all_messages_serialized = serialize($new_message);
    file_put_contents($chat_file, $all_messages_serialized);
  }
  else {
    $fp = fopen($chat_file, "c+");
    flock($fp, LOCK_SH | LOCK_EX);
    $all_messages_serialized = file_get_contents($chat_file);
    $all_messages = unserialize($all_messages_serialized);
    $all_messages[] = $message;
    $all_messages_serialized = serialize($all_messages);
    file_put_contents($chat_file, $all_messages_serialized);
    flock($fp, LOCK_UN);
    fclose($fp);
  }
}

?>

<html>
  <head>
    <script langage="javascript">top.frames['chat'].location = 'chat.php';</script>
  </head>
  <body>
    <form action="speak.php" method="post">
      <input type="text" name="msg" value="" size="100" autocomplete="off"><br />
      <input type="submit" name="submit" value="OK">
    </form>
  </body>
</html>
