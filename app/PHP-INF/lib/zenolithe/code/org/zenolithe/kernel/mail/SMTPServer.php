<?php
namespace org\zenolithe\kernel\mail;

class SMTPServer {
	private $host;
	private $port;
	private $localHost;
	private $mailServer;
	private $lastReturnCode;
	private $lastServerResponse;
	private $connected = false;
	private $status = '';
	
	public function setHost($host) {
		$this->host = $host;
	}
	
	public function setPort($port) {
		$this->port = $port;
	}
	
	public function setLocalHost($localHost) {
		$this->localHost = $localHost;
	}
	
	public function getStatus() {
		return $this->status;
	}
	
	private function connect() {
		$this->mailServer = fsockopen($this->host, $this->port, $errno, $errstr, 60);
		if($this->mailServer) {
			$this->connected = true;
			do {
				$response = fgets($this->mailServer) ;
			} while($response[3] == '-');
		} else {
			$this->status = "Connection failed to $this->host:$this->port: ($errno) $errstr";
		}
		
		return $this->connected;
	}
	
	public function send($recipients, $from, $data) {
		if($this->connect()) {
			if($this->status == '') {
				$this->sendCommand("HELO $this->localHost", 250);
			}
			if($this->status == '') {
				$this->sendCommand("MAIL FROM:<$from>", 250);
				if($this->status != '') {
					$this->status = "X";
				}
				foreach($recipients as $recipient) {
					if($this->status == '') {
						$this->sendCommand("RCPT TO:<$recipient>", 250);
					}
				}
			}
			if($this->status == '')	{
				$this->sendCommand("DATA", 354) ;
			}
			if($this->status == '') {
				$this->sendCommand($data."\r\n.", 250) ;
			}
			$this->sendCommand("QUIT", 221) ;
			fclose($this->mailServer);
		}
		
		return ($this->status == '');
	}
	
	private function sendCommand($command, $expectedReturnCode) {
		fputs($this->mailServer, "$command\r\n") ;
		$this->lastServerResponse = fgets($this->mailServer);
		$code = sscanf($this->lastServerResponse, "%d") ;
		$this->lastReturnCode = $code[0] ;
		if($this->lastReturnCode != $expectedReturnCode) {
			$this->status = "Invalid response from server, $command returned $this->lastServerResponse:$this->lastReturnCode, expected $expectedReturnCode";
		}
	}
}
?>