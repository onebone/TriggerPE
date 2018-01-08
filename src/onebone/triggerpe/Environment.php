<?php

namespace onebone\triggerpe;

use onebone\triggerpe\parser\Parser;
use onebone\triggerpe\statement\Statement;
use pocketmine\Player;

class Environment{
	/** @var TriggerPE */
	private $plugin;

	/** @var Variable[] */
	private $variables = [];

	/** @var Player */
	private $player;

	/** @var string[] */
	private $lines = [];

	public function __construct(TriggerPE $plugin, Player $player, $lines = []){
		$this->plugin = $plugin;

		$this->player = $player;
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

	public function getPlayer(): Player {
		return $this->player;
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
