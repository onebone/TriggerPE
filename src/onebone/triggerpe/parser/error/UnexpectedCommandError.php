<?php

namespace onebone\triggerpe\parser\error;

class UnexpectedCommandError extends ParseError {
	public function __construct(string $command, int $stmtLine, string $line, int $stmtColumn, int $length){
		parent::__construct("Unexpected command $command", $line, $stmtLine, $stmtColumn, $length);
	}
}
