<?php

namespace onebone\triggerpe;

use pocketmine\event\Event;
use pocketmine\Player;

interface PlaceHolder {
	/**
	 * This function tells what method of event is
	 * needed to use this placeholder.
	 * When condition is not fulfilled, getValue() will
	 * not be called.
	 *
	 * For example, if placeholder requires getPlayer()
	 * to return value, you should include TriggerPE::FLAG_EVENT_PLAYER
	 * to the flag.
	 *
	 * @return int
	 */
	public function flag(): int;
	public function getValue(Event $event): Value;
}
