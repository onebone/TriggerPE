<?php

namespace onebone\triggerpe\parser\error;

class UnexpectedWordError extends ParseError {
	public function __construct($word, string $line, int $stmtLine, int $stmtColumn, int $length){
		parent::__construct('Unexpected word "' . $word . '"', $line, $stmtLine, $stmtColumn, $length);
	}
}
