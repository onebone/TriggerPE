<?php

namespace onebone\triggerpe\parser\error;

class ParseError extends \Exception {
	private $stmtLine;

	public function __construct($message, int $stmtLine, $code = 0){
		parent::__construct($message . " at line $stmtLine", $code);

		$this->stmtLine = $stmtLine;
	}

	public function getStatementLine(): int {
		return $this->stmtLine;
	}
}
