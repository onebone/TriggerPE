<?php

namespace onebone\triggerpe\parser\error;

class UnexpectedArgumentTypeError extends ParseError {
	public function __construct(string $got, string $expected, int $line){
		parent::__construct("Unexpected argument type got $got, expected $expected", $line);
	}
}
