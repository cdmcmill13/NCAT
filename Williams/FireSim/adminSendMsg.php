<?php
/* FireSim firewall educational simulation
 * adminSendMsg is called when the administrator wants to send a message to one
 * or all of the players. The message will be sent to all of the players if the 
 * recipient is "broadcast!"
 */
session_start();        // continue session
if (!isset($_SESSION['groupID'])) {
    die("You must have previously logged into FireSim");
}
$groupID   = $_SESSION['groupID'];      // group ID from session
$recipient = $_POST["recipient"];       // player to receive message
$msgText   = $_POST["text"];            // text of the message to send
$msgType   = $_POST["type"];            // Type of the message
if ($msgType == 1 || $msgType == 9 || $msgType == 10) {
    $msgText = cleanConfig($msgText);   // Clean only if human entered text
}

error_log("adminSendMsg-" . $msgText . " msgType:" . $msgType); //!! DEBUG

/* Get the list of players from the players database table */
$sqlObj = new mysqli("localhost", "root", "cmptrsci1144", "FireSim");
if ($sqlObj->connect_error) {
    die("Datbase connection failed: " . $sqlObj->connect_error);
}

if ($recipient == "broadcast!") {      // if a broadcast message
    $queryStr = "select player from players where groupID = ?";
    if (!($sqlstmt = $sqlObj->prepare($queryStr))) {
        die("message select prepare failed: (" . $sqlObj->errno . ") " . $sqlObj->error);
    }
    if (!$sqlstmt->bind_param("s", $groupID)) {
        die("message select parameter bind failed (" . $sqlstmt->errno . ") " . $sqlstmt->error);       
    }
    if(!$sqlstmt->execute()) {
        die("message select Execute failed (" . $sqlstmt->errno . ") " . $sqlstmt->error);
    }
    $playerResult = $sqlstmt->get_result();
    $broadQuery = "insert into message (groupID, player, text, type) values (?, ?, ?, ?)";
    if (!($broadSqlStmt = $sqlObj->prepare($broadQuery))) {
        die("message insert prepare failed: (" . $sqlObj->errno . ") " . $sqlObj->error);
    }
    while($row = $playerResult->fetch_assoc()) {            // for all players
        if (!$broadSqlStmt->bind_param("sssi", $groupID, $row["player"], $msgText, $msgType)) {
            die("message insert parameter bind failed (" . $broadSqlStmt->errno . ") " . $broadSqlStmt->error);       
        }
        if(!$broadSqlStmt->execute()) {
            die("message insert Execute failed (" . $broadSqlStmt->errno . ") " . $broadSqlStmt->error);
        }  
    }
    $broadSqlStmt->close();
    $sqlstmt->close();
    
} else {        // message to a single player
    sendmsg( $recipient, $msgText, $msgType );
}
$sqlObj->close();   // close the SQL access at the end
echo 'OK';          // send happy response back to the administrator
/*
 * Function to remove any characters that should not be in a message.
 * Only upper and lower case letters, numbers, space, period, dash, * and new line
 * are allowed. All other characters are changed to space.
 */
function cleanConfig($dangerous) {
    $safe = $dangerous;                 // assume no problems
    $c = str_split($dangerous);         // convert to array of characters
    for ($k = 0; $k < count($c); $k++) {
        $numValue = ord($c[$k]);
        if (    !($numValue >= 65 && $numValue <= 90) &&    // if not an uppercase letter
                !($numValue >= 97 && $numValue <= 122) &&   // if not a lowercase letter 
                !($numValue >= 48 && $numValue <= 57) &&    // if not a numerical digit
                $numValue != 32 &&                          // if not a space
                $numValue != 46 &&                          // if not a period
                $numValue != 45 &&                          // if not a dash -
                $numValue != 42 &&                          // if not an astrick *
                (strcmp($c[$k], "\n") != 0)) {              // if not a new line
            $safe = substr_replace($safe, " ", $k, 1);      // replace character with space
        }
    }
    return $safe;
}

/* FireSim firewall educational simulation
 * The sendmsg function sends a message to a specified player.  This is done by
 * putting the message in the message database table.  When the player later
 * requests messages, the message will be downloaded to the player and removed
 * from the database.
 * This function assume that the FireSim database has already been opened and
 * the variable $sqlObj references the database object.
 * $who is the name of the individual player to receive the message.
 * $what is the text of the message.
 * $whatkind is the type of the message
 *   1 = message to be displayed on the player's screen
 *   2 = player has been successfully attacked
 *   3 = player has defended against an attack
 *   4 = player's attack was successful
 *   5 = player's attach was unsuccessful
 *   6 = configuration was correctly updated
 *   7 = configuration error
 *   8 = new firewall requirement
 *   9 = start of the simulation
 *   10 = end of the simulation
 */
function sendmsg($who, $what, $whatkind) {
    global $sqlObj, $groupID;
    $msgQuery = "insert into message (groupID, player, text, type) values (?, ?, ?, ?)";
    if (!($msgSqlStmt = $sqlObj->prepare($msgQuery))) {
        die("message insert prepare failed: (" . $sqlObj->errno . ") " . $sqlObj->error);
    }
    if (!$msgSqlStmt->bind_param("sssi", $groupID, $who, $what, $whatkind)) {
        die("message insert parameter bind failed (" . $msgSqlStmt->errno . ") " . $msgSqlStmt->error);       
    }
    if(!$msgSqlStmt->execute()) {
        die("message insert Execute failed (" . $msgSqlStmt->errno . ") " . $msgSqlStmt->error);
    }
    $msgSqlStmt->close();
}