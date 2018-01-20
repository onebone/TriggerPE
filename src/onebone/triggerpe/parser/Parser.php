<?php

namespace onebone\triggerpe\parser;

use onebone\triggerpe\parser\error\InvalidCommandError;
use onebone\triggerpe\parser\statement\ParserAddInt;
use onebone\triggerpe\parser\statement\ParserChat;
use onebone\triggerpe\parser\statement\ParserIf;
use onebone\triggerpe\parser\statement\ParserSetInt;
use onebone\triggerpe\statement\DummyStatement;
use onebone\triggerpe\statement\Statement;
use onebone\triggerpe\TriggerPE;

class Parser {
	/** @var TriggerPE */
	private $plugin;

	/** @var Lines */
	private $lines;

	/** @var string[] */
	private $until;

	public function __construct(TriggerPE $plugin, Lines $lines, $until = null){
		$this->plugin = $plugin;

		$this->lines = $lines;
		$this->until = $until;
	}

	public function parse(): Statement {
		$init = null;
		/** @var Statement $ptr */
		$ptr = null;

		$connect = function(Statement $stmt) use (&$init, &$ptr) {
			if($init === null){
				$ptr = $init = $stmt;
			}else{
				$ptr->setNextStatement($stmt);
				$ptr = $ptr->getNextStatement();
			}
		};

		while(!$this->lines->isEnd()){
			$word = $this->lines->get();

			if(self::isCommand($word)){
				$cmd = strtoupper(self::getCommand($word));

				if($this->until !== null and in_array($cmd, $this->until)) break;

				$this->lines->next();
				switch($cmd){
					case 'SETINT':
						$parser = new ParserSetInt($this->plugin, $this->lines);
						$connect($parser->parse());
						break;
					case 'ADDINT':
						$parser = new ParserAddInt($this->plugin, $this->lines);
						$connect($parser->parse());
						break;
					case 'IF':
						$parser = new ParserIf($this->plugin, $this->lines);
						$connect($parser->parse());
						break;
					case 'CHAT':
						$parser = new ParserChat($this->plugin, $this->lines);
						$connect($parser->parse());
						break;
					default:
						throw new InvalidCommandError($cmd, $this->lines->getCurrentLine());
				}

				if($parser !== null and !$parser->needNext()){
					continue;
				}
			}

			$this->lines->next();
		}

		if($init === null) return new DummyStatement($this->plugin);
		return $init;
	}

	public static function isCommand($word): bool {
		return strlen($word) > 1 and $word{0} === '@';
	}

	public static function getCommand($word): string {
		return substr($word, 1);
	}
}
