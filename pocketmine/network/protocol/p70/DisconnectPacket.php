<?php
namespace pocketmine\network\protocol\p70;

use pocketmine\utils\p70\Binary;

class DisconnectPacket extends DataPacket{
	const NETWORK_ID = Info::DISCONNECT_PACKET;

	public $message;

	public function decode(){
		$this->message = $this->getString();
	}

	public function encode(){
		$this->buffer = chr(self::NETWORK_ID); $this->offset = 0;;
		$this->putString($this->message);
	}

}
