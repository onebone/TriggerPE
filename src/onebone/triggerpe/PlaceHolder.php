<?php

namespace onebone\triggerpe;

use pocketmine\event\Event;
use pocketmine\Player;

interface PlaceHolder {
	public function getValue(Event $event): Value;
}
