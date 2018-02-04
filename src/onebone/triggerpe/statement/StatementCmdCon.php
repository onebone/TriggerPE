<?php

namespace onebone\triggerpe\statement;

use onebone\triggerpe\Environment;
use onebone\triggerpe\TriggerPE;
use onebone\triggerpe\Value;
use pocketmine\command\ConsoleCommandSender;

class StatementCmdCon extends Statement {
	/** @var Value */
	private $cmd;

	public function __construct(TriggerPE $plugin, Value $cmd, $next = null){
		parent::__construct($plugin, $next);

		$this->cmd = $cmd;
	}

	public function execute(Environment $env): ?Value {
		$this->getPlugin()->getServer()->dispatchCommand(new ConsoleCommandSender(), $this->cmd->getString($env));

		return null;
	}

	public function getReturnType(): int {
		return Value::TYPE_VOID;
	}
}
