<?php

echo "123";

$docRoot=$_SERVER['DOCUMENT_ROOT'];
echo $docRoot;

require_once $docRoot.'/config.php';
(new Functions())->uploadImage();

?>