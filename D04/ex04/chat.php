<?php

$dir = "../private";
$chat_file = $dir . "/chat";
date_default_timezone_set('Europe/Paris');
if (file_exists($chat_file) == TRUE) {
  $all_messages_serialized = file_get_contents($chat_file);
  $all_messages = unserialize($all_messages_serialized);
  foreach ($all_messages as $message) {
    echo "[" . date("H:i", $message{'time'}) . "] ";
    echo "<b>" . $message['login']. "</b>" . ": ";
    echo $message['msg'] . "<br />";
  }
}

?>
