<?php

namespace onebone\triggerpe\statement;

use onebone\triggerpe\Environment;
use onebone\triggerpe\TriggerPE;
use onebone\triggerpe\Value;
use onebone\triggerpe\Variable;

class StatementAddInt extends Statement {
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
		$var = $env->getVariable($this->var);
		if($var === null){
			$var = new Variable($env, new Value(0, Value::TYPE_INT), Value::TYPE_INT);
		}

		$final = $var->getValue() + $this->value->getInt($env);
		$env->setVariable($this->var, new Variable($env, new Value($final, Value::TYPE_INT), Value::TYPE_INT));

		return new Value($final, Value::TYPE_INT);
	}

	public function getReturnType(): int{
		return Value::TYPE_INT;
	}
}
