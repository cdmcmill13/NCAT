<?php
/* FireSim firewall educational simulation
 * The checkConfig program receives the player's firewall configuration and
 * "compiles" it into Access Control Entities (ACE).  If all lines of the
 * configuration are correct, the ACE objects are written to the config table
 * in the database.
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

// get the conftext parameter from URL
$ctext  = cleanConfig($_POST["conftext"]);

$conList = explode("\n", $ctext);   // split lines into individual lines in array
$numLine = count($conList);         // number of lines in the input

$aceList = array();      // list of flattened ACE objects created from config lines
$numAce  = 0;

for ($lineNum = 0; $lineNum < $numLine; $lineNum++) {
    try {
        // avoid blank lines and comments
        if (strlen($conList[$lineNum]) > 1 && (strcmp("*", substr($conList[$lineNum], 0, 1)) != 0)) {
            $result = ACE::parse( $conList[$lineNum]);
            $aceList[$numAce] = $result->serialize();       // save the generated ACE
            $numAce++;
        }
    } catch (Exception $ex) {
        // create configuration error message
        $errMsg = '{"msg": [{"text":"Syntax error: ' . $ex->getMessage() .
                ' on line ' . ($lineNum+1) . ' at approximately column ' . 
                $ex->getCode() . '", "type":"7"}]}';
        echo $errMsg;
        exit();     // all done,quit
    }
}

/* Write the ACE objects to the database */
$sqlObj = new mysqli("localhost", "root", "cmptrsci1144", "FireSim");
if ($sqlObj->connect_error) {
    die("Datbase connection failed: " . $sqlObj->connect_error);
}
// delete all previous configuration records for this user
$delConfQ = "delete from config where groupID = ? and player = ?";
if (!($sqldel = $sqlObj->prepare($delConfQ))) {
    exit("delete prepare failed: (" . $sqlObj->errno . ") " . $sqlObj->error);
}
if (!$sqldel->bind_param("ss", $groupID, $player)) {
    die("delete parameter bind failed (" . $sqldel->errno . ") " . $sqldel->error);       
}
if(!$sqldel->execute()) {
    die("delete execute failed (" . $sqldel->errno . ") " . $sqldel->error);
}
$sqldel->close();

// Add the new ACE to the database
$queryStr = "insert into config (groupID, player, seq, ace) values (?, ?, ?, ?)";
if (!($sqlstmt = $sqlObj->prepare($queryStr))) {
    exit("insert prepare failed: (" . $sqlObj->errno . ") " . $sqlObj->error);
}

for ($seqNum = 0; $seqNum < $numAce; $seqNum++) {
    if (!$sqlstmt->bind_param("ssis", $groupID, $player, $seqNum, $aceList[$seqNum])) {
        die("insert parameter bind failed (" . $sqlstmt->errno . ") " . $sqlstmt->error);       
    }
    if(!$sqlstmt->execute()) {
        die("insert Execute failed (" . $sqlstmt->errno . ") " . $sqlstmt->error);
    }
}
$sqlstmt->close();
$sqlObj->close();
// tell player configurations has been successfully updated
echo '{"msg": [{"text":"Firewall Configuration Updated", "type":"6"}]}';


/*
 * Function to remove any characters that should not be in a firewall configuration.
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
            echo "Evil character " . $c[$k];    //!!DEBUG
            $safe = substr_replace($safe, " ", $k, 1);      // replace character with space
        }
    }
    return $safe;
}
?>