<?php

namespace onebone\triggerpe\parser\error;

class InvalidOperatorError extends ParseError {
	public function __construct(string $operator, string $line, int $stmtLine, int $stmtColumn, int $length){
		parent::__construct("Invalid operator $operator given", $line, $stmtLine, $stmtColumn, $length);
	}
}
