<?php

namespace onebone\triggerpe\statement;

use onebone\triggerpe\Environment;
use onebone\triggerpe\Value;

class DummyStatement extends Statement {
	public function execute(Environment $env){

	}

	public function getReturnType(): int{
		return Value::TYPE_VOID;
	}
}
