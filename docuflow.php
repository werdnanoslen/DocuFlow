<?php

function listforms(){
	echo "listforms";
}

function getformdata($formid){
	echo "getformdata" . $formid;
}

function createform(){
	echo "creating form";
}

function updateform($formid){
	echo "update form";
}

function listsignatures($formid){
	echo "listing signatures";
}

function getsignatures($formid, $userid){
	echo "gets a users signature status, probably useless";
}

function adduser($formid){
	echo "adding user to document";
}

function signdocument($formid, $userid){
	echo "user ". $userid . " signed the document";
}

function sendreminder($formid, $userid){
	echo "reminding " . $userid . " about form :" . $formid;
}

function listusers(){
	echo "listing users";
}

function getuserinfo($userid){
	echo "returns the information about the users";
}

function createuser(){
	echo "creates a user, updates db";
}

function updateuser($userid){
	echo "updating the entry for " . $userid;
}

function listusersignatures($userid){
	echo "listing the signatures for $userid";
}
?>