<?php

namespace onebone\triggerpe\parser\error;

class InvalidOperatorError extends ParseError {
	public function __construct(string $operator, int $line){
		parent::__construct("Invalid operator $operator given", $line);
	}
}
