<?php

namespace onebone\triggerpe\parser\error;

class InvalidCommandError extends ParseError {
	public function __construct(string $command, int $stmtLine, string $line, int $stmtColumn, int $length){
		parent::__construct("Invalid command $command given", $line, $stmtLine, $stmtColumn, $length);
	}
}
