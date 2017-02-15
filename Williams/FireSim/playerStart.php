<?php
/* FireSim firewall educational simulation
 * The playerStart program receives a name and groupID from the playerLogin.html page that
 * is initially used by the participants to join the simulation game.
 * It checks that the groupID has been entered by and administrator and 
 * that the name is unique.  If all is good, the name is entered in the players
 * database table
 */
session_start();        // start session for administrator

/* get the groupID */
$player = trim($_GET['name']);
$groupID = strtoupper(trim($_GET['groupID']));  // convert groupID to uppercase for easy matching

if (strlen($groupID) > 16 || !cleanName($groupID)  
        || strlen($player) > 16 || !cleanName($player)) {    // check for invalid IDs
    Header('Location: badname.html');                // display error page
} else {
/* look in the games table to see if the groupID has been entered by admin */
    $sqlObj = new mysqli("localhost", "root", "cmptrsci1144", "FireSim");
    if ($sqlObj->connect_error) {
        die("Datbase connection failed: " . $sqlObj->connect_error);
    }
    $queryStr = "select * from games where groupID = ?";
    if (!($sqlstmt = $sqlObj->prepare($queryStr))) {
        echo "select prepare failed: (" . $sqlObj->errno . ") " . $sqlObj->error;
        exit("This should not happen");
    }
    if (!$sqlstmt->bind_param("s", $groupID)) {
        die("select parameter bind failed (" . $sqlstmt->errno . ") " . $sqlstmt->error);       
    }
    if(!$sqlstmt->execute()) {
        die("select Execute failed (" . $sqlstmt->errno . ") " . $sqlstmt->error);
    }
    $results = $sqlstmt->get_result();
    if ($results->num_rows == 0) {              // error if groupID not present
        $sqlstmt->close();        
        $sqlObj->close();
        header('Location: nogroupID.html');
    } else {
        $sqlstmt->close();
        /* Check if the player name is unique */
        $queryStr3 = "select * from players where player = ? and groupID = ?";
        if (!($sqlstmt3 = $sqlObj->prepare($queryStr3))) {
            die("player select prepare failed: (" . $sqlObj->errno . ") " . $sqlObj->error);
        }
        if (!$sqlstmt3->bind_param("ss", $player, $groupID)) {
            die("player select parameter bind failed (" . $sqlstmt3->errno . ") " . $sqlstmt3->error);       
        }
        if(!$sqlstmt3->execute()) {
            die("player select Execute failed (" . $sqlstmt3->errno . ") " . $sqlstmt3->error);
        }
        $playerResult = $sqlstmt3->get_result();
        if ($playerResult->num_rows != 0) {              // error if player name not unique
            $sqlstmt3->close();        
            $sqlObj->close();
            header('Location: usedname.html');
        } else {        
            /* Add the player to the players table */
            $queryStr2 = "insert into players (player, groupID, score) values (?, ?, ?)";
            if (!($sqlstmt2 = $sqlObj->prepare($queryStr2))) {
                die("player insert prepare failed: (" . $sqlObj->errno . ") " . $sqlObj->error);
            }
            $defaultScore = 100;
            if (!$sqlstmt2->bind_param("ssi", $player, $groupID, $defaultScore)) {
                die("player insert parameter bind failed (" . $sqlstmt2->errno . ") " . $sqlstmt2->error);       
            }
            if(!$sqlstmt2->execute()) {
                die("player insert Execute failed (" . $sqlstmt2->errno . ") " . $sqlstmt2->error);
            }
            $sqlstmt2->close();
            $sqlObj->close();

            /* Save the groupID and player name for use by all further admin PHP programs*/
            $_SESSION['groupID'] = $groupID;
            $_SESSION['player']  = $player;

            /* Direct the administrator to the admin home page */
            header('Location: playerhome.html');
        }
    }
}

/*
 * Function to check for any characters that should not be in a name or groupID.
 * Only upper and lower case letters, numbers and space
 * are allowed. The function returns true if the name is friendly and false otherwise.
 */
function cleanName($dangerous) {
    $c = str_split($dangerous);         // convert to array of characters
    for ($k = 0; $k < count($c); $k++) {
        $numValue = ord($c[$k]);
        if (    !($numValue >= 65 && $numValue <= 90) &&    // if not an uppercase letter
                !($numValue >= 97 && $numValue <= 122) &&   // if not a lowercase letter 
                !($numValue >= 48 && $numValue <= 57) &&    // if not a numerical digit
                $numValue != 32 ) {                         // if not a space
            echo "Evil character " . $c[$k];    //!!DEBUG
            return false;                                   // unclean, unclean
        }
    }
    return true;
}

