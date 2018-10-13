<?php

function Alert ( $msg )
{
  echo "<script type='text/javascript'>alert('$msg');</script>" ;
}

function HTMLAlert ( $msg )
{
  echo "<html><body><script type='text/javascript'>alert('$msg');</script></html></body>" ;
}

?>