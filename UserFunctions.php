<?php

include_once 'DatabaseFunctions.php' ;

function DoUserCredentialsExists ( )
{
  $DoExists = False ;
  if ( isset ( $_SESSION [ "Username" ] ) )
  {
    if ( isset ( $_SESSION [ "Password" ] ) )
    {
      $DoExists = True ;
    }
  }
  return $DoExists ;
}

function IsUserInTable ( $Username , $Password )
{
  $IsInTable = False ;
  $SQL = "SELECT * FROM USER WHERE Username = '$Username' 
AND Password = '$Password' ;" ;
  $Result = RunSQLAgainstDefaultDatabase ( $SQL ) ;
  $NumberRows = GetNumberRowsInResults ( $Result ) ;
  if ( $NumberRows > 0 )
  {
    $IsInTable = True ;
  }
  return $IsInTable ;
}

function IsUserLoggedIn ( )
{
  $IsLoggedIn = False ;
  
  if ( DoUserCredentialsExists ( ) == True )
  {
    $AttemptUserName = $_SESSION [ "Username" ] ;
    $AttemptPassword = $_SESSION [ "Password" ] ;
    if ( IsUserInTable ( $AttemptUserName , $AttemptPassword ) == True )
    {
      $IsLoggedIn = True ;
    }
  }
  
  return $IsLoggedIn ;
}

function GetNumberOfPlaylistsOfUser ( )
{
  $Username = $_SESSION [ "Username" ] ;
  $Password = $_SESSION [ "Password" ] ;
  $SQL = "SELECT COUNT( PLAYLIST . PlaylistID ) AS NumberPlaylists
  FROM PLAYLIST
  LEFT JOIN SUBSCRIBE ON PLAYLIST . PlaylistID = SUBSCRIBE . PlaylistID
  LEFT JOIN USER ON SUBSCRIBE . Username = USER . Username
  WHERE SUBSCRIBE . Owns = TRUE AND USER . Username = '$Username' ;" ;
  $Result = RunSQLAgainstDefaultDatabase ( $SQL ) ;
  $Row = mysqli_fetch_assoc ( $Result ) ;
  $NumberPlaylists = $Row [ 'NumberPlaylists' ] ;
  return $NumberPlaylists ;
}

?>