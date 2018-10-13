<?php

/* 
 * php delete function that deals with directories recursively
 */
function DeleteFiles($target) {
    if(is_dir($target)){
        $files = glob( $target . '*', GLOB_MARK ); //GLOB_MARK adds a slash to directories returned
	echo "fire" ;
	print_r( $files ) ;
        foreach( $files as $file )
        {
            DeleteFiles( $file );      
        }

        rmdir( $target );
    } elseif(is_file($target)) {
        unlink( $target );  
    }
}
?>