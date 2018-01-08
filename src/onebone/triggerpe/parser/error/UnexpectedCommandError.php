<?php

namespace onebone\triggerpe\parser\error;

class UnexpectedCommandError extends ParseError {
	public function __construct(string $command, int $line){
		parent::__construct("Unexpected command $command", $line);
	}
}
