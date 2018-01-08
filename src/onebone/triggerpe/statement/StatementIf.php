<?php

namespace onebone\triggerpe\statement;

use onebone\triggerpe\Environment;
use onebone\triggerpe\TriggerPE;
use onebone\triggerpe\Value;

class StatementIf extends Statement {
	/** @var Statement */
	private $condition, $stmt, $elseStmt;

	public function __construct(TriggerPE $plugin, Statement $condition, ?Statement $stmt, ?Statement $elseStmt, ?Statement $next = null){
		parent::__construct($plugin, $next);

		$this->condition = $condition;
		$this->stmt = $stmt;
	}

	public function execute(Environment $env): ?Value{
		$res = $this->condition->execute($env);

		$isTrue = false;

		if($res !== null){
			$isTrue = $res->getBool($env);
		}

		if($isTrue){
			if($this->stmt instanceof Statement){
				$this->stmt->execute($env);
			}
		}else{
			if($this->elseStmt instanceof StatementAnd){
				$this->elseStmt->execute($env);
			}
		}

		return null;
	}

	public function getCondition(): Statement {
		return $this->condition;
	}

	public function getReturnType(): int{
		return Value::TYPE_VOID;
	}
}
