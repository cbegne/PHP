<?php

function connect() {
  $conn = mysqli_connect("localhost");
  if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
  }
  mysqli_query($conn, "USE db");
  return $conn;
}

?>
