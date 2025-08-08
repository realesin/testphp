<?php
namespace pocketmine\network\protocol\p70;

use pocketmine\utils\p70\Binary;

class UseItemPacket extends DataPacket{
	const NETWORK_ID = Info::USE_ITEM_PACKET;

	public $x;
	public $y;
	public $z;
	public $face;
	public $item;
	public $fx;
	public $fy;
	public $fz;
	public $posX;
	public $posY;
	public $posZ;

	public function decode(){
		$this->x = (PHP_INT_SIZE === 8 ? unpack("N", $this->get(4))[1] << 32 >> 32 : unpack("N", $this->get(4))[1]);
		$this->y = (PHP_INT_SIZE === 8 ? unpack("N", $this->get(4))[1] << 32 >> 32 : unpack("N", $this->get(4))[1]);
		$this->z = (PHP_INT_SIZE === 8 ? unpack("N", $this->get(4))[1] << 32 >> 32 : unpack("N", $this->get(4))[1]);
		$this->face = ord($this->get(1));
		$this->fx = (ENDIANNESS === 0 ? unpack("f", $this->get(4))[1] : unpack("f", strrev($this->get(4)))[1]);
		$this->fy = (ENDIANNESS === 0 ? unpack("f", $this->get(4))[1] : unpack("f", strrev($this->get(4)))[1]);
		$this->fz = (ENDIANNESS === 0 ? unpack("f", $this->get(4))[1] : unpack("f", strrev($this->get(4)))[1]);
		$this->posX = (ENDIANNESS === 0 ? unpack("f", $this->get(4))[1] : unpack("f", strrev($this->get(4)))[1]);
		$this->posY = (ENDIANNESS === 0 ? unpack("f", $this->get(4))[1] : unpack("f", strrev($this->get(4)))[1]);
		$this->posZ = (ENDIANNESS === 0 ? unpack("f", $this->get(4))[1] : unpack("f", strrev($this->get(4)))[1]);

		$this->item = $this->getSlot();
	}

	public function encode(){

	}

}
