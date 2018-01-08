<?php

namespace onebone\triggerpe;

use onebone\triggerpe\parser\Parser;
use onebone\triggerpe\statement\Statement;

class Environment{
	/** @var TriggerPE */
	private $plugin;

	/** @var Variable[] */
	private $variables = [];

	/** @var string[] */
	private $lines = [];

	public function __construct(TriggerPE $plugin, $lines = []){
		$this->plugin = $plugin;

		$this->lines = $lines;
	}

	public function execute(){
		$parser = new Parser($this->plugin, $this->lines);
		$stmt = $parser->parse();

		$this->executeStatement($stmt);
	}

	public function executeStatement(Statement $stmt){
		do{
			$stmt->execute($this);
		}while(($stmt = $stmt->getNextStatement()) instanceof Statement);
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
		return $this->variables[$name] ?? null;
	}

	/**
	 * Get all variables of environment
	 *
	 * @return Variable[]
	 */
	public function getVariables(): array {
		return $this->variables;
	}
}
