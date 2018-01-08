<?php

namespace onebone\triggerpe\parser\statement;

use onebone\triggerpe\parser\error\UnexpectedCommandError;
use onebone\triggerpe\parser\Parser;
use onebone\triggerpe\statement\Statement;
use onebone\triggerpe\statement\StatementIf;

class ParserIf extends StatementParser {
	/** @var Statement */
	private $condition = null, $stmt = null, $elseStmt = null;

	private $isCondition = false, $isStatement = false, $isEnd = false, $isElse = false, $isElseEnd = false;

	public function addWord(int $line, string $word){
		$uword = strtoupper($word);

		if(Parser::isCommand($uword)){
			if(!$this->isCondition){
				$this->isCondition = true;
			}elseif(!$this->isEnd and !$this->isStatement){
				$words = $this->getWords();
				$this->clearWords();
				$parser = new Parser($this->getPlugin(), $words);
				$stmt = $parser->parse(true);

				$this->condition = $stmt;

				$this->isStatement = true;
			}

			if($uword === '@ENDIF'){
				$words = $this->getWords();
				$this->clearWords();
				$parser = new Parser($this->getPlugin(), $words);
				$stmt = $parser->parse();
				if($this->isElse){
					$this->isElseEnd = true;
					$this->elseStmt = $stmt;
				}else{
					$this->stmt = $stmt;
				}

				$this->isEnd = true;
			}elseif($uword === '@ELSE'){
				if(!$this->isEnd){
					throw new UnexpectedCommandError($word, $line);
				}
				$this->isElse = true;
				return;
			}
		}

		parent::addWord($line, $word);
	}

	public function isWordRequired(string $word): bool {
		return $this->isEnd and strtoupper($word) === '@ELSE' or !$this->isEnd or $this->isElse and !$this->isElseEnd;
	}

	public function isArgumentCountAvailable(int $count): bool {
		return $this->getLastAddedWord() === '@ENDIF';
	}

	public function getDefaultArgumentCount(): int {
		return 2;
	}

	public function getFinalStatement(): Statement {
		return new StatementIf($this->getPlugin(), $this->condition, $this->stmt, $this->elseStmt);
	}
}
