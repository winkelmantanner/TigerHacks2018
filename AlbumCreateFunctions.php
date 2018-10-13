<?php

include_once 'DatabaseFunctions.php' ;

function OutputAlbumCreatePageBody ( )
{
  OutputAlbumCreateIntroText ( ) ;
  OutputAlbumCreateForm ( ) ;
}

function OutputAlbumCreateIntroText ( )
{
  $IntroHTML = "<h1>Create Album</h1>" ;
  
  echo $IntroHTML ;
}

function OutputAlbumCreateForm ( )
{
  $ArtistSignupFormText = '
	<form action="AlbumCreate.php" method="POST" enctype="multipart/form-data">
    <h2>Album Name</h2>
	<input type="test" name="AlbumName" />
    <br>
	<h2>Genre 1</h2>
	<input type="test" name="Genre1" />
    <br>
    <h2>Genre 2</h2>
	<input type="test" name="Genre2" />
    <br>
    <h2>Genre 3</h2>
	<input type="test" name="Genre3" />
    <br>
	<h2>Cover Art</h2>
	<input type="file" name="CoverArt">
    <br>
	<h2>Release Date</h2>
	<input type="date" id="ReleaseDate" name="ReleaseDate">
    <br>
	<input type="submit" name="submit" value="Create Album" />
</form>

<script>

Date.prototype.toDateInputValue = (function() {
    var local = new Date(this);
    local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
    return local.toJSON().slice(0,10);
});

document.getElementById(\'ReleaseDate\').value = new Date().toDateInputValue();


</script>
' ;

echo $ArtistSignupFormText ;
}

function InsertAlbum ( $AssocArray , $FileAssocArray )
{
  $ArtistName = $_SESSION [ 'ArtistName' ] ;
  $Password = $_SESSION [ 'Password' ] ;
  
  $AlbumName = $AssocArray [ 'AlbumName' ] ;
  $Genre1 = $AssocArray [ 'Genre1' ] ;
  $Genre2 = $AssocArray [ 'Genre2' ] ;
  $Genre3 = $AssocArray [ 'Genre3' ] ;
  $CoverArtName = $FileAssocArray [ 'CoverArt' ] [ 'name' ] ;
  $ReleaseDate = $AssocArray [ 'ReleaseDate' ] ;
  $TempFile = $FileAssocArray [ 'CoverArt' ] [ 'tmp_name' ] ;
  $CoverArtPath = "" ;
  
  $ArtistName = $_SESSION [ "ArtistName" ] ;
  
  $SQL  = "INSERT INTO ALBUM ( Name , CoverArt , ReleaseDate )
VALUES ( '$AlbumName' , '$CoverArtPath' , '$ReleaseDate' ) ;" ;

  $Connection = CreateDefaultConnectionToDatabase ( ) ;
  $Result = RunSQL ( $Connection , $SQL ) ;
  $NewID = mysqli_insert_id ( $Connection ) ;
  CloseConnectionToDatabase ( $Connection ) ;
  
  // Helpful resource:
  // https://www.w3schools.com/php/php_mysql_insert_lastid.asp
  
  $CoverArtPath = "Images/Albums/" . $NewID . "/" . $CoverArtName ;
  $CoverArtFolder = "Images/Albums/" . $NewID ;
  
  $SQL  = "UPDATE ALBUM
  SET CoverArt = '$CoverArtPath'
  WHERE AlbumID = '$NewID' ;" ;
  $Result = RunSQLAgainstDefaultDatabase ( $SQL ) ;
  
  mkdir ( $CoverArtFolder ) ;
  move_uploaded_file ( $TempFile , $CoverArtPath ) ;
  
  $SQL  = "INSERT INTO OWNS ( AlbumID , ArtistName )
VALUES ( '$NewID' , '$ArtistName' ) ;" ;
  $Result = RunSQLAgainstDefaultDatabase ( $SQL ) ;
  
  $SQL  = "INSERT INTO ALBUM2 ( AlbumID , Genre ) VALUES ( '$NewID' , '$Genre1' ) ;" ;
  $Result = RunSQLAgainstDefaultDatabase ( $SQL ) ;
  $SQL  = "INSERT INTO ALBUM2 ( AlbumID , Genre ) VALUES ( '$NewID' , '$Genre2' ) ;" ;
  $Result = RunSQLAgainstDefaultDatabase ( $SQL ) ;
  $SQL  = "INSERT INTO ALBUM2 ( AlbumID , Genre ) VALUES ( '$NewID' , '$Genre3' ) ;" ;
  $Result = RunSQLAgainstDefaultDatabase ( $SQL ) ;
  
}

function SubmitData ( )
{
    
  InsertAlbum ( $_POST , $_FILES ) ;
  header("Location:ArtistHome.php") ;
  exit ;
    
}

?>