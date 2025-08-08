<?php
namespace pocketmine\network\protocol\p70;

use pocketmine\utils\p70\Binary;

class MovePlayerPacket extends DataPacket{
	const NETWORK_ID = Info::MOVE_PLAYER_PACKET;

	const MODE_NORMAL = 0;
	const MODE_RESET = 1;
	const MODE_ROTATION = 2;

	public $eid;
	public $x;
	public $y;
	public $z;
	public $yaw;
	public $bodyYaw;
	public $pitch;
	public $mode = self::MODE_NORMAL;
	public $onGround;

	public function clean(){
		$this->teleport = \false;
		return parent::clean();
	}

	public function decode(){
		$this->eid = Binary::readLong($this->get(8));
		$this->x = (ENDIANNESS === 0 ? unpack("f", $this->get(4))[1] : unpack("f", strrev($this->get(4)))[1]);
		$this->y = (ENDIANNESS === 0 ? unpack("f", $this->get(4))[1] : unpack("f", strrev($this->get(4)))[1]);
		$this->z = (ENDIANNESS === 0 ? unpack("f", $this->get(4))[1] : unpack("f", strrev($this->get(4)))[1]);
		$this->yaw = (ENDIANNESS === 0 ? unpack("f", $this->get(4))[1] : unpack("f", strrev($this->get(4)))[1]);
		$this->bodyYaw = (ENDIANNESS === 0 ? unpack("f", $this->get(4))[1] : unpack("f", strrev($this->get(4)))[1]);
		$this->pitch = (ENDIANNESS === 0 ? unpack("f", $this->get(4))[1] : unpack("f", strrev($this->get(4)))[1]);
		$this->mode = ord($this->get(1));
		$this->onGround = ord($this->get(1)) > 0;
	}

	public function encode(){
		$this->buffer = chr(self::NETWORK_ID); $this->offset = 0;;
		$this->buffer .= Binary::writeLong($this->eid);
		$this->buffer .= (ENDIANNESS === 0 ? pack("f", $this->x) : strrev(pack("f", $this->x)));
		$this->buffer .= (ENDIANNESS === 0 ? pack("f", $this->y) : strrev(pack("f", $this->y)));
		$this->buffer .= (ENDIANNESS === 0 ? pack("f", $this->z) : strrev(pack("f", $this->z)));
		$this->buffer .= (ENDIANNESS === 0 ? pack("f", $this->yaw) : strrev(pack("f", $this->yaw)));
		$this->buffer .= (ENDIANNESS === 0 ? pack("f", $this->bodyYaw) : strrev(pack("f", $this->bodyYaw))); //TODO
		$this->buffer .= (ENDIANNESS === 0 ? pack("f", $this->pitch) : strrev(pack("f", $this->pitch)));
		$this->buffer .= chr($this->mode);
		$this->buffer .= chr($this->onGround > 0);
	}

}
