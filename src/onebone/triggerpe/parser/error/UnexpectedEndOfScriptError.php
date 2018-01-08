<?php

namespace onebone\triggerpe\parser\error;

class UnexpectedEndOfScriptError extends ParseError {
	public function __construct(int $line){
		parent::__construct('Unexpected end of script', $line);
	}
}
