<?php
$user = ''; //Screen name/username of the twitter user in question

require_once 'lib/twitteroauth.php';
 
define('CONSUMER_KEY', '');
define('CONSUMER_SECRET', '');
define('ACCESS_TOKEN', '');
define('ACCESS_TOKEN_SECRET', '');

$toa = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);

//Create/Open file
$file = fopen('followers/' . $user . '_followers.txt', 'a');
$cursor = -1; //Initialize

$sleep_counter = 1; //skip one to be used to get no of user's followers

$loop_counter = 0; //Total loops in the while block

//get the number of a users followers
$user_details = $toa->get('users/show', array('screen_name'=>$user));
$user_data = json_decode($user_details);
/*
echo '<pre>';
	print_r($user_data);
	echo '</pre>';
	exit;
*/

while($cursor != 0){	
	//Get followers
	$followers = $toa->get('followers/ids', array('cursor' => $cursor, 'screen_name'=>$user));
	//$friends = $toa->get('friends/ids', array('cursor' => -1));

	//Convert JSON returned to array
	$data = json_decode($followers);
	
	/*
	echo '<pre>';
	print_r($data);
	echo '</pre>';
	*/
	
	//write to file
	foreach($data->ids as $id){
		fwrite($file, $id . "\n");
	}
	
	//Get next cursor pointer
	$cursor = $data->next_cursor_str;
	//echo $cursor;
	
	//User feedback
	echo 'Finished saving followers... ' . $cursor . '<br>';
	
	//Sleep counter
	if($sleep_counter >= 14){
		sleep(16*60); //Pause execution for 16mins
		$sleep_counter = 0; //Reset counter
	}else{
		$sleep_counter++;
	}
	
	//loop counter
	$loop_counter++;
}
fclose($file);

//echo output
$followers = $user_data->followers_count;
$loop_multiplier = $loop_counter * 5000;

//How many were really stored
if($loop_multiplier > $followers){
	$dumped = $followers;
}else{
	$dumped = $loop_multiplier;
}
echo '<br><strong>' . $dumped 
	. '</strong> of <strong>' . $followers 
	. '</strong> followers of <strong>' . $user . '</strong> (' 
	. $user_data->name . ') have been downloaded and saved to file at ' 
	. date('jS M, Y - g:i:s A');
#echo '<br>All the followers of <strong>' . $user . '</strong> have been downloaded and saved to file at ' . date('jS M, Y - g:i:s A');


