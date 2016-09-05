<?php

	// Lets fetch the value of last_displayed_chat_id
	$data = $_REQUEST;
	$last_displayed_chat_id = $data['last_displayed_chat_id'];
	
	// Connect to MySQL Server
	$con = mysqli_connect( "localhost" , "root" , "" , "group_chat" );
	
	// If user_name and user_comment is available then
	// add it in table chats
	if(
		isset( $data['user_name'] ) &&
		isset( $data['user_comment'] )
	) {
		
		$insert = " 
			INSERT INTO chats( user_name , user_comment ) 
			VALUES( '".$data['user_name']."' , '".$data['user_comment']."' )
		";
		$insert_result = mysqli_query( $con , $insert );
	}
	
	$select = "SELECT * 
				FROM chats
				WHERE chat_id > '".$last_displayed_chat_id."'
			";
	$result = mysqli_query( $con , $select );
	
	$arr = array();
	$row_count = mysqli_num_rows( $result );
	
	if( $row_count > 0 ) {
		while( $row = mysqli_fetch_array( $result ) ) {
			array_push( $arr , $row );
		}
	}
	
	// Close the MySQL Connection
	mysqli_close( $con );
	
	// Return the response as JSON
	echo json_encode( $arr );

?>