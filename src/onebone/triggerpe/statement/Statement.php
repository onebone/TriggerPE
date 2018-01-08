<?php

namespace onebone\triggerpe\statement;

use onebone\triggerpe\Environment;
use onebone\triggerpe\TriggerPE;
use onebone\triggerpe\Value;

abstract class Statement{
	/** @var TriggerPE */
	private $plugin;

	/** @var Statement */
	private $next;

	public function __construct(TriggerPE $plugin, ?Statement $next = null){
		$this->plugin = $plugin;

		$this->next = $next;
	}

	abstract public function execute(Environment $env): ?Value;
	abstract public function getReturnType(): int;

	public function getPlugin(): TriggerPE {
		return $this->plugin;
	}

	/**
	 * Returns statement which will be executed next
	 *
	 * @return null|Statement
	 */
	public function getNextStatement(): ?Statement {
		return $this->next;
	}

	/**
	 * Sets statement which will be executed next
	 *
	 * @param Statement $next
	 */
	public function setNextStatement(Statement $next){
		$this->next = $next;
	}
}
