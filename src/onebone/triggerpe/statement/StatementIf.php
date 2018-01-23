<?php

namespace onebone\triggerpe\statement;

use onebone\triggerpe\Environment;
use onebone\triggerpe\Value;
use pocketmine\plugin\PluginBase;

class StatementIf extends Statement {
	/** @var Statement */
	private $condition, $stmt, $elseStmt;

	public function __construct(PluginBase $plugin, Statement $condition, ?Statement $stmt = null, ?Statement $elseStmt = null, ?Statement $next = null){
		parent::__construct($plugin, $next);

		$this->condition = $condition;
		$this->stmt = $stmt;
		$this->elseStmt = $elseStmt;
	}

	public function execute(Environment $env): ?Value{
		$res = $this->condition->execute($env);

		$isTrue = false;

		if($res !== null){
			$isTrue = $res->getBool($env);
		}

		if($isTrue){
			if($this->stmt instanceof Statement){
				$env->executeStatement($this->stmt);
			}
		}else{
			if($this->elseStmt instanceof Statement){
				$env->executeStatement($this->elseStmt);
			}
		}

		return null;
	}

	public function setNextStatement(Statement $next){
		parent::setNextStatement($next);

		if($this->stmt instanceof Statement){
			$stmt = $this->stmt;
			while(true){
				if($stmt->getNextStatement() === null){
					$stmt->setNextStatement($next);
					break;
				}else{
					$stmt = $stmt->getNextStatement();
				}
			}
		}

		if($this->elseStmt instanceof Statement){
			$stmt = $this->elseStmt;
			while(true){
				if($stmt->getNextStatement() === null){
					$stmt->setNextStatement($next);
					break;
				}else{
					$stmt = $stmt->getNextStatement();
				}
			}
		}
	}

	public function getCondition(): Statement {
		return $this->condition;
	}

	public function getReturnType(): int{
		return Value::TYPE_VOID;
	}
}
