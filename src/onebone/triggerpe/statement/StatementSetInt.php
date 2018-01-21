<?php

namespace onebone\triggerpe\statement;

use onebone\triggerpe\Environment;
use onebone\triggerpe\TriggerPE;
use onebone\triggerpe\Value;
use onebone\triggerpe\Variable;

class StatementSetInt extends Statement {
	/** @var string */
	private $var;
	/** @var Value */
	private $value;

	public function __construct(TriggerPE $plugin, string $var, Value $value, $next = null){
		parent::__construct($plugin, $next);

		$this->var = $var;
		$this->value = $value;
	}

	public function execute(Environment $env): ?Value{
		$env->setVariable($this->var, new Variable($env, new Value($this->value->getInt($env), Value::TYPE_INT), Value::TYPE_INT));

		return $this->value;
	}

	public function getReturnType(): int{
		return Value::TYPE_INT;
	}
}
