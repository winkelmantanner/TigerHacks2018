
<?php
include_once 'SessionFunctions.php' ;
include_once 'WebpageFunctions.php' ;
include_once 'GenericPage.php' ;
include_once 'ArtistModifyFunctions.php' ;

function Main ( )
{
  ContinueSession ( ) ;
  if ( IsSubmitted ( ) )
	{
		SubmitData ( ) ;
	}
	else
	{
		OutputGenericPageTop ( ) ;
		OutputArtistModifyPageBody ( ) ;
		OutputGenericPageEnd ( ) ;
	}
}

Main ( ) ;
?>