
<?php
include_once 'GenericPage.php' ;
include_once 'MainPageFunctions.php' ;

function Main ( )
{
  ContinueSession ( ) ;
  OutputGenericPageTop ( ) ;
  OutputMainPageBody ( ) ;
  OutputGenericPageEnd ( ) ;
}

Main ( )
?>