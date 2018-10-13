<?php

include_once 'ArtistFunctions.php' ;
include_once 'DatabaseFunctions.php' ;

const ZERO = 0 ;

function IsSubmitted ( )
{
  $Output = False ;
  if ( isset ( $_POST [ 'submit' ] ) )
  {
    $Output = True ;
  }
  return $Output ;
}

?>