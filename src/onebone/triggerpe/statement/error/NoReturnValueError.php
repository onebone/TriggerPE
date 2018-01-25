<?php

namespace onebone\triggerpe\statement\error;

class NoReturnValueError extends RuntimeError {
	public function __construct(){
		parent::__construct("No return value");
	}
}
