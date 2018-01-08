<?php

namespace onebone\triggerpe\statement;

use onebone\triggerpe\Environment;
use onebone\triggerpe\Variable;

class DummyStatement extends Statement {
	public function execute(Environment $env){

	}

	public function getReturnType(): int{
		return Variable::TYPE_VOID;
	}
}
