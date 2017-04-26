<?php

function ft_is_sort($tab) {
    $array = $tab;
    sort($array);
    if ($array === $tab)
      return TRUE;
    $reverse = array_reverse($array);
    if ($reverse === $tab)
      return TRUE;
    return FALSE;
}

?>
