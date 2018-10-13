<?php

include_once 'GenericPage.php' ;
include_once 'DatabaseFunctions.php' ;
include_once 'FileFunctions.php' ;
ContinueSession ( ) ;

$ArtistName = $_SESSION [ "ArtistName" ] ;

$SQL = "
SELECT SONG . SongID AS SongID
FROM ARTIST
RIGHT JOIN OWNS ON ARTIST . ArtistName = OWNS . ArtistName
RIGHT JOIN ALBUM ON OWNS . AlbumID = ALBUM . AlbumID
RIGHT JOIN BELONG_TO ON ALBUM . AlbumID = BELONG_TO . AlbumID
RIGHT JOIN SONG ON BELONG_TO . SongID = SONG . SongID
WHERE ARTIST . ArtistName = '" . $ArtistName . "' " ;
$SongResults = RunSQLAgainstDefaultDatabase ( $SQL ) ;

$SQL = "
SELECT ALBUM . AlbumID AS AlbumID
FROM ARTIST
RIGHT JOIN OWNS ON ARTIST . ArtistName = OWNS . ArtistName
RIGHT JOIN ALBUM ON OWNS . AlbumID = ALBUM . AlbumID
WHERE ARTIST . ArtistName = '" . $ArtistName . "' " ;
$AlbumResults = RunSQLAgainstDefaultDatabase ( $SQL ) ;

$Row = mysqli_fetch_assoc ( $SongResults ) ;
while ( $Row != Null )
{
	$SongID = $Row [ "SongID" ] ;
	$SQL = "
	DELETE
	FROM BELONG_TO
	WHERE SongID = " . $SongID . " ;" ;
	$Results = RunSQLAgainstDefaultDatabase ( $SQL ) ;
	
	
	$SQL = "
	DELETE
	FROM CONTAINS
	WHERE SongID = " . $SongID . " ;" ;
	$Results = RunSQLAgainstDefaultDatabase ( $SQL ) ;
	$Row = mysqli_fetch_assoc ( $SongResults ) ;
	
	
	$SQL = "
	DELETE
	FROM SONG
	WHERE SongID = " . $SongID . " ;" ;
	$Results = RunSQLAgainstDefaultDatabase ( $SQL ) ;
	$Row = mysqli_fetch_assoc ( $SongResults ) ;
	
	$TargetSongDir = "Music/" . $SongID ;
	DeleteFiles ( $TargetSongDir ) ;
}

$SQL = "
DELETE
FROM OWNS
WHERE ArtistName = '" . $ArtistName . "' ;" ;
$Results = RunSQLAgainstDefaultDatabase ( $SQL ) ;


$Row = mysqli_fetch_assoc ( $AlbumResults ) ;
while ( $Row != Null )
{
	$AlbumID = $Row [ "AlbumID" ] ;
	$SQL = "
	DELETE
	FROM ALBUM2
	WHERE AlbumID = " . $AlbumID . " ;" ;
	$Results = RunSQLAgainstDefaultDatabase ( $SQL ) ;
	
	$SQL = "
	DELETE
	FROM ALBUM
	WHERE AlbumID = " . $AlbumID . " ;" ;
	$Results = RunSQLAgainstDefaultDatabase ( $SQL ) ;
	$Row = mysqli_fetch_assoc ( $SongResults ) ;
	
	$TargetAlbumDir = "Images/Albums/" . $AlbumID ;
	DeleteFiles ( $TargetAlbumDir ) ;
	$Row = mysqli_fetch_assoc ( $AlbumResults ) ;
}

$SQL = "
DELETE
FROM SOLOIST
WHERE ArtistName = '" . $ArtistName . "' ;" ;
$Results = RunSQLAgainstDefaultDatabase ( $SQL ) ;

$SQL = "
DELETE
FROM BAND2
WHERE ArtistName = '" . $ArtistName . "' ;" ;
$Results = RunSQLAgainstDefaultDatabase ( $SQL ) ;

$SQL = "
DELETE
FROM BAND
WHERE ArtistName = '" . $ArtistName . "' ;" ;
$Results = RunSQLAgainstDefaultDatabase ( $SQL ) ;

$SQL = "
DELETE
FROM ARTIST
WHERE ArtistName = '" . $ArtistName . "' ;" ;
$Results = RunSQLAgainstDefaultDatabase ( $SQL ) ;

header ( "Location:Logout.php" ) ;
exit ;

?>