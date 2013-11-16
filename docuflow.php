<?php

include 'db_helper.php';

//getDBResultsArray($dbQuery,$dieOnError=True)
//getDBResultRecord($dbQuery,$dieOnError=True)
//getDBResultAffected($dbQuery,$dieOnError=True)
//getDBResultInserted($dbQuery,$id,$dieOnError=True)

function listforms(){
	$dbquery = "SELECT * FROM `Form`";
	// echo "tesT";
	$results = getDBResultsArray($dbquery);
	$output;
	foreach ($results as $result)
	{
		//echo "asasdf";
		$dbquery2 = "SELECT * FROM `Signature` WHERE `form_id` = '" . $result['id'] ."' ORDER BY `order`";
		//echo $dbquery2;
		$signatureresults = getDBResultsArray($dbquery2);
		//json_encode($signatureresults);
		$result['signatures'] = $signatureresults;
		//echo json_encode($result);
		$output[] = $result;
	}
	echo json_encode($output);
	
	
	
}

function getformdata($formid){
	$dbquery = "SELECT * FROM `Form` WHERE `id` = '".$formid."'";
	//echo $dbquery;
	$dbquery2 = "SELECT * FROM `Signature` WHERE `form_id` = '".$formid ."' ORDER BY `order`";
	
	$results = getDBResultsArray($dbquery);
	$results2 = getDBResultsArray($dbquery2);
	$results = $results[0];
	$results['signatures'] = $results2;
	echo json_encode($results);
}

function createform(){
	$title = $_POST['title'];
	$creator = $_POST['creator'];
	$duedate = $_POST['duedate'];
	$userlist = $_POST['userlist'];
	
	
	//INSERT INTO table_name (column1, column2, column3,...)
//VALUES (value1, value2, value3,...)
	
	$dbquery = "INSERT INTO `Form` (`title`, `creator`, `duedate`, `pdfpath`) VALUES ('".$title."','".$creator."','".$duedate."')";
	$formid = getDBResultInserted($dbQuery,$formid);
	
	$userlist = explode(',', $userlist);
	$order = 1;
	foreach ($userlist as $user){
		$userinsert = "INSERT INTO `Signatures` (`form_id`,`user_id`,`order`) VALUES('".$formid."','".$user."','".$order."')";
		$order = $order+1;
		$temp = getDBResultInserted($userinsert, $temp);
	}
	
	echo ("{'id',".$formid."}");
}

function updateform($formid){
	//echo "update form";
	
	//UPDATE [LOW_PRIORITY] [IGNORE] table_reference
//    SET col_name1={expr1|DEFAULT} [, col_name2={expr2|DEFAULT}] ...
//    [WHERE where_condition]
//    [ORDER BY ...]
//    [LIMIT row_count]
	$title = $_GET['title'];
	$creator = $_GET['creator'];
	$duedate = $_GET['duedate'];
	
	$dbquery = "UPDATE `Form` SET ";
	
}

function listsignatures($formid){
	$dbquery2 = "SELECT * FROM `Signature` WHERE `form_id` = '".$formid ."' ORDER BY `order`";
	$results2 = getDBResultsArray($dbquery2);
	
	echo json_encode($results2);
	
}

function getsignatures($formid, $userid){
	echo "gets a users signature status, probably useless";
}

function adduser($formid){
	echo "adding user to document";
}

function signdocument($formid, $userid){
	$dbquery = "UPDATE `Signature` SET `signed` = 1, `signed_date` = CURRENT_TIMESTAMP() WHERE `form_id` = '".$formid."' AND `user_id` = ".$userid;
	
	$res = getDBResultAffected($dbquery);
	
	$dbquery = "SELECT * FROM `Signature` WHERE `form_id` = '".$formid."' , `user_id` = '".$userid."'";
	
	$results = getDBResultAffected($dbqueryres);
	$order = $results['order']+1;
	
	$dbquery = "UPDATE `Signature` SET `received_date` = CURRENT_TIMESTAMP() WHERE `form_id` = '".$formid."' AND `order` = '".$order."'";
	$res = 
	
	//echo "user ". $userid . " signed the document";
	echo json_encode($res);
}

function sendreminder($formid, $userid){
	$dbquery = "UPDATE `Signature` SET `reminders`=`reminders`+1, `last_reminded` = CURRENT_TIMESTAMP() WHERE `form_id` = '".$formid."' AND `user_id` = ".$userid;
	
	$res = getDBResultAffected($dbquery);
	
}

function listusers(){
	//echo "test";
	$dbquery = "SELECT * FROM `User`";
	$results = getDBResultsArray($dbquery);
	//echo json_encode($results);
	$output;
	foreach ($results as $result)
	{
		//echo "asasdf";
		$dbquery2 = "SELECT * FROM `Signature` WHERE `user_id` = '" . $result['user_id'] ."'";
		//echo $dbquery2;
		$signatureresults = getDBResultsArray($dbquery2);
		//json_encode($signatureresults);
		$result['signatures'] = $signatureresults;
		//echo json_encode($result);
		$output[] = $result;
	}
	echo json_encode($output);
	
}

function getuserinfo($userid){
	$dbquery = "SELECT * FROM `User` WHERE `user_id` = '" . $userid ."'";
	$dbquery2 = "SELECT * FROM `Signature` WHERE `user_id` = '" . $userid ."'";
	//echo $dbquery;
	$result = getDBResultsArray($dbquery);
	$result2 = getDBResultsArray($dbquery2);
	$result['signatures'] = $result2;
	
	echo json_encode($result);
}

function createuser(){
	$user = $_POST['user'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	
	$dbquery=  "INSERT INTO `User` (`user_id`, `email`, `phone`) VALUES (".$user.",".$email.",".$phone.")";
	$res = getDBResultInserted($dbquery,$id);
	echo "{'user_id': ". $user ."}";
}

function updateuser($userid){
	echo "updating the entry for " . $userid;
}

function listusersignatures($userid){
	$dbquery2 = "SELECT * FROM `Signature` WHERE `user_id` = '" . $userid ."'";
	$signatureresults = getDBResultsArray($dbquery2);
	echo json_encode($signatureresults);
}
?>