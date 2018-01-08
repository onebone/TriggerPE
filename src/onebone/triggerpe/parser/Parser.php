<?php

namespace onebone\triggerpe\parser;

use onebone\triggerpe\parser\error\InvalidCommandError;
use onebone\triggerpe\parser\error\UnexpectedCommandError;
use onebone\triggerpe\parser\error\UnexpectedEndOfScriptError;
use onebone\triggerpe\parser\statement\ParserAddInt;
use onebone\triggerpe\parser\statement\ParserSetInt;
use onebone\triggerpe\parser\statement\StatementParser;
use onebone\triggerpe\statement\DummyStatement;
use onebone\triggerpe\statement\Statement;
use onebone\triggerpe\TriggerPE;

class Parser {
	/** @var TriggerPE */
	private $plugin;
	/** @var Line[] */
	private $lines = [];

	public function __construct(TriggerPE $plugin, $lines){
		$this->plugin = $plugin;

		foreach($lines as $line){
			if(is_string($line)){
				$this->lines[] = new Line($line);
			}elseif($line instanceof Line){
				$this->lines[] = $line;
			}else{
				throw new \InvalidArgumentCountException('Invalid type of line was given. Expected string, \onebone\triggerpe\Line, got' . get_class($line));
			}
		}
	}

	public function parse(): Statement {
		$parser = null;

		$stmt = null;
		$init = null;

		$canPass = true;

		foreach($this->lines as $index=>$line){
			$words = $line->getWords();

			foreach($words as $word){
				if(strlen($word) === 0) continue;

				if($parser instanceof StatementParser){
					if($parser->isWordRequired($word)){
						$parser->addWord($index, $word);

						if($parser->isArgumentCountAvailable($parser->getWordCount())){
							$canPass = true;
						}

						continue;
					}
				}
				if($this->isCommand($word)){
					if(!$canPass) throw new UnexpectedCommandError($word, $index);
					elseif($parser instanceof StatementParser){
						if($stmt instanceof Statement){
							$stmt->setNextStatement($parser->getFinalStatement());
							$stmt = $stmt->getNextStatement();
						}else{
							$stmt = $parser->getFinalStatement();
							$init = $stmt;
						}
					}

					$cmd = $this->getCommand($word);
					switch(strtoupper($cmd)){
						case 'SETINT';
							$parser = new ParserSetInt($this->plugin);
							$canPass = false;
							break;
						case 'ADDINT':
							$parser = new ParserAddInt($this->plugin);
							$canPass = false;
							break;
						default: throw new InvalidCommandError($word, $index);
					}
				}
			}
		}

		if(!$canPass) throw new UnexpectedEndOfScriptError(count($this->lines));
		if($parser instanceof StatementParser){
			if($stmt instanceof Statement){
				$stmt->setNextStatement($parser->getFinalStatement());
			}else{
				$stmt = $parser->getFinalStatement();
				$init = $stmt;
			}
		}

		if($init === null){
			return new DummyStatement($this->plugin);
		}

		return $init;
	}

	public static function isCommand($word): bool {
		return strlen($word) > 1 and $word{0} === '@';
	}

	public static function getCommand($word): string {
		return substr($word, 1);
	}
}
