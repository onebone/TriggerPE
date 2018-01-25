<?php

namespace onebone\triggerpe\statement\error;

class InvalidStatementError extends RuntimeError {
	public function __construct(){
		parent::__construct('Attempted to execute invalid statement');
	}
}
