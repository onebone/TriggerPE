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

	public function execute(Environment $env){
		$var = $env->getVariable($this->var);
		if($var === null){
			$var = new Variable(0, Variable::TYPE_INT);
		}

		$final = $var->getValue() + $this->value->getInt($env);
		$env->setVariable($this->var, new Variable($final, Variable::TYPE_INT));

		return $final;
	}

	public function getReturnType(): int{
		return Variable::TYPE_INT;
	}
}