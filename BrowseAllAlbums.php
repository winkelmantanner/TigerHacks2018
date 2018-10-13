<?php
include_once 'GenericPage.php' ;
include_once 'BrowseAllAlbumsFunctions.php' ;

function Main ( )
{
  ContinueSession ( ) ;
  if ( IsSubmitted ( ) )
	{
    OutputGenericPageTop ( ) ;
	  SubmitData ( ) ;
    OutputGenericPageEnd ( ) ;
	}
	else
	{
	  OutputGenericPageTop ( ) ;
	  OutputBrowseAllAlbumsPageBody  ( '' ) ;
	  OutputGenericPageEnd ( ) ;
	}
}

Main ( )
?>