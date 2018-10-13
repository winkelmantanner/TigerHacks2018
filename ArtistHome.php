<?php
include_once 'GenericPage.php' ;
include_once 'ArtistHomeFunctions.php' ;

function Main ( )
{
  ContinueSession ( ) ;
  OutputGenericPageTop ( ) ;
  OutputArtistHomePageBody ( ) ;
  OutputGenericPageEnd ( ) ;
}

Main ( )
?>