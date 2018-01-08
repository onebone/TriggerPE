<?php

namespace onebone\triggerpe\parser\statement;

use onebone\triggerpe\parser\error\UnexpectedArgumentTypeError;
use onebone\triggerpe\statement\Statement;
use onebone\triggerpe\statement\StatementAddInt;
use onebone\triggerpe\Value;
use onebone\triggerpe\Variable;

class ParserAddInt extends StatementParser {
	private $var;
	private $value;

	public function addWord(int $line, string $word){
		switch($this->getWordCount()){
			case 0:
				if($word{0} !== '$') throw new UnexpectedArgumentTypeError($word, 'VARIABLE', $line);
				$this->var = $word;
				break;
			case 1:
				if(is_numeric($word) or Variable::isVariable($word)){
					$this->value = new Value($word, Variable::TYPE_INT);
				}else{
					throw new UnexpectedArgumentTypeError($word, 'INT', $line);
				}
				break;
		}

		parent::addWord($line, $word);
	}

	public function isWordRequired(string $word): bool {
		return $this->getWordCount() < $this->getDefaultArgumentCount();
	}

	public function isArgumentCountAvailable(int $count): bool{
		return $count === 2;
	}

	public function getDefaultArgumentCount(): int {
		return 2;
	}

	public function getFinalStatement(): Statement{
		return new StatementAddInt($this->getPlugin(), $this->var, $this->value);
	}
}
