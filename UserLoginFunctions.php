<?php

include_once 'DatabaseFunctions.php' ;

function OutputUserLoginPageBody ( )
{
  OutputUserLoginIntroText ( ) ;
  OutputUserLoginForm ( ) ;
}

function OutputUserLoginIntroText ( )
{
  $IntroHTML = "<h1>User Login</h1>" ;
  
  echo $IntroHTML ;
}

function OutputUserLoginForm ( )
{
  $UserLoginFormText = '
	<form action="UserLogin.php" method="POST" enctype="multipart/form-data">
    <h2>User Name</h2>
	<input type="test" name="Username" />
    <br>
    <h2>Password</h2>
	<input type="test" name="Password" />
    <br>
	<input type="submit" name="submit" value="Log In" />
</form>' ;

echo $UserLoginFormText ;
}

function OutputUserSignupPageBody ( )
{
  OutputUserSignupForm ( ) ;
}

function SubmitData ( )
{
  $Username = $_POST [ 'Username' ] ;
  $Password = $_POST [ 'Password' ] ;
    
  if ( IsUserInTable ( $Username , $Password ) == True )
  {
    $_SESSION [ "Username" ] = $Username ;
    $_SESSION [ "Password" ] = $Password ;
    header("Location:UserHome.php");
    exit;
  }
  else
  {
    Alert ( "That user does not exist." ) ;
    header("Location:UserLogin.php");
    exit;
  }
    
}

?>