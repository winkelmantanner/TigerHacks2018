<?php

include_once 'DatabaseFunctions.php' ;

function OutputArtistLoginPageBody ( )
{
  OutputArtistLoginIntroText ( ) ;
  OutputArtistLoginForm ( ) ;
}

function OutputArtistLoginIntroText ( )
{
  $IntroHTML = "<h1>Artist Login</h1>" ;
  
  echo $IntroHTML ;
}

function OutputArtistLoginForm ( )
{
  $ArtistSignupFormText = '
	<form action="ArtistLogin.php" method="POST" enctype="multipart/form-data">
    <h2>Artist Name</h2>
	<input type="test" name="ArtistName" />
    <br>
    <h2>Password</h2>
	<input type="test" name="Password" />
    <br>
	<input type="submit" name="submit" value="Log In" />
</form>' ;

echo $ArtistSignupFormText ;
}

function OutputArtistSignupPageBody ( )
{
  OutputArtistSignupForm ( ) ;
}

function SubmitData ( )
{
  $ArtistName = $_POST [ 'ArtistName' ] ;
  $Password = $_POST [ 'Password' ] ;
    
  if ( IsArtistInTable ( $ArtistName , $Password ) == True )
  {
    $_SESSION [ "ArtistName" ] = $ArtistName ;
    $_SESSION [ "Password" ] = $Password ;
    header("Location:ArtistHome.php");
    exit;
  }
  else
  {
    Alert ( "That artist does not exist." ) ;
    header("Location:ArtistLogin.php");
    exit;
  }
    
}

?>