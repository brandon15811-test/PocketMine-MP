<?php

/*
 *
 *  ____            _        _   __  __ _                  __  __ ____
 * |  _ \ ___   ___| | _____| |_|  \/  (_)_ __   ___      |  \/  |  _ \
 * | |_) / _ \ / __| |/ / _ \ __| |\/| | | '_ \ / _ \_____| |\/| | |_) |
 * |  __/ (_) | (__|   <  __/ |_| |  | | | | | |  __/_____| |  | |  __/
 * |_|   \___/ \___|_|\_\___|\__|_|  |_|_|_| |_|\___|     |_|  |_|_|
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author PocketMine Team
 * @link http://www.pocketmine.net/
 *
 *
*/

declare(strict_types=1);

namespace pocketmine\network\mcpe;

use pocketmine\network\mcpe\protocol\Packet;
use pocketmine\network\mcpe\protocol\PacketPool;
use pocketmine\network\mcpe\serializer\NetworkBinaryStream;
use pocketmine\utils\BinaryDataException;

class PacketBatch extends NetworkBinaryStream{

	public function putPacket(Packet $packet) : void{
		$packet->encode();
		$this->putString($packet->getBuffer());
	}

	/**
	 * @return Packet
	 * @throws BinaryDataException
	 */
	public function getPacket() : Packet{
		return PacketPool::getPacket($this->getString());
	}

	/**
	 * Constructs a packet batch from the given list of packets.
	 *
	 * @param Packet ...$packets
	 *
	 * @return PacketBatch
	 */
	public static function fromPackets(Packet ...$packets) : self{
		$result = new self();
		foreach($packets as $packet){
			$result->putPacket($packet);
		}
		return $result;
	}
}
