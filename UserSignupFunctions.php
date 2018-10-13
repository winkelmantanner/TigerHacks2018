<?php

include_once 'DatabaseFunctions.php' ;
include_once 'UserFunctions.php' ;

function OutputUserSignupPageBody ( )
{
  OutputUserSignupIntroText ( ) ;
  OutputUserSignupForm ( ) ;
}

function OutputUserSignupIntroText ( )
{
  $IntroHTML = "<h1>User Signup</h1>" ;
  
  echo $IntroHTML ;
}

function OutputUserSignupForm ( )
{
  $UserSignupFormText = '
	<form action="UserSignup.php" method="POST" enctype="multipart/form-data">
    <h2>User Name</h2>
	<input type="test" name="Username" />
    <br>
    <h2>Password</h2>
	<input type="test" name="Password" />
    <br>
	<h2>First Name</h2>
	<input type="test" name="FirstName" />
    <br>
    <h2>Last Name</h2>
	<input type="test" name="LastName" />
    <br>
	<input type="submit" name="submit" value="Sign up" />
</form>' ;

echo $UserSignupFormText ;
}

function InsertUser ( $AssocArray )
{
  $UserName = $AssocArray [ 'Username' ] ;
  $Password = $AssocArray [ 'Password' ] ;
  $FirstName = $AssocArray [ 'FirstName' ] ;
  $LastName = $AssocArray [ 'LastName' ] ;
  
  $SQL  = "INSERT INTO USER ( UserName , Password , FirstName , LastName )
VALUES ( '$UserName' , '$Password' , '$FirstName' , '$LastName' ) ;" ;
  $Result = RunSQLAgainstDefaultDatabase ( $SQL ) ;
}

function SubmitData ( )
{
  $Username = $_POST [ 'Username' ] ;
  $Password = $_POST [ 'Password' ] ;
  $IsInTable = False ;
    
  if ( IsUserInTable ( $Username , $Password ) == True )
  {
    Alert ( "That username is already taken." ) ;
  }
  else
  {
    InsertUser ( $_POST ) ;
    $_SESSION [ "Username" ] = $Username ;
    $_SESSION [ "Password" ] = $Password ;
    header("Location:UserHome.php");
    exit;
  }
    
}

?>