<?php

namespace onebone\triggerpe\statement;

use onebone\triggerpe\Environment;
use onebone\triggerpe\Value;
use pocketmine\plugin\PluginBase;

class StatementBoolean extends Statement {
	/** @var Value */
	private $bool;

	public function __construct(PluginBase $plugin, Value $bool, $next = null){
		parent::__construct($plugin, $next);

		$this->bool = $bool;
	}

	public function execute(Environment $env): ?Value{
		return $this->bool;
	}

	public function getReturnType(): int{
		return Value::TYPE_BOOL;
	}
}
