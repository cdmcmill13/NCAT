<?php
/* FireSim firewall educational simulation
 * The adminStart program receives a groupID from the adminLogin.html page that
 * is initially used by the group administrator to start a new simulation game.
 * It checks that the groupID is unique and, if it is, saves the groupID in the 
 * games table
 */
session_start();        // start session for administrator

/* get the groupID */
$groupID = strtoupper(trim($_GET['groupID']));  // convert to upper case to avoid case issues

if (strlen($groupID) > 16 || !cleanName($groupID)) {    // check for invalid IDs
    Header('Location: badgroupID.html');                // display error page
} else {
/* look in the games table to see if the groupID is unique */
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
    if ($results->num_rows > 0) {              // error if groupID used before
        $sqlObj->close();
        header('Location: usedgroupID.html');
    } else {
        $sqlstmt->close();        
        /* Add the groupID to the games table */
        $queryStr2 = "insert into games (groupID) values (?)";
        if (!($sqlstmt2 = $sqlObj->prepare($queryStr2))) {
            exit("insert prepare failed: (" . $sqlObj->errno . ") " . $sqlObj->error);
        }
        if (!$sqlstmt2->bind_param("s", $groupID)) {
            die("insert parameter bind failed (" . $sqlstmt2->errno . ") " . $sqlstmt2->error);       
        }
        if(!$sqlstmt2->execute()) {
            die("insert Execute failed (" . $sqlstmt2->errno . ") " . $sqlstmt2->error);
        }
        $sqlstmt2->close();
        $sqlObj->close();
        
        /* Save the groupID for use by all further admin PHP programs*/
        $_SESSION['groupID'] = $groupID;
    
        /* Direct the administrator to the admin home page */
        header('Location: adminhome.html');
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

