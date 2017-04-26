<?php

function check_exist($conn, $table, $field, $input) {
  $sql = "SELECT * FROM $table WHERE $field = '$input'";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) > 0)
      return 1;
  return 0;
}

function get_data($conn, $table, $field_to_retrieve, $field_check, $input) {
  $sql = "SELECT $field_to_retrieve FROM $table WHERE $field_check = '$input'";
  $result = mysqli_query($conn, $sql);
  $array = mysqli_fetch_array($result);
  return $array;
}


?>
