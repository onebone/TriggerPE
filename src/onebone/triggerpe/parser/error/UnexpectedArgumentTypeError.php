<?php

namespace onebone\triggerpe\parser\error;

class UnexpectedArgumentTypeError extends ParseError {
	public function __construct(string $got, string $expected, string $line, int $stmtLine, int $stmtColumn, int $length){
		parent::__construct("Unexpected argument type got $got, expected $expected", $line, $stmtLine, $stmtColumn, $length);
	}
}
