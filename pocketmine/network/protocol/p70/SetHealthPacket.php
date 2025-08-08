<?php
namespace pocketmine\network\protocol\p70;

use pocketmine\utils\p70\Binary;

class SetHealthPacket extends DataPacket{
	const NETWORK_ID = Info::SET_HEALTH_PACKET;

	public $health;

	public function decode(){
		$this->health = (PHP_INT_SIZE === 8 ? unpack("N", $this->get(4))[1] << 32 >> 32 : unpack("N", $this->get(4))[1]);
	}

	public function encode(){
		$this->buffer = chr(self::NETWORK_ID); $this->offset = 0;;
		$this->buffer .= pack("N", $this->health);
	}

}
