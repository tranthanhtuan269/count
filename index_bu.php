<?php	
	$arr = [0,1,2,3,4,5,6,7,8,9,A,B,C,D,E,F,G,H,I,J,K,L,M,L,O,P,Q,R,S,T,U,V,W,X,Y,Z];

	$temp = rand ( 0 , 2176782335 );

	$v1 = $temp % 36;
	$v2 = floor($temp / 36) % 36;
	$v3 = floor(floor($temp / 36) / 36) % 36;
	$v4 = floor(floor(floor($temp / 36) / 36) / 36) % 36;
	$v5 = floor(floor(floor(floor($temp / 36) / 36) / 36) / 36) % 36;
	$v6 = floor(floor(floor(floor(floor($temp / 36) / 36) / 36) / 36) / 36) % 36;
	
	$ret =  $arr[$v1].$arr[$v2] . ' - ' . $arr[$v3].$arr[$v4] . ' - ' . $arr[$v5].$arr[$v6];

	$response = array(
        'code' => 200,
        'message' => "success",
        'data' => $ret
    );

    echo json_encode($response);