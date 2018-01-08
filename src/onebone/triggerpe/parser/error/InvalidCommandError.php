<?php

namespace onebone\triggerpe\parser\error;

class InvalidCommandError extends ParseError {
	public function __construct(string $command, int $line){
		parent::__construct("Invalid command $command given", $line);
	}
}
