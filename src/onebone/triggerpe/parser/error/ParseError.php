<?php

namespace onebone\triggerpe\parser\error;

class ParseError extends \Exception {
	private $stmtLine;

	public function __construct($message, string $line, int $stmtLine, int $stmtColumn, int $length, $code = 0){
		$message .= " at line $stmtLine\n";
		$message .= $line . "\n";
		$message .= str_repeat(' ', $stmtColumn) . '^' . str_repeat('~', $length);

		parent::__construct($message, $code);

		$this->stmtLine = $stmtLine;
	}

	public function getStatementLine(): int {
		return $this->stmtLine;
	}
}
