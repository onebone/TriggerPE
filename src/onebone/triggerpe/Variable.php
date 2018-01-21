<?php

namespace onebone\triggerpe;

class Variable {
	private $value;
	private $type;
	private $env;

	public function __construct(Environment $env, Value $value, int $type){
		$this->env = $env;
		$this->value = $value;
		$this->type = $type;
	}

	public function getType(): int {
		return $this->type;
	}

	public function getValue(){
		return $this->value->getValue($this->env);
	}

	public function getInt(): int {
		return (int) $this->getValue();
	}

	public function getString(): string {
		return (string) $this->getValue();
	}

	public function getBool(): bool {
		return (bool) $this->getValue();
	}

	public static function isVariable(string $value): bool {
		return is_string($value) and strlen($value) > 1 and $value{0} === '$';
	}
}
