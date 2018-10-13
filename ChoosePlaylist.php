<?php
include_once 'GenericPage.php' ;
include_once 'ChoosePlaylistFunctions.php' ;

function Main ( )
{
  ContinueSession ( ) ;
  OutputGenericPageTop ( ) ;
  OutputChoosePlaylistPageBody ( ) ;
  OutputGenericPageEnd ( ) ;
}

Main ( )
?>