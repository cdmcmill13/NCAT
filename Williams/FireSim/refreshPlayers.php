<?php
/* FireSim firewall educational simulation
 * Refresh players sends a JSON formatted list to the requester (player or
 * administrator) containing the names and scores of all the players.
 */
session_start();        // continue session
if (!isset($_SESSION['groupID'])) {
    die("You must have previously logged into FireSim");
}
$groupID = $_SESSION['groupID'];

/* Get the list of players from the players database table */
$sqlObj = new mysqli("localhost", "root", "cmptrsci1144", "FireSim");
if ($sqlObj->connect_error) {
    die("Datbase connection failed: " . $sqlObj->connect_error);
}
$queryStr = "select player, score from players where groupID = ? order by player";
if (!($sqlstmt = $sqlObj->prepare($queryStr))) {
    die("player select prepare failed: (" . $sqlObj->errno . ") " . $sqlObj->error);
}
if (!$sqlstmt->bind_param("s", $groupID)) {
    die("player select parameter bind failed (" . $sqlstmt->errno . ") " . $sqlstmt->error);       
}
if(!$sqlstmt->execute()) {
    die("player select Execute failed (" . $sqlstmt->errno . ") " . $sqlstmt->error);
}
$playerResult = $sqlstmt->get_result();
$tbl = '{"players": [';                         // build JSON array
$firstRow = true;
while($row = $playerResult->fetch_assoc()) {
    if ($firstRow) {
        $firstRow = false;
    } else {
        $tbl = $tbl . ',';                      // put comma between rows
    }
    $tbl = $tbl . '{ "name":"' . $row["player"] . '", "score":"' . $row["score"] . '" }';
}
$tbl = $tbl . ']}';
echo $tbl;                  // send JSON array to requestor