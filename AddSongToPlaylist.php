<?php

include_once 'DatabaseFunctions.php' ;
include_once 'SessionFunctions.php' ;
include_once 'WebpageFunctions.php' ;
include_once 'GenericPage.php' ;
include_once 'ArtistLoginFunctions.php' ;

function Main ( )
{
  ContinueSession ( ) ;
  AddToPlaylist ( ) ;
  header ( "Location:UserHome.php" ) ;
  exit ;
}

function AddToPlaylist ( )
{
  $SongID = $_GET [ "SongID" ] ;
  $PlaylistID = $_GET [ "PlaylistID" ] ;
  $SQL = "INSERT INTO CONTAINS
    ( SongID , PlaylistID )
  VALUES ( $SongID , $PlaylistID ) ;" ;
  $Result = RunSQLAgainstDefaultDatabase ( $SQL ) ;
}

Main ( ) ;
?>