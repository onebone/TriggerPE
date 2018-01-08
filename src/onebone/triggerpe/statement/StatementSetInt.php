<?php

namespace onebone\triggerpe\statement;

use onebone\triggerpe\Environment;
use onebone\triggerpe\TriggerPE;
use onebone\triggerpe\Variable;

class StatementSetInt extends Statement {
	/** @var string */
	private $var;
	/** @var int */
	private $value;

	public function __construct(TriggerPE $plugin, string $var, int $value, $next = null){
		parent::__construct($plugin, $next);

		$this->var = $var;
		$this->value = $value;
	}

	public function execute(Environment $env){
		$env->setVariable($this->var, new Variable($this->value, Variable::TYPE_INT));

		return $this->value;
	}

	public function getReturnType(): int{
		return Variable::TYPE_INT;
	}
}
