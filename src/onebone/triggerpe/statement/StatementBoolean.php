<?php

namespace onebone\triggerpe\statement;

use onebone\triggerpe\Environment;
use onebone\triggerpe\TriggerPE;
use onebone\triggerpe\Value;

class StatementBoolean extends Statement {
	/** @var Value */
	private $bool;

	public function __construct(TriggerPE $plugin, Value $bool, $next = null){
		parent::__construct($plugin, $next);

		$this->bool = $bool;
	}

	public function execute(Environment $env): ?Value{
		return $this->bool;
	}

	public function getReturnType(): int{
		return Value::TYPE_BOOL;
	}
}
