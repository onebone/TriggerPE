<?php

namespace onebone\triggerpe\parser;

use onebone\triggerpe\parser\error\UnexpectedEndOfScriptError;

class Lines {
	/** @var string[] */
	private $lines;

	/** @var string[][] */
	private $words = [];

	/** @var int */
	private $currentLine = 0, $current = 0;

	/**
	 * Lines constructor.
	 *
	 * @param string[] $lines
	 */
	public function __construct($lines){
		$this->lines = $lines;

		foreach($lines as $line){
			$this->words[] = explode(' ', $line);
		}
	}

	public function getLines(): array {
		return $this->lines;
	}

	public function getWords(): array {
		return $this->words;
	}

	public function get(): string {
		$word = $this->words[$this->currentLine][$this->current] ?? null;
		if($word === null) throw new UnexpectedEndOfScriptError($this->currentLine);
		return $word;
	}

	public function getCurrentLine(): int {
		return $this->currentLine;
	}

	public function isEnd(): bool {
		return !isset($this->words[$this->currentLine][$this->current]);
	}

	public function next(){
		do{
			$this->current++;

			if(count($this->words[$this->currentLine]) <= $this->current){
				$this->current = 0;
				$this->currentLine++;
			}

			if(!isset($this->words[$this->currentLine][$this->current])) break;
		}while(trim($this->words[$this->currentLine][$this->current]) === '');
	}
}
