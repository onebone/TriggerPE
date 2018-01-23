<?php

namespace onebone\triggerpe\statement;

use onebone\triggerpe\Environment;
use onebone\triggerpe\Value;
use pocketmine\plugin\PluginBase;

class StatementGreater extends Statement {
	/** @var Value */
	private $a, $b;

	public function __construct(PluginBase $plugin, Value $a, Value $b, $next = null){
		parent::__construct($plugin, $next);

		$this->a = $a;
		$this->b = $b;
	}

	public function execute(Environment $env): ?Value{
		return new Value($this->a->getInt($env) > $this->b->getInt($env), Value::TYPE_BOOL);
	}

	public function getReturnType(): int{
		return Value::TYPE_BOOL;
	}
}
