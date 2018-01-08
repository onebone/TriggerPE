<?php

namespace onebone\triggerpe;

class Environment{
	/** @var TriggerPE */
	private $plugin;

	/** @var Variable[] */
	private $variables = [];

	public function __construct(TriggerPE $plugin){
		$this->plugin = $plugin;
	}

	public function getPlugin(): TriggerPE {
		return $this->plugin;
	}

	/**
	 * Set variable value of environment
	 *
	 * @param string $name
	 * @param Variable $var
	 */
	public function setVariable(string $name, Variable $var){
		$this->variables[$name] = $var;
	}

	/**
	 * Get variable value from environment
	 *
	 * @param string $name
	 * @return null|Variable
	 */
	public function getVariable(string $name): ?Variable {
		return $this->variables[$name];
	}
}
