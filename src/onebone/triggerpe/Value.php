<?php

namespace onebone\triggerpe;

class Value {
	const TYPE_VOID = 0; // UNKNOWN
	const TYPE_INT = 1;
	const TYPE_BOOL = 2;
	const TYPE_STRING = 3;

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
		$isVar = $this->isVariable();
		$value = $this->value;

		preg_match_all('<([a-zA-Z0-9]+)>', $this->value, $out);
		foreach($out[1] as $res){
			$val = TriggerPE::getPlaceHolder($res, $env->getPlayer(), null); // TODO: Pass event in the future

			if($val === null) continue;
			if($isVar or $this->getType($env) === Value::TYPE_STRING){
				$value = str_replace("<$res>", $val->getString($env), $value);
			}else{
				return $val->getValue($env);
			}
		}

		if($isVar){
			$var = $env->getVariable($this->value);
			if($var === null) return null;
			return $var->getValue();
		}

		return $value;
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
