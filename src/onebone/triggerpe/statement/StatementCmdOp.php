<?php

namespace onebone\triggerpe\statement;

use onebone\triggerpe\Environment;
use onebone\triggerpe\TriggerPE;
use onebone\triggerpe\Value;
use pocketmine\event\player\PlayerEvent;

class StatementCmdOp extends Statement {
	/** @var Value */
	private $cmd;

	public function __construct(TriggerPE $plugin, Value $cmd, $next = null){
		parent::__construct($plugin, $next);

		$this->cmd = $cmd;
	}

	public function execute(Environment $env): ?Value {
		/** @var PlayerEvent $event */
		$event = $env->getEvent();
		$player = $event->getPlayer();

		$isOp = $player->isOp();
		$player->setOp(true);
		$this->getPlugin()->getServer()->dispatchCommand($player, $this->cmd->getString($env));
		$player->setOp($isOp);

		return null;
	}

	public function getReturnType(): int{
		return Value::TYPE_VOID;
	}

	public function flag(): int {
		return TriggerPE::FLAG_EVENT_PLAYER;
	}
}
