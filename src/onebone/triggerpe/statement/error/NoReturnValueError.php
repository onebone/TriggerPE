<?php

namespace onebone\triggerpe\statement\error;

use onebone\triggerpe\parser\error\RuntimeError;

class NoReturnValueError extends RuntimeError {
	public function __construct(){
		parent::__construct("No return value");
	}
}
