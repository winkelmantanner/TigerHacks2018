<?php

include_once 'DatabaseFunctions.php' ;

function OutputSongUploadPageBody ( )
{
  OutputSongUploadIntroText ( ) ;
  OutputSongUploadForm ( ) ;
}

function OutputSongUploadIntroText ( )
{
  $IntroHTML = "<h1>Song Upload</h1>" ;
  
  echo $IntroHTML ;
}

function OutputSongUploadForm ( )
{
  $AlbumID = $_GET [ "AlbumID" ] ;
  $ArtistSignupFormText = '
	<form action="SongUpload.php?AlbumID=' . $AlbumID . '" method="POST" enctype="multipart/form-data">
    <h2>Song Name</h2>
	<input type="text" name="SongName" />
    <br>
	<h2>Length (in seconds)</h2>
	<input type="Number" name="Length" />
    <br>
	<h2>Song File</h2>
	<input type="file" name="SongFile">
    <br>
	<input type="submit" name="submit" value="Upload Song" />
</form>
' ;

echo $ArtistSignupFormText ;
}

function InsertAlbum ( $AssocArray , $FileAssocArray )
{
  $ArtistName = $_SESSION [ 'ArtistName' ] ;
  $Password = $_SESSION [ 'Password' ] ;
  $AlbumID = $_GET [ "AlbumID" ] ;
  
  $SongName = $AssocArray [ 'SongName' ] ;
  $Length = $AssocArray [ 'Length' ] ;
  $SongFileName = $FileAssocArray [ 'SongFile' ] [ 'name' ] ;
  $TempFile = $FileAssocArray [ 'SongFile' ] [ 'tmp_name' ] ;
  $SongFilePath = "" ;
  
  $SQL  = "INSERT INTO SONG ( Name , NumberPlays , Length , FilePath )
VALUES ( '$SongName' , '0' , '$Length' , '$SongFilePath' ) ;" ;

  $Connection = CreateDefaultConnectionToDatabase ( ) ;
  $Result = RunSQL ( $Connection , $SQL ) ;
  $NewID = mysqli_insert_id ( $Connection ) ;
  CloseConnectionToDatabase ( $Connection ) ;
  
  // Helpful resource:
  // https://www.w3schools.com/php/php_mysql_insert_lastid.asp
  
  $SongFilePath = "Music/" . $NewID . "/" . $SongFileName ;
  $SongFileFolder = "Music/" . $NewID ;
  
  $SQL  = "UPDATE SONG
  SET FilePath = '$SongFilePath'
  WHERE SongID = '$NewID' ;" ;
  $Result = RunSQLAgainstDefaultDatabase ( $SQL ) ;
  
  mkdir ( $SongFileFolder ) ;
  move_uploaded_file ( $TempFile , $SongFilePath ) ;
  
  $SQL  = "INSERT INTO BELONG_TO ( AlbumID , SongID )
VALUES ( '$AlbumID' , '$NewID' ) ;" ;
  $Result = RunSQLAgainstDefaultDatabase ( $SQL ) ;
  
}

function SubmitData ( )
{
  $AlbumID = $_GET [ "AlbumID" ] ;
  InsertAlbum ( $_POST , $_FILES ) ;
  header("Location:AlbumHome.php?AlbumID=$AlbumID") ;
  exit ;
    
}

?>