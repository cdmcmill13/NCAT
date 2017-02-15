<?php
/* FireSim firewall educational simulation
 * This program is called when a player wants to take an action against another
 * player.
 */
session_start();        // continue session
if (!isset($_SESSION['groupID'])) {
    die("You must have previously logged into FireSim");
}
$groupID = $_SESSION['groupID'];        // this player's groupID
$player  = $_SESSION['player'];         // this player's name

require 'ACE.php';
require 'Action.php';
require 'defActionList.php';

// get the victem and the type of action from URL
$victim  = $_POST["victim"];
$weapon  = $_POST["weapon"];
if (!isset($actionList[$weapon])) {
    echo "Unknown action " . $weapon;       //!! should be logged
}
$actionTaken = $actionList[$weapon];

// get the victem's firewall configuration
$sqlObj = new mysqli("localhost", "root", "cmptrsci1144", "FireSim");
if ($sqlObj->connect_error) {
    die("Datbase connection failed: " . $sqlObj->connect_error);
}
$queryStr = "select ace from config where groupID = ? and player = ? order by seq";
if (!($sqlstmt = $sqlObj->prepare($queryStr))) {
    die("select prepare failed: (" . $sqlObj->errno . ") " . $sqlObj->error);
}
if (!$sqlstmt->bind_param("ss", $groupID, $victim)) {
    die("select parameter bind failed (" . $sqlstmt->errno . ") " . $sqlstmt->error);       
}
if(!$sqlstmt->execute()) {
    die("select Execute failed (" . $sqlstmt->errno . ") " . $sqlstmt->error);
}

$victimEmpty = 0;               // count of victim ACE
$victimResult = $sqlstmt->get_result();
while($row = $victimResult->fetch_assoc()) {
    $victimEmpty++;
    /* Compare the victim's firewall configuration against the attack. */
    $victimAce = new ACE();
//    echo "Victim ACE:" . $row['ace'] . "<br>";
    $victimAce->initialize($row['ace']);  // init ACE to config from database
    $what2do = $victimAce->tranCheck($actionTaken->sourceIP, $actionTaken->destIP, 
            $actionTaken->protocol, $actionTaken->port);
    if ($what2do !== 0) {               // if this ACE applies to the action
        if ($what2do === 1) {           // if this ACE permits this transmission
            $itWorked = $actionTaken->scoreif;
            $howCome = "ACE " . $victimEmpty . " " . $what2do+ " ACE" . $victimAce->serialize();  //!! DEBUG
        } else if ($what2do === 2) {    // if this ACE prohibits or denies this transmission
            $itWorked = !($actionTaken->scoreif);
            $howCome = "ACE " . $victimEmpty . " " . $what2do+ " ACE" . $victimAce->serialize();  //!! DEBUG
        }
        $sqlstmt->close();
        displayResults($itWorked);      // tell both players attack results 
	$sqlObj->close();
        exit();
    }
}
$sqlstmt->close();
if ($victimEmpty === 0) {       // default loss if victim has no configuration
    $howCome = "no config";     //!! DEBUG
    displayResults(true);       // tell both players attack was successful
} else {
    /* Check against default values if none of the ACE applied.
	   The default for outgoing messages is to allow them and the default for
	   incoming transmissions is to deny them.  This can be defined as:
	   access-list 198 permit 152.8.0.0 0.0.255.255	any // allows all outbound msg
	   access-list 199 deny any any   		    // deny all inbound msg
	   */
	$defaultOut  = new ACE();
	$defaultOut->initialize("198#permit#0#0x9808#0000#0#0xffff#0#0#0xffff#0xffff#0#-1#-1");
	$what2do = $defaultOut->tranCheck($actionTaken->sourceIP, $actionTaken->destIP, 
            $actionTaken->protocol, $actionTaken->port);
	if ($what2do !== 0) {               // if this ACE applies to the action
            if ($what2do === 1) {           // if this ACE permits this transmission
                $itWorked = $actionTaken->scoreif;
                $howCome = "default out " . $what2do;  //!! DEBUG
            } else if ($what2do === 2) {    // if this ACE prohibits or denies this transmission
                $itWorked = !($actionTaken->scoreif);
                $howCome = "default out " . $what2do;  //!! DEBUG
            }
	} else {	// default input denies transmission
            $itWorked = !($actionTaken->scoreif);
            $howCome = "default in " . $defaultOut->serialize();                 //!! DEBUG
	}
	displayResults($itWorked);      // tell both players attack results 

}
$sqlObj->close();

/* displayResults puts a message for the victem in the database and echos a message
 * to the attacker.
 * @param $success Is true if the attack was successful.
 * The victim's message type is:
 *  2 = player has been successfully attacked
 *  3 = player has defended against an attack
 *  4 = player's attack was successful
 *  5 = player's attach was unsuccessful
 */
function displayResults($success) {
    global $sqlObj, $groupID, $victim, $actionTaken, $player;
    global $howCome;                                            //!! DEBUG
    if ($success) {             // if attack was successful
        $vmsg =str_replace("#a", $player, $actionTaken->vSad);
        $amsg =str_replace("#v", $victim, $actionTaken->aHappy);
        $vmsgtype = 2;
        $amsgtype = 4;
        // Update the scores of the two players
        // Get the scores for the players
        $getQuery = "select score from players where groupID = ? and player = ?";
        if (!($getSqlStmt = $sqlObj->prepare($getQuery))) {
            die("select players score prepare failed: (" . $sqlObj->errno . ") " . $sqlObj->error);
        }
        if (!($getSqlStmt->bind_param("ss", $groupID, $player))) {
            die("player score parameter bind failed (" . $getSqlStmt->errno . ") " . $getSqlStmt->error);       
        }
        if (!($getSqlStmt->execute())) {
            die("player score execute select failed (" . $getSqlStmt->errno . ") " . $getSqlStmt->error);       
        }
        $scoreGot = $getSqlStmt->get_result();
        $row = $scoreGot->fetch_assoc();
        $playerScore = $row["score"] + 1;   // increment players score
        if (!($getSqlStmt->bind_param("ss", $groupID, $victim))) {
            die("victim score parameter bind failed (" . $getSqlStmt->errno . ") " . $getSqlStmt->error);       
        }
        if (!($getSqlStmt->execute())) {
            die("victim score execute select failed (" . $getSqlStmt->errno . ") " . $getSqlStmt->error);       
        }
        $scoreGot = $getSqlStmt->get_result();
        $row = $scoreGot->fetch_assoc();
        $victimScore = $row["score"] - 1;   // decrement victim's score
        $getSqlStmt->close();
        // Update the scores in the database
        $updateSQL = "update players set score = ? where groupID = ? and player = ?";
        if (!($updateStmt = $sqlObj->prepare($updateSQL))) {
            die("update players score prepare failed: (" . $sqlObj->errno . ") " . $sqlObj->error);            
        }
        if (!($updateStmt->bind_param("iss", $playerScore, $groupID, $player))) {
            die("update player score parameter bind failed (" . $updateStmt->errno . ") " . $updateStmt->error);       
        }
        if (!($updateStmt->execute())) {
            die("update player score execute select failed (" . $updateStmt->errno . ") " . $updateStmt->error);       
        }
        if (!($updateStmt->bind_param("iss", $victimScore, $groupID, $victim))) {
            die("update victim score parameter bind failed (" . $updateStmt->errno . ") " . $updateStmt->error);       
        }
        if (!($updateStmt->execute())) {
            die("update victim score execute select failed (" . $updateStmt->errno . ") " . $updateStmt->error);       
        }
        $updateStmt->close();
        
    } else {        // attack was unsuccessful, no change in schore
        $vmsg =str_replace("#a", $player, $actionTaken->vHappy);
        $amsg =str_replace("#v", $victim, $actionTaken->aSad);
        $vmsgtype = 3;
        $amsgtype = 5;
    }
    // Put the victim's message in the message database
    $msgQuery = "insert into message (groupID, player, text, type) values (?, ?, ?, ?)";
    if (!($msgSqlStmt = $sqlObj->prepare($msgQuery))) {
        die("message insert prepare failed: (" . $sqlObj->errno . ") " . $sqlObj->error);
    }
    if (!$msgSqlStmt->bind_param("sssi", $groupID, $victim, $vmsg, $vmsgtype)) {
        die("message insert parameter bind failed (" . $msgSqlStmt->errno . ") " . $msgSqlStmt->error);       
    }
    if(!$msgSqlStmt->execute()) {
        die("message insert Execute failed (" . $msgSqlStmt->errno . ") " . $msgSqlStmt->error);
    }
    $msgSqlStmt->close();
    $ajson = '{"msg": [{ "text":"' . $amsg . $howCome . '", "type":"' . $amsgtype . '" } ]}' ;
    echo $ajson;      					// Send JSON message to client
}