<?php
include_once 'GenericPage.php' ;
include_once 'BrowseArtistsFunctions.php' ;

function Main ( )
{
  ContinueSession ( ) ;
  OutputGenericPageTop ( ) ;
  OutputBrowseArtistsPageBody ( ) ;
  OutputGenericPageEnd ( ) ;
}

Main ( )
?>