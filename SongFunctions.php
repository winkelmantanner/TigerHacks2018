<?php

include_once 'DatabaseFunctions.php' ;

function IncrementNumberPlays ( $SongID )
{
  $SQL = "UPDATE SONG
  SET NumberPlays = NumberPlays + 1
  WHERE SongID = $SongID" ;
  $Result = RunSQLAgainstDefaultDatabase ( $SQL ) ;
}

?>