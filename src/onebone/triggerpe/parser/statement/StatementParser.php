<?php

namespace onebone\triggerpe\parser\statement;

use onebone\triggerpe\statement\Statement;
use onebone\triggerpe\TriggerPE;

abstract class StatementParser {
	/** @var TriggerPE */
	private $plugin;

	/** @var string[] */
	private $words = [];

	public function __construct(TriggerPE $plugin){
		$this->plugin = $plugin;

		$this->words = [];
	}

	public function getPlugin(): TriggerPE {
		return $this->plugin;
	}

	public function addWord(int $line, string $word){
		$this->words[] = $word;
	}

	public function getLastAddedWord(): string {
		$len = count($this->words);
		if($len > 0){
			return $this->words[$len - 1];
		}

		return '';
	}

	public function getWords(): array {
		return $this->words;
	}

	public function clearWords(){
		$this->words = [];
	}

	public function getWordCount(): int {
		return count($this->words);
	}

	abstract public function isWordRequired(string $word): bool;
	abstract public function isArgumentCountAvailable(int $count): bool;
	abstract public function getDefaultArgumentCount(): int;
	abstract public function getFinalStatement(): Statement;
}
