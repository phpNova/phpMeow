<?php

class phpmeow_block
{
	/*
	 * Array keys must correspond to the following layout:
	 * 
	 * 01
	 * 23
	 * 
	 * --Kris
	 */
	function merge_animals( $ims = array() )
	{
		require_once( "animal.phpmeow.class.php" );
		
		if ( count( $ims ) != 4 )
		{
			return FALSE;
		}
		
		$img_width = imagesx( $ims[0] ) + imagesx( $ims[1] );
		$img_height = imagesy( $ims[0] ) + imagesy( $ims[2] );
		
		if ( $img_width == 0 || $img_height == 0 )
		{
			return FALSE;
		}
		
		$blockim = imagecreatetruecolor( $img_width, $img_height );
		
		/* This approach allows us to completely hide the animal image paths from the client.  --Kris */
		imagecopy( $blockim, $ims[0], 0, 0, 0, 0, imagesx( $ims[0] ), imagesy( $ims[0] ) );
		imagecopy( $blockim, $ims[1], imagesx( $ims[0] ), 0, 0, 0, imagesx( $ims[1] ), imagesy( $ims[1] ) );
		imagecopy( $blockim, $ims[2], 0, imagesy( $ims[0] ), 0, 0, imagesx( $ims[2] ), imagesy( $ims[2] ) );
		imagecopy( $blockim, $ims[3], imagesx( $ims[0] ), imagesy( $ims[0] ), 0, 0, imagesx( $ims[3] ), imagesy( $ims[3] ) );
		
		return $blockim;
	}
	
	/* Saves to disk for swapping purposes.  --Kris */
	function save( $blockim, $filename )
	{
		return imagejpeg( $blockim, $filename );
	}
	
	/* Clean-up the temporary image file.  --Kris */
	function destroy( $filekey )
	{
		$filename = $_SESSION[$filekey];
		
		$ok = unlink( $filename );
		
		unset( $_SESSION[$filekey] );
		
		return $ok;
	}
}