<?php
 	require_once 'db_connect.php';
 	
 	define('MIN_TIME_REQUEST',   15); 

 	$error = false;

 	$arr = [0,1,2,3,4,5,6,7,8,9,A,B,C,D,E,F,G,H,I,J,K,L,M,L,O,P,Q,R,S,T,U,V,W,X,Y,Z];

	$temp = rand ( 0 , 2176782335 );

	$v1 = $temp % 36;
	$v2 = floor($temp / 36) % 36;
	$v3 = floor(floor($temp / 36) / 36) % 36;
	$v4 = floor(floor(floor($temp / 36) / 36) / 36) % 36;
	$v5 = floor(floor(floor(floor($temp / 36) / 36) / 36) / 36) % 36;
	$v6 = floor(floor(floor(floor(floor($temp / 36) / 36) / 36) / 36) / 36) % 36;
	
	$ret = $arr[$v1].$arr[$v2] . ' - ' . $arr[$v3].$arr[$v4] . ' - ' . $arr[$v5].$arr[$v6];

 	if ( isset($_POST['id']) ) {
  	
  		// clean user inputs to prevent sql injections
  		$id = trim($_POST['id']);
  		$id = strip_tags($id);
  		$id = htmlspecialchars($id);
  	
  		//basic id validation
	  	if ( $id == "" ) {
	  	  	$error = true;
	  	  	$emailError = "Invalid UserId.";
	  	} else {
	  	  	// check id exist or not
	  	  	$query = "SELECT id FROM user_tbl WHERE id='$id'";
	  	  	$result = mysql_query($query);
	  	  	$count = mysql_num_rows($result);
	  	  	if($count!=0){
	  	  	 	$error = false;
	  	  	}
	  	}


	  	if( !$error ) {
	  	  	$user_id = $id;

	  	  	// check get code time later
	  	  	$queryTimeGetCodeLate = mysql_query("SELECT created_date FROM code_tbl WHERE user_id=". $id . " AND DATE(created_date)=CURDATE() ORDER BY created_date DESC LIMIT 1");

	  	  	$timeGetCodeLate=mysql_fetch_array($queryTimeGetCodeLate);
	  	  	$date1 = date($timeGetCodeLate['0']);
	  	  	$date2 = date("Y-m-d H:i:s");
	  	  	$interval = abs(strtotime($date2) - strtotime($date1));

	  	  	if($interval > (60 * MIN_TIME_REQUEST)){
	  	  		// add get code record
		  	  	$last_get = date("Y-m-d H:i:s");
		  	  	$created_date = date("Y-m-d H:i:s");

		  	 	$query = "INSERT INTO code_tbl(code,user_id,last_get,created_date) VALUES('$ret','$id','$last_get','$created_date')";
		  	 	
		  	 	$res = mysql_query($query);
		  	 	
		  	 	if ($res) {
		  	 	  	$response = array(
					  	  	 	'code' => 200,
					  	  	 	'code_res' => 1,
					  	  	 	'message' => "success",
					  	  	 	'data' => $ret
					);

					echo json_encode($response);
		  	 	} else {
		  	 	  	$response = array(
					  	  	 	'code' => 200,
					  	  	 	'code_res' => 0,
					  	  	 	'message' => "unsuccess",
					  	  	 	'data' => ""
					);

					echo json_encode($response);
		  	 	} 
	  	  	}else{
	  	  		$response = array(
					  	  	 	'code' => 200,
					  	  	 	'code_res' => -1,
					  	  	 	'message' => "success",
					  	  	 	'data' => ""
					);

					echo json_encode($response);
			}
	  	}
	}

	