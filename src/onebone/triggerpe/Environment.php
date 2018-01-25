<?php

namespace onebone\triggerpe;

use onebone\triggerpe\parser\Lines;
use onebone\triggerpe\parser\Parser;
use onebone\triggerpe\statement\error\InvalidStatementError;
use onebone\triggerpe\statement\error\RuntimeError;
use onebone\triggerpe\statement\Statement;
use pocketmine\event\Event;

class Environment{
	/** @var TriggerPE */
	private $plugin;

	/** @var Variable[] */
	private $variables = [];

	/**
	 * @var Event
	 */
	private $event;

	/**
	 * @var int
	 */
	private $flag;

	/** @var Lines */
	private $lines;

	public function __construct(TriggerPE $plugin, Event $event, int $flag, Lines $lines){
		$this->plugin = $plugin;

		$this->event = $event;
		$this->flag = $flag;
		$this->lines = $lines;
	}

	/**
	 * Parse and execute statement
	 *
	 * @throws RuntimeError
	 */
	public function execute(){
		$parser = new Parser($this->plugin, $this->lines);
		$stmt = $parser->parse();

		$this->executeStatement($stmt);
	}

	/**
	 * Executes statement to last
	 *
	 * @param Statement $stmt
	 *
	 * @throws RuntimeError
	 */
	public function executeStatement(Statement $stmt){
		do{
			if(($stmt->flag() & $this->flag) === $stmt->flag()){
				$stmt->execute($this);
			}else{
				throw new InvalidStatementError();
			}
		}while(($stmt = $stmt->getNextStatement()) instanceof Statement);
	}

	public function getPlugin(): TriggerPE {
		return $this->plugin;
	}

	public function getEvent(): Event {
		return $this->event;
	}

	public function getFlag(): int {
		return $this->flag;
	}

	/**
	 * Set variable value of environment
	 *
	 * @param string $name
	 * @param Variable $var
	 */
	public function setVariable(string $name, Variable $var){
		$name = TriggerPE::replacePlaceHolders($this, $name);

		$this->variables[$name] = $var;
	}

	/**
	 * Get variable value from environment
	 *
	 * @param string $name
	 * @return null|Variable
	 */
	public function getVariable(string $name): ?Variable {
		$name = TriggerPE::replacePlaceHolders($this, $name);

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
