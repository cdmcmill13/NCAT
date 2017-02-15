<?php
/* FireSim firewall educational simulation
 * Define an array of Action objects that provide the details of an attack or
 * action a player can take.
 */

$TCPPROTOCOL=1;         // TCP protocol
$UDPPROTOCOL = 2;       // UDP protocol

$actionList["web"] = new Action(
	"View the home page of their website",      // title
	"1.2.3.4", "152.8.1.1",                     // source & dest address
	$TCPPROTOCOL,  443,  false,                 // protocol, port and scoreif
	"#a successfully and safely accessed your web server.",                 // victim happy
	"#a was prevented from accessing your web server using HTTPS. -1 point",// victim sad
	"You were denied access to #v's web server. +1 point",                  // attacker happy
	"You successfully accessed #v's web server. No change in score.");      // attacker sad

$actionList["dns"] = new Action(
	"Retrieve an IP address from their Domain Name Server",
	"1.2.3.4", "152.8.3.3",
	$UDPPROTOCOL,  53,  false,
	"#a successfully and safely accessed your Domain Name Server.",
	"#a was prevented from accessing your Domain Name Server. -1 point",
	"You were denied access to #v's Domain Name Server. +1 point",
	"You successfully accessed #v's Domain Name Server. No change in score.");

$actionList["email"] = new Action(
	"Send regular email.",
	"1.2.3.4", "152.8.2.2",
	$TCPPROTOCOL,  25,  false,
	"#a successfully and safely send you email.",
	"#a was prevented from sending you safe email. -1 point",
	"You were prevented from sending email to #v. +1 point",
	"You successfully sent email to #v. No change in score.");

$actionList["altdns"] = new Action(
	"Retrieve an IP address from the backup Domain Name Server",
	"1.2.3.4", "152.8.4.4",
	$UDPPROTOCOL,  53,  false,
	"#a successfully and safely accessed your backup Domain Name Server.",
	"#a was prevented from accessing your backup Domain Name Server. -1 point",
	"You were denied access to #v's backup Domain Name Server. +1 point",
	"You successfully accessed #v's backup Domain Name Server. No change in score.");

$actionList["pop"] = new Action(
	"Access email via POP from the Internet.",
	"1.2.3.4", "152.8.2.2",
	$TCPPROTOCOL,  110,  false,
	"#a successfully and safely read email via POP3.",
	"#a was prevented from reading email over the Internet via POP. -1 point",
	"You were prevented from reading #v email via POP. +1 point",
	"You successfully read #v email via POP. No change in score.");

$actionList["NOpop"] = new Action(
	"Access email via unauthorized POP from the Internet.",
	"1.2.3.4", "152.8.2.2",
	$TCPPROTOCOL,  110,  true,
	"#a was prevented from reading email over the Internet via unauthorized POP.",
	"#a read email via unauthorized POP3. -1 point",
        "You successfully read #v email via unauthorized POP. +1 point",
	"You were prevented from reading #v email via unauthorized POP. No change in score.");

$actionList["imap"] = new Action(
	"Access email via IMAP4 from the Internet.",
	"1.2.3.4", "152.8.2.2",
	$TCPPROTOCOL,  143,  false,
	"#a successfully and safely read email via IMAP.",
	"#a was prevented from reading email over the Internet via IMAP. -1 point",
	"You were prevented from reading #v email via IMAP. +1 point",
	"You successfully read #v email via IMAP. No change in score.");

$actionList["NOimap"] = new Action(
	"Access email via unauthorized IMAP4 from the Internet.",
	"1.2.3.4", "152.8.2.2",
	$TCPPROTOCOL,  143,  true,
	"#a was prevented from reading email over the Internet via unauthorized IMAP.",
	"#a read email via unauthorized IMAP. -1 point",
        "You successfully read #v email via unauthorized IMAP. +1 point",
	"You were prevented from reading #v email via unauthorized IMAP. No change in score.");

$actionList["ftp"] = new Action(
	"Copy a file from their FTP server",
	"1.2.3.4", "152.8.4.4",
	$TCPPROTOCOL,  21,  false,
	"#a successfully and safely accessed your FTP server.",
	"#a was prevented from accessing your FTP server. -1 point",
	"You were denied access to #v's FTP server. +1 point",
	"You successfully accessed #v's FTP server. No change in score.");

$actionList["NOftp"] = new Action(
	"Copy a file from their unauthorized FTP server",
	"1.2.3.4", "152.8.4.4",
	$TCPPROTOCOL,  21,  true,
	"#a was properly prevented from accessing an unauthorized FTP server.",
	"#a accessed your unauthorized FTP server. -1 point",
	"You were allowed access to #v's unauthorized FTP server. +1 point",
	"You were prevented from accessing #v's unauthorized FTP server. No change in score.");

$actionList["ftpweb"] = new Action(
	"Copy a file using FTP from their web server",
	"1.2.3.4", "152.8.1.1",
	$TCPPROTOCOL,  21,  false,
	"#a successfully and safely used FTP on your web server.",
	"#a was prevented from using FTP on your web server. -1 point",
	"You were denied FTP access to #v's web server. +1 point",
	"You successfully accessed FTP on #v's web server. No change in score.");

$actionList["waste"] = new Action(
	"Employees access www.wasteoftime.com.",
	"152.8.100.25", "1.2.3.4",
	$TCPPROTOCOL,  80,  true,
	"Employees were prevented from accessed www.wasteoftime.com as requested by #a.",
	"Employees successfully accessed www.wasteoftime.com as requested by #a. -1 point",
	"#v employees successfully accessed www.wasteoftime.com . +1 point",
	"#v employees were prevented from accessed www.wasteoftime.com. No change in score.");

$actionList["NOwaste"] = new Action(
	"Employees allows to access www.wasteoftime.com.",
	"152.8.100.25", "1.2.3.4",
	$TCPPROTOCOL,  80,  false,
	"Employees successfully accessed www.wasteoftime.com as requested by #a.",
	"Employees were prevented from accessing www.wasteoftime.com as requested by #a. -1 point",
	"#v employees were prevented from accessing www.wasteoftime.com.  +1 point",
        "#v employees successfully accessed www.wasteoftime.com. No change in score.");

$actionList["aol"] = new Action(
	"Send an AOL instant message.",
	"1.2.3.4", "152.8.100.1",
	$TCPPROTOCOL,  5190,  false,
	"#a successfully and safely sent an AOL instant message.",
	"#a was prevented from sending an AOL instant message. -1 point",
	"You were prevented from sending #v an AOL instant message. +1 point",
	"You successfully sent #v an AOL instant message. No change in score.");

$actionList["mydoom"] = new Action(
	"Mydoom backdoor access to system",
	"1.2.3.4", "152.8.100.1",
	$TCPPROTOCOL,  3127,  true,
	"#a unsuccessfully attempted backdoor access with myDoom worm.",
	"#a successfully accessed a computer with MyDoom.A worm. -1 point",
	"You successfully accessed a #v computer using MyDoom.A. +1 point",
	"#v's firewall prevented MyDoom.A access. No change in score.");

$actionList["vpn"] = new Action(
	"VPN access to Jane's computer",
	"1.2.3.4", "152.8.100.2",
	$TCPPROTOCOL,  1723,  true,
	"#a successfully accessed Jane.firewall.edu using VPN.",
	"#a could not access Jane.firewall.edu using VPN. -1 point",
	"You could not access #v's network using VPN. +1 point",
	"You could accessed #v's network using VPN. No change in score.");

$actionList["NOvpn"] = new Action(
	"Unauthorized VPN access to Jane's computer",
	"1.2.3.4", "152.8.100.2",
	$TCPPROTOCOL,  1723,  false,
	"#a could not access Jane.firewall.edu using unauthorized VPN.",
	"#a successfully accessed Jane.firewall.edu using unauthorized VPN. -1 point",
        "You could accessed #v's network using unauthorized VPN. +1 point",
	"You could not access #v's network using unauthorized VPN. No change in score.");

?>