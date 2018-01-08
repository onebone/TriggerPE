<?php

namespace onebone\triggerpe\parser;

class Line {
	/** @var string */
	private $line;

	/** @var string[] */
	private $words = [];

	public function __construct(string $line){
		$this->line = $line;

		$this->words = explode(' ', $line);
	}

	public function getLine(): string {
		return $this->line;
	}

	public function getWords(): array {
		return $this->words;
	}
}
