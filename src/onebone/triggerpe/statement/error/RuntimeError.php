<?php

namespace onebone\triggerpe\parser\error;

class RuntimeError extends \Exception {
	// TODO
	//private $stmtLine;

	public function __construct($message, $code = 0){
		parent::__construct($message, $code);

		//$this->stmtLine = $stmtLine;
	}

	/*public function getStatementLine(): int {
		return $this->stmtLine;
	}*/
}
