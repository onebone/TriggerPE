<?php

namespace onebone\triggerpe\statement;

use onebone\triggerpe\Environment;
use onebone\triggerpe\TriggerPE;
use onebone\triggerpe\Value;

class StatementAnd extends Statement {
	/** @var Value */
	private $a, $b;

	public function __construct(TriggerPE $plugin, Value $a, Value $b, $next = null){
		parent::__construct($plugin, $next);

		$this->a = $a;
		$this->b = $b;
	}

	public function execute(Environment $env){
		return $this->a->getBool($env) and $this->b->getBool($env);
	}

	public function getReturnType(): int{
		return Value::TYPE_BOOL;
	}
}
