<?php

namespace onebone\triggerpe;

class Value {
	private $value;
	private $dataType;

	public function __construct($value, int $dataType){
		$this->value = $value;
		$this->dataType = $dataType;
	}

	public function isVariable(): bool {
		return Variable::isVariable($this->value);
	}

	public function getType(Environment $env){
		if($this->isVariable()){
			$var = $env->getVariable($this->value);
			if($var === null) return null;
			return $var->getType();
		}

		return $this->dataType;
	}

	public function getValue(Environment $env){
		if($this->isVariable()){
			$var = $env->getVariable($this->value);
			if($var === null) return null;
			return $var->getValue();
		}

		return $this->value;
	}

	public function getInt(Environment $env): int {
		return (int) $this->getValue($env);
	}

	public function getString(Environment $env): string {
		return (string) $this->getValue($env);
	}

	public function getBool(Environment $env): bool {
		return (bool) $this->getValue($env);
	}
}
