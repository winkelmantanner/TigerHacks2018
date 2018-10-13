<?php

include_once 'DatabaseFunctions.php' ;

function OutputPlaylistCreatePageBody ( )
{
  OutputPlaylistCreateIntroText ( ) ;
  OutputPlaylistCreateForm ( ) ;
}

function OutputPlaylistCreateIntroText ( )
{
  $IntroHTML = "<h1>Create Playlist</h1>" ;
  
  echo $IntroHTML ;
}

function OutputPlaylistCreateForm ( )
{
  $PlaylistCreateFormHTML = '
<form action="PlaylistCreate.php" method="POST" enctype="multipart/form-data">
    <h2>Playlist Name</h2>
	<input type="test" name="PlaylistName" />
    <br>
    <h2>Thumbnail</h2>
	<input type="file" name="Thumbnail">
    <br>
	<input type="submit" name="submit" value="Create Playlist" />
</form>
' ;

  echo $PlaylistCreateFormHTML ;
}

function InsertPlaylist ( $AssocArray , $FileAssocArray )
{
  $Username = $_SESSION [ 'Username' ] ;
  $Password = $_SESSION [ 'Password' ] ;
  
  $PlaylistName = $AssocArray [ 'PlaylistName' ] ;
  $ThumbnailName = $FileAssocArray [ 'Thumbnail' ] [ 'name' ] ;
  $TempFile = $FileAssocArray [ 'Thumbnail' ] [ 'tmp_name' ] ;
  $ThumbnailPath = "" ;
  
  echo $ThumbnailName ;
  
  $SQL  = "INSERT INTO PLAYLIST ( Name , Thumbnail )
VALUES ( '$PlaylistName' , '$ThumbnailPath' ) ;" ;

  $Connection = CreateDefaultConnectionToDatabase ( ) ;
  $Result = RunSQL ( $Connection , $SQL ) ;
  $NewID = mysqli_insert_id ( $Connection ) ;
  CloseConnectionToDatabase ( $Connection ) ;
  
  // Helpful resource:
  // https://www.w3schools.com/php/php_mysql_insert_lastid.asp
  
  $ThumbnailPath = "Images/Playlists/" . $NewID . "/" . $ThumbnailName ;
  $ThumbnailFolder = "Images/Playlists/" . $NewID ;
  
  echo $ThumbnailPath ;
    echo $ThumbnailFolder ;
  $SQL  = "UPDATE PLAYLIST
  SET Thumbnail = '$ThumbnailPath'
  WHERE PlaylistID = '$NewID' ;" ;
  $Result = RunSQLAgainstDefaultDatabase ( $SQL ) ;
  
  mkdir ( $ThumbnailFolder ) ;
  move_uploaded_file ( $TempFile , $ThumbnailPath ) ;
  
  $SQL  = "INSERT INTO SUBSCRIBE ( PlaylistID , Username , Owns )
VALUES ( '$NewID' , '$Username' , TRUE ) ;" ;
  $Result = RunSQLAgainstDefaultDatabase ( $SQL ) ;
  
}

function SubmitData ( )
{
    
  InsertPlaylist ( $_POST , $_FILES ) ;
  header("Location:UserHome.php") ;
  exit ;
    
}

?>