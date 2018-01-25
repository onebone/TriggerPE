<?php

namespace onebone\triggerpe\statement;

use onebone\triggerpe\Environment;
use onebone\triggerpe\TriggerPE;
use onebone\triggerpe\Value;
use pocketmine\event\player\PlayerEvent;

class StatementChat extends Statement {
	/** @var Value */
	private $message;

	public function __construct(TriggerPE $plugin, Value $message, $next = null){
		parent::__construct($plugin, $next);

		$this->message = $message;
	}

	public function flag(): int {
		return TriggerPE::FLAG_EVENT_PLAYER;
	}

	public function execute(Environment $env): ?Value{
		/** @var PlayerEvent $e */
		$e = $env->getEvent();
		$e->getPlayer()->sendMessage($this->message->getString($env));

		return null;
	}

	public function getReturnType(): int{
		return Value::TYPE_VOID;
	}
}
