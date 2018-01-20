<?php

namespace onebone\triggerpe\statement;

use onebone\triggerpe\Environment;
use onebone\triggerpe\TriggerPE;
use onebone\triggerpe\Value;

class StatementAnd extends Statement {
	/** @var Statement */
	private $a, $b;

	public function __construct(TriggerPE $plugin, Statement $a, Statement $b, $next = null){
		parent::__construct($plugin, $next);

		$this->a = $a;
		$this->b = $b;
	}

	public function execute(Environment $env): ?Value{
		return new Value($this->a->execute($env)->getBool($env) and $this->b->execute($env)->getBool($env), Value::TYPE_BOOL);
	}

	public function getReturnType(): int{
		return Value::TYPE_BOOL;
	}
}
