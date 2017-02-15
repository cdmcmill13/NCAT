<?php
/* FireSim firewall educational simulation
 * The retrieveMsg program sends the user all messages that have been sent to the
 * current player.  Messages are taken from the message database table and deleted
 * after they are sent to the player.
 */
session_start();        // continue session
if (!isset($_SESSION['groupID'])) {
    die("You must have previously logged into FireSim");
}
$groupID = $_SESSION['groupID'];        // this player's groupID
//$groupID   = "JUNK2";   //!!DEBUG
$player  = $_SESSION['player'];         // this player's name

/* Get the list of messages from the message database table */
$sqlObj = new mysqli("localhost", "root", "cmptrsci1144", "FireSim");
if ($sqlObj->connect_error) {
    die("Datbase connection failed: " . $sqlObj->connect_error);
}
$queryStr = "select text, type from message where player = ? and groupID = ?";
if (!($sqlstmt = $sqlObj->prepare($queryStr))) {
    die("message select prepare failed: (" . $sqlObj->errno . ") " . $sqlObj->error);
}
if (!$sqlstmt->bind_param("ss", $player, $groupID)) {
    die("message select parameter bind failed (" . $sqlstmt->errno . ") " . $sqlstmt->error);       
}
if(!$sqlstmt->execute()) {
    die("message select Execute failed (" . $sqlstmt->errno . ") " . $sqlstmt->error);
}
$playerResult = $sqlstmt->get_result();
if ($playerResult->num_rows == 0) {         // if no messages
    echo '{"msg": [{ "text":"<nothing>", "type":"0" } ]}' ; // tell player no messages
    $sqlstmt->close();
} else {
    $firstRow = true;
    $tbl = '{"msg": [';
    while($row = $playerResult->fetch_assoc()) {
        if ($firstRow) {
            $firstRow = false;
        } else {
            $tbl = $tbl . ',';                      // put comma between rows
        }
        if ($row["type"] == 8) {    // if new config message with multple fields
            $tbl = $tbl . '{ ' . $row["text"] . ', "type":"8" }';            
        } else {                // all other message types
            $tbl = $tbl . '{ "text":"' . $row["text"] . '", "type":"' . $row["type"] . '" }';
        }
    }
    $tbl = $tbl . ']}';
    echo $tbl;                  // send JSON array to requestor
    $sqlstmt->close();
    
    /* Delete the messages from the database*/
    $queryStr2 = "delete from message where player = ? and groupID = ?";
    if (!($sqlstmt2 = $sqlObj->prepare($queryStr2))) {
        die("message delete prepare failed: (" . $sqlObj->errno . ") " . $sqlObj->error);
    }
    if (!$sqlstmt2->bind_param("ss", $player, $groupID)) {
        die("message delete parameter bind failed (" . $sqlstmt2->errno . ") " . $sqlstmt2->error);       
    }
    if(!$sqlstmt2->execute()) {
        die("message delete Execute failed (" . $sqlstm2->errno . ") " . $sqlstmt2->error);
    }
    $sqlstmt2->close();
}
$sqlObj->close();