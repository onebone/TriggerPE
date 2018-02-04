<?php

namespace onebone\triggerpe\parser\statement;

use onebone\triggerpe\parser\Lines;
use onebone\triggerpe\parser\Parser;
use onebone\triggerpe\statement\Statement;
use onebone\triggerpe\TriggerPE;

abstract class StatementParser {
	/** @var TriggerPE */
	private $plugin;

	/** @var Lines */
	private $lines;

	/** @var bool */
	private $needNext = true;

	public function __construct(TriggerPE $plugin, Lines $lines){
		$this->plugin = $plugin;

		$this->lines = $lines;
	}

	public function getPlugin(): TriggerPE {
		return $this->plugin;
	}

	protected function getLines(): Lines {
		return $this->lines;
	}

	public function readUntilNextCommand(): string {
		$this->needNext = false;

		$message = '';
		while(!$this->lines->isEnd() and !Parser::isCommand($this->lines->get())){
			$message .= $this->lines->get() . ' ';

			$this->lines->next();
		}

		return $message;
	}

	public function needNext(): bool {
		return $this->needNext;
	}

	abstract public function parse(): Statement;
}
