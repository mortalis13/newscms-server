<?php

class Format{
  public function date($date) {
    return date_format(date_create($date),'Y-m-d, H:i:s');
  }
}

?>
