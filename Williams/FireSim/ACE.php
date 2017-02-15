<?php
/**
 * The ACE class instantiates an Access Control Entity, a single line
 * of an access control list.
 * @author Ken Williams Greg Simpson at North Carolina A&T State University May 21, 2008 October 1, 2015
 */

/**
 * When an error is detected parsing a line of firewall configuration, the parse
 * method throws a ParseException.
 */
class ParseException extends Exception {}

/**
 * An Access Control Entity (ACE) represents a single line of a firewall configuration.
 * An ACE object is created by the parse method.
 */
class ACE {
    /*
     * The simulated networks have class B IPv4 addresses with the first two bytes
     * equal to 152.8. If the source IP address has this value as the first 16 bits
     * of the address, then it is an outgoing transmission
     */
    public $LOCALNETID = 0x9808;
    /**
     * permitDeny is true if this ACE can permit a transmission. It is false if this 
     * ACE can deny a transmission
     */
    private $permitDeny =  false;
    // The sequence number of the ACE.
    private $seqNumber = -1;
    // The values for the protocol are as follows
    private $PROTIP = 0;
    private $PROTTCP = 1;
    private $PROTUDP = 2;
    private $PROTICMP = 3;
    private $PROTSNMP = 4;
    // The protocol that this ACE pertains to.
    //$protocol = $PROTIP; // default is IP protocol
    public $protocol = 0;
    private $PROTNAME = array('ip', 'tcp', 'udp', 'icmp', 'snmp');
    // The IP address of the source of this transmission
    public $sourceAddr = -1;
    /**
     * The reverse mask for the source IP address. A given address matches the
     * source address if (given & !sourceMask) == (sourceAddr & !sourceMask).
     */
    private $sourceMask = -1;
    // The IP address of the destination of this transmission.
    public $destAddr = -1;
    /*
     * The reverse mask for the destination IP address. A given address matches the
     * destination address if (given & !sourceMask) == (destAddr & !sourceMask).
     */
    private $destMask = -1;
    // The values for the portType are as follows
    private $PTNONE = 0;
    private $PTEQ = 1;
    private $PTNEQ = 2;
    private $PTLT = 3;
    private $PTGT = 4;
    private $PTRANGE = 5;
    private $PTEST = 6;
    // The means by which ports should be compared.
    private $portType = 0; //; = $PTNONE;
    /*
     * The port number this ACE pertains. The exact use of this field
     * depends on the portType. -1 means not assigned.
     */
    public $port = -1;
    // The second port number used for range port types.
    private $port2 = -1;

    /**
     * Returns a string containing the object's variables as a string with each
     * variable separated by a "#"
     * The result of this method can be used to create a new object with the same
     * values using the constructor.
     * The string can be easily written and read to a database without corruption.
     */
    public function serialize() {
        // To avoid problems with 32 bit positive numbers, possibly large values
        // are split into halves.
        $upSA  = (($this->sourceAddr) >> 16) & 0xFFFF;  // upper half of source address
        $lowSA = ($this->sourceAddr) & 0xFFFF;          // lower half of source address
        $upSM  = (($this->sourceMask) >> 16) & 0xFFFF;  // upper half of source Mask
        $lowSM = ($this->sourceMask) & 0xFFFF;          // lower half of source mask
        $upDA  = (($this->destAddr) >> 16) & 0xFFFF;    // upper half of destination address
        $lowDA = ($this->destAddr) & 0xFFFF;            // lower half of destination address
        $upDM  = (($this->destMask) >> 16) & 0xFFFF;    // upper half of destination Mask
        $lowDM = ($this->destMask) & 0xFFFF;            // lower half of destination mask
        
        return $this->seqNumber . "#" . ($this->permitDeny ? "permit" : "deny"). "#" . // 0, 1
                $this->protocol . "#" .             // 2
                $upSA . "#" . $lowSA . "#" .        // 3, 4
                $upSM . "#" . $lowSM . "#" .        // 5, 6
                $upDA . "#" . $lowDA . "#" .        // 7, 8
                $upDM . "#" . $lowDM . "#" .        // 9, 10
                $this->portType . "#" . $this->port  . "#" . $this->port2;  // 11, 12, 13
    }
    
    /**
     * Initialize an ACE object from serialized data.
     * @param type $serStr A string of parameters separated by "#" as created by
     * the serialize method.
     */
    public function initialize($serStr) {
        $arayparm = explode("#", $serStr);      // split values into an array
        $this->seqNumber  = intval($arayparm[0]);
        $this->permitDeny = ($arayparm[1] == "permit") ? true : false;
        $this->protocol   = intval($arayparm[2]);
        $this->sourceAddr = (intval($arayparm[3],0)<< 16) | intval($arayparm[4],0);
        $this->sourceMask = (intval($arayparm[5],0)<< 16) | intval($arayparm[6],0);
        $this->destAddr   = (intval($arayparm[7],0)<< 16) | intval($arayparm[8],0);
        $this->destMask   = (intval($arayparm[9],0)<< 16) | intval($arayparm[10],0);
        $this->portType   = intval($arayparm[11]);
        $this->port       = intval($arayparm[12]);
        $this->port2      = intval($arayparm[13]);
    }
    
    /**
     * Create an ACE object from a line of text containing a single access control
     * list entity.
     * @param aceCommand A line of text containing an access control command
     * @throws Exception if there is a syntax error in the command.
     * The text of the exception explains the error and the code is the approximate
     * location in the string that is incorrect.
     */

    static public function parse($aceCommand) {
        // The ACE object being created
        $result = new ACE();
        // index into token array
        $tokX = 0;
        // location of error in command
        $errLoc = 0;
        
        // replace tabs with spaces for explode to work well
        $cleanCommand = str_replace("\t", " ", trim($aceCommand));
        do {
            $cleanLen = strlen($cleanCommand);
            $cleanCommand = str_replace("  ", " ", $cleanCommand); // remove multiple spaces           
        } while ($cleanLen !== strlen($cleanCommand));  // repeat until all double spaces removed
        // Create an array of words from command
        $token = explode(" ", $cleanCommand);
        //!! DEBUG
//        for ($k = 0; $k < count($token); $k++) {
//            echo  $k . " " . $token[$k] . "<br>";
//        }
        //!! end of DEBUG
        if (count($token) < 5) {
            throw new ParseException("The access-list command is incomplete and needs additional fields, not " . count($token), 0);
        }

        // Commands must start with "access-list"
        if (strcasecmp($token[$tokX], 'access-list') != 0) {
            throw new ParseException('Firewall commands must start with access-list', $errLoc);
        }
        $errLoc += strlen($token[$tokX++]) + 1;	// increment indexes
        // Get the sequence number of the ACE
        if(is_numeric($token[$tokX])) {
            $result->seqNumber = intval($token[$tokX]);
        } else {
            throw new ParseException('Invalid or missing sequence number', $errLoc);
        }
        // if invalid number
        if (!(($result->seqNumber > 0 && $result->seqNumber < 200) || 
                ($result->seqNumber >= 2000 && $result->seqNumber <= 2699))) {
            throw new ParseException('Sequence number ' . $result->seqNumber . 
                    'must be 0-199 or 2000-2999', $errLoc);
        }
        $errLoc += strlen($token[$tokX++]) + 1; // increment indexes

        if (strcasecmp($token[$tokX], 'permit') == 0) {
            $result->permitDeny = true;
        } else if (strcasecmp($token[$tokX], 'deny') == 0) {
            $result->permitDeny = false;
        } else {
            throw new ParseException('Must specify permit or deny', $errLoc);
        }
        $errLoc += strlen($token[$tokX++]) + 1; // increment indexes

        // An optional protocol can be specified
        for ($i = 0; $i < count($result->PROTNAME); $i++) {
            if (strcasecmp($token[$tokX], $result->PROTNAME[$i]) == 0){
                $result->protocol = $i;
                $errLoc += strlen($token[$tokX++]) + 1; // increment indexes
            }
        }

        // The source address of the transmission
        if (strcasecmp($token[$tokX], 'any') == 0){ // if any address
            $result->sourceAddr = 0; // unused any address
            $result->sourceMask = 0xFFFFFFFF; // mask for any address
            $errLoc += strlen($token[$tokX++]) + 1; // increment indexes
        } 
        // If a specific host is specified as an IP address after "host"
        else if (strcasecmp($token[$tokX], 'host') == 0){
            // increment indexes
            $errLoc += strlen($token[$tokX++]) + 1;
            if ($tokX >= count($token)) {
                throw new ParseException('IP address required after <strong>host</strong>"', $errLoc);
            }
            // convert IP address
            $result->sourceAddr = ACE::ip2int($token[$tokX], $errLoc);
            $result->sourceMask = 0;	// mask for single address
            $errLoc += strlen($token[$tokX++]) + 1; // increment indexes
        }
        // If this is a numerical field, the the source address should be a
        // an IP address followed by a mask
        else if(is_numeric(substr($token[$tokX], 0, 1))){
            $result->sourceAddr = ACE::ip2int($token[$tokX], $errLoc); // yes, convert IP address
            $errLoc += strlen($token[$tokX++]) + 1; // increment indexes
            if ($tokX >= count($token)) {
                throw new ParseException("Missing source mask after source IP address", $errLoc);
            }
            if(is_numeric(substr($token[$tokX], 0, 1))){ // is this a numerical field
                $result->sourceMask =ACE::ip2int($token[$tokX], $errLoc); // yes, convert IP mask
                $errLoc += strlen($token[$tokX++]) + 1; // increment indexes
            } else{
                throw new ParseException('Incorrect source mask ' .$token[$tokX] . 'or missing <strong>host</strong>', $errLoc);
            }
        } else {
            throw new ParseException('Incorrect protocol or source address', $errLoc);
        }

        // The destination address of the transmission
        if ($tokX >= count($token)) {
            throw new ParseException("A destination address must be specified", $errLoc);
        }
        if (strcasecmp($token[$tokX], 'any') == 0){ // if any address
            $result->destAddr = 0; // unused any address
            $result->destMask = 0xFFFFFFFF; // mask for any address
            $errLoc += strlen($token[$tokX++]) + 1; // increment indexes
        } 
        // if specific host
        else if (strcasecmp($token[$tokX], 'host') == 0){
            $errLoc += strlen($token[$tokX++]) + 1; // increment indexes past host
            if ($tokX >= count($token)) {
                throw new ParseException("An IP address is required after host", $errLoc);
            }
            $result->destAddr = ACE::ip2int($token[$tokX], $errLoc); // convert IP address
            $result->destMask = 0;	 // mask for single address
            $errLoc += strlen($token[$tokX++]) + 1; // increment indexes
        }
        // If this is a numerical field, then the destination should be an
        // IP address and mask pair
        else if(is_numeric(substr($token[$tokX], 0, 1))){
            $result->destAddr = ACE::ip2int($token[$tokX], $errLoc); // convert IP mask
            $errLoc += strlen($token[$tokX++]) + 1; // increment indexes
            if ($tokX >= count($token)) {
                throw new ParseException('Missing <strong>host</strong> or address mask required after destination address', $errLoc);
            }
            if(is_numeric(substr($token[$tokX], 0, 1))){  // is this a numerical field
                $result->destMask = ACE::ip2int($token[$tokX], $errLoc); // convert IP mask
                $errLoc += strlen($token[$tokX++]) + 1; // increment indexes
            } else {
                throw new ParseException('Incorrect destination mask <strong>' . $token[$tokX] . '</strong>', $errLoc);
            }
        } else {
            throw new ParseException('Incorrect destination address', $errLoc);
        }

        // check for a port operator
        if ($tokX < count($token)) { // remaining fields are optional
            if (strcasecmp($token[$tokX], 'est') == 0 || strcasecmp($token[$tokX], 'established') == 0){ 
                $result->portType = $result->PTEST;
                $errLoc += strlen($token[$tokX++]) + 1; // increment indexes
            } else {
                if(strcasecmp($token[$tokX], 'eq') == 0) {
                    $result->portType = $result->PTEQ;
                } else if(strcasecmp($token[$tokX], 'neq') == 0) {
                    $result->portType = $result->PTNEQ;
                } else if(strcasecmp($token[$tokX], 'gt') == 0) {
                    $result->portType = $result->PTGT;
                } else if(strcasecmp($token[$tokX], 'lt') == 0) {
                    $result->portType = $result->PTLT;
                } else if(strcasecmp($token[$tokX], 'range') == 0) {
                    $result->portType = $result->PTRANGE;
                }
                if ($result->portType != 0) {
                    $errLoc += strlen($token[$tokX++]) + 1; // increment indexes past operator
                    if ($tokX >= count($token)) {
                        throw new ParseException("A port number is required after " . $token[$tokX-1], $errLoc);
                    }
                    if (is_numeric(substr($token[$tokX], 0, 1))) {  // numeric port number expected
                        $result->port = intval($token[$tokX]);
                    } else {
                        throw new ParseException('Invalid port number ' . $token[$tokX], $errLoc);
                    }
                    if($result->port < 0 || $result->port > 65535) {
                        throw new ParseException('Port numbers must be 0-65535', $errLoc); 
                    }
                    $errLoc += strlen($token[$tokX++]) + 1; // increment indexes past port
                    if ($result->portType == $result->PTRANGE) {
                        if ($tokX >= count($token)) {
                            throw new ParseException("Two port numbers are required for range ", $errLoc);
                        }
                        if (is_numeric(substr($token[$tokX], 0, 1))) {  // numeric port number expected
                            $result->port2 = intval($token[$tokX]);
                        } else{
                            throw new ParseException('Nonnumeric port number ' . $token[$tokX], $errLoc);
                        }
                        if ($result->port2 < 0 || $result->port2 > 65535) {
                            throw new ParseException('Port numbers must be 0-65535', $errLoc);
                        }
                        if ($result->port2 < $result->port){
                            throw new ParseException('The second port number in a range must be greater than the first', $errLoc);
                        }
                        $errLoc += strlen($token[$tokX++]) + 1; // increment indexes past port 
                    }
                }	
            }

            /* Check if anything left over. If the last word is not "log", then something is left over */
            if (($tokX < count($token)) && (strcasecmp($token[$tokX], 'log') != 0)){
                throw new ParseException('additional text <strong>' . $token[$tokX] . 
                        '</strong> at the end of the command', $errLoc);
            } 
        }

        /* If a port number was specified, then the protocol must be either TCP or UDP */
        if (($result->port !== -1) && !(($result->protocol === $result->PROTTCP) ||
                ($result->protocol === $result->PROTUDP))) {
            throw new ParseException('Port numbers can only be specified for the TCP or UDP protocols', $errLoc);
        }
        return $result;
    }


    /**
     * The tranCheck method checks if a simulated transmission would be impacted
     * by the access control entity.
     * @param tranSource the IP address of the simulated transmission's source as
     * a 32 bit integer.
     * @param tranDest The IP address of the simulated transmission's destination as
     * a 32 bit integer.
     * @param tranProtocol The protocol of the simulated transmission. This can be 
     * any one of the protocol constants defined in the ACE class.
     * @param tranPort The port number of the simulated transmission's destination.
     * If no port number was specified, then this value should be -1.
     * @return A return value of zero indicates that this ACE does not pertain
     * to this transmission. It does not deny the transmission nor does it
     * specifically permit it. A value of 1 indiates that the transmission is 
     * permitted by this ACE. A value of 2 indicates that the transmission is
     * prohibited or denied by this ACE.
     */

    public function tranCheck($tranSource, $tranDest, $tranProtocol, $tranPort) {
        // Check if the source address matches
        $invSrcMask = ~($this->sourceMask); // invert the source address mask
        if (($this->sourceAddr & $invSrcMask) != ($tranSource & $invSrcMask)) {
            return 0; // this ACE does not apply
        }

        // Check if the destination address matches
        $invDestMask = ~($this->destMask);
        if (($this->destAddr & $invDestMask) != ($tranDest & $invDestMask)){
            return 0;  // this ACE does not apply
        }

        /* If a protocol was specified in the ACE, the protocol of the
         * transmission must match */
        if ($this->protocol === $this->PROTTCP || $this->protocol === $this->PROTUDP){
            if($tranProtocol != $this->protocol){
                return 0; // this ACE does not apply
            }

            // If the protocol is TCP or UDP, check if the port matches
            switch($this->portType){
                case $this->PTNONE: // no port specified in ACE accept anything
                    break;
                case $this->PTEQ: // transmission port must equal ACE port
                    if($tranPort != $this->port) {
                        return 0; // transmission port is not affected by ACE
                    }
                    break;
                case $this->PTNEQ: // transmission port must not equal ACE port
                    if($tranPort == $this->port) {
                        return 0; // transmission port is not affected by ACE
                    }
                    break;
                case $this->PTLT: // transmission port must be less than ACE port
                    if($tranPort >= $this->port) {
                        return 0; // transmission port is not affected by ACE
                    }
                    break;
                case $this->PTGT: // trasmission port must be greater than ACE port
                    if($tranPort <= $this->port) {
                        return 0; // transmission port is not affected by ACE
                    }
                    break;
                case $this->PTRANGE: // transmission port must be in ACE port range
                    if(($tranPort < $this->port) || ($tranPort > $this->port2)) {
                        return 0; // transmission port is not affected by ACE
                    }
                    break;
                case $this->PTEST: // transmission comes from established connection
                        // !! ?? what to do about this
                        return 0; // until better solution, ignore
            }
        }
        // This transmission applies to this ACE
        return $this->permitDeny ? 1 : 2;
    }		

    /**
     * Converts a text IP address in the form "12.34.56.78" to a 32 bit integer
     * with the same value.  In this example the most significant byte wil
     * contain the decimal value 12 while the least significant byte will be 78.
     * @param ipAddr Text version of an IP address.
     * @param $column The starting column of this IP address in the configuration.
     * Used to generate more accurate position of errors.
     * @return The IP address in 32 bit integer format.
     * @throws java.text.ParseException If there is a syntax error in the command.
     * The text of the exception explains the error and the index is the approximate
     * location in the string that is incorrect.
     */
    public static function ip2int($ipAddr, $column){
        $ip = 0;            // resulting 32 bit integer
        $num = -1;          // value of a byte
        $b = explode(".", $ipAddr);
        if (count($b) != 4) {
            throw new ParseException('Four bytes required in an IP address or mask', $column);
        }
        // for each byte
        for($i=0; $i<4; $i++){
            if (is_numeric($b[$i])) {
                $num = intval($b[$i]);          // convert text to integer
            } else {
                throw new ParseException("non-numeric value " . $b[$i] . " in IP address or mask", $column+3*$i);
            }
            if($num < 0 || $num > 255){ // check for out of range
                throw new ParseException("IP address byte " . $num . " must be between 0 and 255", $column+3*$i);
            }
            $ip <<= 8;      // shift previous values left one byte
            $ip |= $num;    // put byte in integer
        }
        return $ip;
    }	

}
?>
