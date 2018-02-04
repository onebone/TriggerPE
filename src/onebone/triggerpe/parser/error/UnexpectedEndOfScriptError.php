<?php

namespace onebone\triggerpe\parser\error;

class UnexpectedEndOfScriptError extends ParseError {
	public function __construct(int $stmtLine, string $line, int $stmtColumn, int $length){
		parent::__construct('Unexpected end of script', $line, $stmtLine, $stmtColumn, $length);
	}
}
