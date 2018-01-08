<?php

namespace onebone\triggerpe\statement;

use onebone\triggerpe\Environment;
use onebone\triggerpe\TriggerPE;
use onebone\triggerpe\Variable;

class StatementIf extends Statement {
	/** @var Statement */
	private $condition, $stmt;

	public function __construct(TriggerPE $plugin, ?Statement $next, Statement $condition, ?Statement $stmt){
		parent::__construct($plugin, $next);

		$this->condition = $condition;
		$this->stmt = $stmt;
	}

	public function execute(Environment $env){
		$res = $this->condition->execute($env);

		$isTrue = false;
		switch($this->condition->getReturnType()){
			case Variable::TYPE_BOOL:
				$isTrue = $res === true;
				break;
			case Variable::TYPE_INT:
				$isTrue = $res > 0;
				break;
			case Variable::TYPE_STRING:
				$isTrue = $res === 'true';
				break;
		}

		if($isTrue){
			if($this->stmt instanceof Statement){
				$this->stmt->execute($env);
			}
		}
	}

	public function getCondition(): Statement {
		return $this->condition;
	}

	public function getReturnType(): int{
		return Variable::TYPE_VOID;
	}
}
