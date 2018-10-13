<?php

include_once 'Navbar.php' ;
include_once 'SessionFunctions.php' ;

function OutputDependencies ( )
{
  $DependeciesText = '
  <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

  <link rel="stylesheet" type="text/css" href="Theme.css">' ;
  
  echo $DependeciesText ;
}

function OutputPageStart ( )
{
  $PageStartText = '<html>' ;
  echo $PageStartText ;
}

function OutputHeaderStart ( )
{
  $HeaderStartText = "<head>" ;
  echo $HeaderStartText ;
}

function OutputHeaderEnd ( )
{
  $HeaderEndText = "</head>" ;
  echo $HeaderEndText ;
}

function OutputBodyStart ( )
{
  $BodyStartText = "<body>" ;
  echo $BodyStartText ;
}

function OutputBodyEnd ( )
{
  $BodyEndText = "</body>" ;
  echo $BodyEndText ;
}

function OutputPageEnd ( )
{
  $PageEndText = "</html>" ;
  echo $PageEndText ;
}

function OutputPageHeader ( )
{
  OutputHeaderStart ( ) ;
  OutputDependencies ( ) ;
  OutputHeaderEnd ( ) ;
}

function OutputGenericPageTop ( )
{
  OutputPageStart ( ) ;
  OutputPageHeader ( ) ;
  OutputBodyStart ( ) ;
  OutputNavbar ( ) ;
}

function OutputGenericPageEnd ( )
{
  OutputBodyEnd ( ) ;
  OutputPageEnd ( ) ;
}

?>