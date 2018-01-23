<?php

namespace onebone\triggerpe\statement;

use onebone\triggerpe\Environment;
use onebone\triggerpe\TriggerPE;
use onebone\triggerpe\Value;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\block\SignChangeEvent;
use pocketmine\event\player\PlayerEvent;

class StatementChat extends Statement {
	/** @var Value */
	private $message;

	public function __construct(TriggerPE $plugin, Value $message, $next = null){
		parent::__construct($plugin, $next);

		$this->message = $message;
	}

	public function execute(Environment $env): ?Value{
		$e = $env->getEvent();
		if($e instanceof PlayerEvent
			or $e instanceof BlockPlaceEvent
			or $e instanceof BlockBreakEvent
			or $e instanceof SignChangeEvent){
			$e->getPlayer()->sendMessage($this->message->getString($env));
		}

		return null;
	}

	public function getReturnType(): int{
		return Value::TYPE_VOID;
	}
}
