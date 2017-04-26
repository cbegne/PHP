<?php

$user = $_SERVER['PHP_AUTH_USER'];
$pw = $_SERVER['PHP_AUTH_PW'];
if ($user == 'zaz' && $pw == 'jaimelespetitsponeys') {
  $image = file_get_contents("../img/42.png");
  $image_64 = base64_encode($image);
?>
<html>
  <body>
    Bonjour Zaz<br />
    <img src='data:image/png;base64,<?php echo $image_64 ?>'><br />
  </body>
</html>
<?php
}
else {
  header("WWW-Authenticate: Basic realm=''Espace membres''");
	header('HTTP/1.0 401 Unauthorized');
  echo "<html><body>Cette zone est accessible uniquement aux membres du site</body></html>";
}

?>
