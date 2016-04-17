<?php
function data_uri($file, $mime)
{
  $contents = file_get_contents($file);
  $base64   = base64_encode($contents);
  return 'data:' . $mime . ';base64,' . $base64;
}



print data_uri(dirname(__DIR__).'/core/theme/logo.png', 'image/png').PHP_EOL.PHP_EOL;

?>