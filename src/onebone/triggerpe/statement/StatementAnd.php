<?php

namespace onebone\triggerpe\statement;

use onebone\triggerpe\Environment;
use onebone\triggerpe\statement\error\NoReturnValueError;
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
		$val1 = $this->a->execute($env);
		if($val1->getType($env) === Value::TYPE_VOID) throw new NoReturnValueError();

		$val2 = $this->b->execute($env);
		if($val2->getType($env) === Value::TYPE_VOID) throw new NoReturnValueError();

		return new Value($val1->getBool($env) and $val2->getBool($env), Value::TYPE_BOOL);
	}

	public function getReturnType(): int{
		return Value::TYPE_BOOL;
	}
}
