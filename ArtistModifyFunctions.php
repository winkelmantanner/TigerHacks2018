<?php

include_once 'DatabaseFunctions.php' ;

function OutputArtistModifyPageBody ( )
{
  OutputArtistModifyIntroText ( ) ;
  OutputArtistModifyForm ( ) ;
}

function OutputArtistModifyIntroText ( )
{
  $IntroHTML = "<h1>Modify Artist</h1>" ;
  
  echo $IntroHTML ;
}

function OutputArtistModifyForm ( )
{
  $ArtistSignupFormText = '
	<form action="ArtistModify.php" method="POST" enctype="multipart/form-data">
    <h2>Artist Name</h2>
	<input type="test" name="ArtistName" />
    <br>
    <h2>Password</h2>
	<input type="test" name="Password" />
    <br>
	<h2>Band Member</h2>
	<input type="test" name="Name1" />
    <br>
    <h2>Band Member</h2>
	<input type="test" name="Name2" />
    <br>
    <h2>Band Member</h2>
	<input type="test" name="Name3" />
    <br>
    <input type="radio" name="ArtistType" value="Soloist" checked>Soloist
    <br>
    <input type="radio" name="ArtistType" value="Band">Band
    <br>
	<input type="submit" name="submit" value="Sign up" />
</form>' ;

echo $ArtistSignupFormText ;
}

function UpdateArtist ( $AssocArray )
{
  $OldArtistName = $_SESSION [ "ArtistName" ] ;
  $ArtistName = $AssocArray [ 'ArtistName' ] ;
  $Name1 = $AssocArray [ 'Name1' ] ;
  $Name2 = $AssocArray [ 'Name2' ] ;
  $Name3 = $AssocArray [ 'Name3' ] ;
  $ArtistType = $AssocArray [ 'ArtistType' ] ;
  $Password = $AssocArray [ 'Password' ] ;
  
	$SQL  = "DELETE FROM BAND2
		WHERE ArtistName = '$OldArtistName' ;" ;
  $Result = RunSQLAgainstDefaultDatabase ( $SQL ) ;
	$SQL  = "DELETE FROM BAND
		WHERE ArtistName = '$OldArtistName' ;" ;
  $Result = RunSQLAgainstDefaultDatabase ( $SQL ) ;
	$SQL  = "DELETE FROM SOLOIST
		WHERE ArtistName = '$OldArtistName' ;" ;
  $Result = RunSQLAgainstDefaultDatabase ( $SQL ) ;
  
  $SQL  = "INSERT INTO ARTIST ( ArtistName , Password )
  VALUES ( '$ArtistName' , '$Password' ) ;" ;
  $Result = RunSQLAgainstDefaultDatabase ( $SQL ) ;
  
  $SQL  = "UPDATE OWNS 
SET ArtistName = '$ArtistName'
WHERE ArtistName = '$OldArtistName' ; " ;
  $Result = RunSQLAgainstDefaultDatabase ( $SQL ) ;
  
  	$SQL  = "DELETE FROM ARTIST
		WHERE ArtistName = '$OldArtistName' ;" ;
  $Result = RunSQLAgainstDefaultDatabase ( $SQL ) ;
  
  if ( $ArtistType == "Soloist" )
  {
      $SQL  = "INSERT INTO SOLOIST ( ArtistName ) VALUES ( '$ArtistName' ) ;" ;
      $Result = RunSQLAgainstDefaultDatabase ( $SQL ) ;
  }
  else
  {
      $SQL  = "INSERT INTO BAND ( ArtistName ) VALUES ( '$ArtistName' ) ;" ;
      $Result = RunSQLAgainstDefaultDatabase ( $SQL ) ;
      $SQL  = "INSERT INTO BAND2 ( ArtistName , MemberName ) VALUES ( '$ArtistName' , '$Name1' ) ;" ;
      $Result = RunSQLAgainstDefaultDatabase ( $SQL ) ;
      $SQL  = "INSERT INTO BAND2 ( ArtistName , MemberName ) VALUES ( '$ArtistName' , '$Name2' ) ;" ;
      $Result = RunSQLAgainstDefaultDatabase ( $SQL ) ;
      $SQL  = "INSERT INTO BAND2 ( ArtistName , MemberName ) VALUES ( '$ArtistName' , '$Name3' ) ;" ;
      $Result = RunSQLAgainstDefaultDatabase ( $SQL ) ;
  }
  $_SESSION [ "ArtistName" ] = $ArtistName ;
  $_SESSION [ "Password" ] = $Password ;
}

function SubmitData ( )
{
  $ArtistName = $_POST [ 'ArtistName' ] ;
  $Password = $_POST [ 'Password' ] ;
  $IsInTable = False ;
    
  if ( IsArtistInTable ( $ArtistName , $Password ) == True )
  {
    Alert ( "That artist name is already taken." ) ;
  }
  else
  {
    UpdateArtist ( $_POST ) ;
    header("Location:ArtistHome.php");
    exit;
  }
    
}

?>