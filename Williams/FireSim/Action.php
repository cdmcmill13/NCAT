<?php
/**
 * Action objects define an action a player may take against another player.
 */
class Action {
    // The title of the action in the GUI
    public $title;
    // The simulated IP address (in 32 bit integer format) of the source of the action.
    public $sourceIP;
    /**
    * The simulated IP address (in 32 bit integer format) of the destination of 
    * the action.
    */
    public $destIP;
    /**
    * The protocol to be used in the action.  The protocol is specified by its
    * integer value as defined in ACE.
    */
    public $protocol;
    /**
    * The port to be used in the action.
    */
    public $port;
    /**
    * If scoreif is true then the action scores points in the action is permitted.
    * If scoreif is false then points are scored if the action is denied.
    */
    public $scoreif;
    /**
    * Text of a happy message to send to the victim if their firewall protected
    * them.  Substitution of #a for the attacker's name may be required.
    */
    public $vHappy;
    /**
    * Text of a sad message to send to the victim if their firewall did not protect
    * them.  Substitution of #a for the attacker's name may be required.
    */
    public $vSad;
    /**
    * Text of a happy message to send to the attacker if they scored.
    * Substitution of #v for the victim's name may be required.
    */
    public $aHappy;
    /**
    * Text of a sad message to send to the attacker if the attack failed.
    * Substitution of #v for the victim's name may be required.
    */
    public $aSad;

    public function __construct($title, $sourceIP, $destIP, $protocol, $port, $scoreif, $vHappy, $vSad, $aHappy, $aSad) {
        $this->title = $title;
        $this->sourceIP = ACE::ip2int($sourceIP,-1);	// convert sourse address to binary
        $this->destIP = ACE::ip2int($destIP,-2);	// convert destination address to binary
        $this->protocol = $protocol;
        $this->port = $port;
        $this->scoreif = $scoreif;
        $this->vHappy = $vHappy;
        $this->vSad = $vSad;
        $this->aHappy = $aHappy;
        $this->aSad = $aSad;
    }	
}
?>
