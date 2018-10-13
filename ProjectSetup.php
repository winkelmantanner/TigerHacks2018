<html>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>

<?php
include 'DatabaseFunctions.php' ;

const SERVER_FAIL_TEXT = "Connection to server failed." ;
const DATABASE_FAIL_TEXT = "Database setup failed" ;
const DATABASE_SUCCESS_TEXT = "Database setup succeeded." ;
const DATABASE_CONNECTION_FAIL_TEXT = "Connection to database failed." ;
const TABLE_EXISTS_TEXT = "Table successsfully exists: " ;
const TABLE_NOT_EXISTS_TEXT = "Table fails to exist: " ;
const TABLE_CREATION_SUCCESS = "Successfully created table " ;
const TABLE_CREATION_FAILED = "Error creating table " ;

const HTML_NEWLINE = "<br>" ;

const DATABASE_SETUP_SQL = "CREATE DATABASE IF NOT EXISTS " ;
const TABLE_VERIFY_SQL = "SHOW TABLES LIKE '" ;
const QUOTATION_MARK = "'" ;
const CREATE_TABLE_SQL = "CREATE TABLE IF NOT EXISTS " ;
const LEFT_PAREN = "(" ;
const RIGHT_PAREN = ")" ;


const TABLE_NAME_POSITION = 0 ;
const COLUMNS_TEXT_POSITION = 1 ;

const TABLES_ARRAY = array (
array ( "USER" ,
    "Username VARCHAR ( 30 ) PRIMARY KEY, 
    FirstName VARCHAR ( 30 ) ,
    LastName VARCHAR ( 30 ) ,
    Password VARCHAR ( 30 ) " ) ,
array ( "PLAYLIST" ,
    "PlaylistID INTEGER AUTO_INCREMENT PRIMARY KEY , 
    Name VARCHAR ( 30 ) ,
    Thumbnail VARCHAR ( 500 ) " ) ,
array ( "SUBSCRIBE" ,
    "PlaylistID INTEGER , 
    Username VARCHAR ( 30 ) ,
    Owns BOOLEAN ,
    PRIMARY KEY ( PlaylistID , Username ) ,
    FOREIGN KEY ( PlaylistID ) REFERENCES PLAYLIST ( PlaylistID ) ,
    FOREIGN KEY ( Username ) REFERENCES USER ( Username ) " ) ,
array ( "SONG" ,
    "SongID INTEGER AUTO_INCREMENT PRIMARY KEY, 
    Name VARCHAR ( 30 ) ,
    NumberPlays INTEGER , 
    Length INTEGER , 
    FilePath VARCHAR ( 500 ) " ) ,
array ( "CONTAINS" ,
    "PlaylistID INTEGER , 
    SongID INTEGER ,
    PRIMARY KEY ( PlaylistID , SongID ) ,
    FOREIGN KEY ( PlaylistID ) REFERENCES PLAYLIST ( PlaylistID ) ,
    FOREIGN KEY ( SongID ) REFERENCES SONG ( SongID ) " ) ,
array ( "ALBUM" ,
    "AlbumID INTEGER AUTO_INCREMENT PRIMARY KEY, 
    Name VARCHAR ( 30 ) ,
    CoverArt VARCHAR ( 500 ) ,
    ReleaseDate DATE " ) ,
array ( "BELONG_TO" ,
    "SongID INTEGER , 
    AlbumID INTEGER ,
    PRIMARY KEY ( SongID , AlbumID ) ,
    FOREIGN KEY ( SongID ) REFERENCES SONG ( SongID ) ,
    FOREIGN KEY ( AlbumID ) REFERENCES ALBUM ( AlbumID ) " ) ,
array ( "ALBUM2" ,
    "AlbumGenreID INTEGER AUTO_INCREMENT PRIMARY KEY ,
    AlbumID INTEGER ,
    Genre VARCHAR ( 30 ) ,
    FOREIGN KEY ( AlbumID ) REFERENCES ALBUM ( AlbumID ) " ) ,
array ( "ARTIST" ,
    "ArtistName VARCHAR ( 30 ) PRIMARY KEY ,
    Password VARCHAR ( 30 )" ) ,
array ( "OWNS" ,
    "AlbumID INTEGER ,
    ArtistName VARCHAR ( 30 ) ,
    PRIMARY KEY ( AlbumID , ArtistName ) ,
    FOREIGN KEY ( AlbumID ) REFERENCES ALBUM ( AlbumID ) ,
    FOREIGN KEY ( ArtistName ) REFERENCES ARTIST ( ArtistName ) " ) ,
array ( "SOLOIST" ,
    "ArtistName VARCHAR ( 30 ) PRIMARY KEY ,
    FOREIGN KEY ( ArtistName ) REFERENCES ARTIST ( ArtistName ) " ) ,
array ( "BAND" ,
    "ArtistName VARCHAR ( 30 ) PRIMARY KEY ,
    FOREIGN KEY ( ArtistName ) REFERENCES ARTIST ( ArtistName ) " ) ,
array ( "BAND2" ,
    "BandMemberID INTEGER AUTO_INCREMENT PRIMARY KEY ,
    ArtistName VARCHAR ( 30 ) ,
    MemberName VARCHAR ( 30 ) ,
    FOREIGN KEY ( ArtistName ) REFERENCES BAND ( ArtistName ) " )
) ;

Main ( ) ;

function Main ( )
{
    $ServerConnection = CreateConnectionToServer ( SERVER_NAME , USER_NAME , PASS_WORD ) ;
    if ( $ServerConnection == True )
    {
        DoSetup ( $ServerConnection ) ;
    }
    else
    {
        LogMessage ( SERVER_FAIL_TEXT ) ;
    }
}

function DoSetup ( $ServerConnection )
{
    $IsDatabaseSetup = SetupDB ( $ServerConnection , DATABASE_NAME ) ;
    CloseConnectionToServer ( $ServerConnection ) ;
    if ( $IsDatabaseSetup == True )
    {
        LogMessage ( DATABASE_SUCCESS_TEXT ) ;
        ConnectForTableCreation ( ) ;
    }
    else
    {
        LogMessage ( DATABASE_FAIL_TEXT ) ;
    }
}

function CreateTablesFromArray ( $Connection , $TablesArray )
{
    $NumberTables = count ( $TablesArray ) ;
    $TableIndexer = 0 ;
    while ( $TableIndexer < $NumberTables )
    {
        $CurrentTableArray = $TablesArray [ $TableIndexer ] ;
        $TableName = $CurrentTableArray [ TABLE_NAME_POSITION ] ;
        $ColumnsText = $CurrentTableArray [ COLUMNS_TEXT_POSITION ] ;
        CreateTable ( $Connection , $TableName , $ColumnsText ) ;
        $TableIndexer = $TableIndexer + 1 ;
    }
}

function SetupTables ( $Connection )
{
    CreateTablesFromArray ( $Connection , TABLES_ARRAY ) ;
}

function ConnectForTableCreation ( )
{
    $DatabaseConnection = CreateConnectionToDatabase (SERVER_NAME , USER_NAME , PASS_WORD , DATABASE_NAME ) ;
    if ( $DatabaseConnection == True )
    {
        SetupTables ( $DatabaseConnection ) ;
        CloseConnectionToDatabase ( $DatabaseConnection ) ;
    }
    else
    {
        LogMessage ( DATABASE_CONNECTION_FAIL_TEXT ) ;
    }
}

function LogMessage ( $Message )
{
    echo $Message . HTML_NEWLINE ;
}

function SetupDB ( $ServerConnection , $DatabaseName )
{
    $SQL = DATABASE_SETUP_SQL . $DatabaseName ;
    $Result = RunSQL ( $ServerConnection , $SQL ) ;
    return $Result ;
}

function GetTableVerificationSQL ( $TableName )
{
    $SQL = TABLE_VERIFY_SQL . $TableName . QUOTATION_MARK ;
    return $SQL ;
}

function CheckIfTableExists ( $conn , $TableName )
{
    $SQL = GetTableVerificationSQL ( $TableName ) ;
    $Result = RunSQL ( $conn , $SQL ) ;
    if($Result->num_rows == 1)
    {
        LogMessage ( TABLE_EXISTS_TEXT . $TableName ) ;
    }
    else
    {
        LogMessage ( TABLE_NOT_EXISTS_TEXT . $TableName ) ;
    }
}



function CreateTable ( $Connection , $Table , $ColumnsText )
{
    $SQL = CREATE_TABLE_SQL . $Table . LEFT_PAREN . $ColumnsText . RIGHT_PAREN ;
    $Result = RunSQL ( $Connection , $SQL ) ;
    
    if ( $Result == True )
    {
        LogMessage ( TABLE_CREATION_SUCCESS . $Table ) ;
        CheckIfTableExists ( $Connection , $Table ) ;
    }
    else
    {
        LogMessage ( TABLE_CREATION_FAILED . $Table ) ;
    }
}


function SetupUserTable ( $Connection )
{
    
    CreateTable ( $Connection , USER_TABLE_NAME , USER_COLUMNS_TEXT ) ;
    
}



?>


</body>
</html>
