
<?php
include_once 'SessionFunctions.php' ;
include_once 'WebpageFunctions.php' ;
include_once 'GenericPage.php' ;
include_once 'UserSignupFunctions.php' ;

function Main ( )
{
  ContinueSession ( ) ;
  if ( IsSubmitted ( ) )
	{
		SubmitData ( ) ;
	}
	else
	{
	  EndSession ( ) ;
		OutputGenericPageTop ( ) ;
		OutputUserSignupPageBody ( ) ;
		OutputGenericPageEnd ( ) ;
	}
}

Main ( ) ;
?>