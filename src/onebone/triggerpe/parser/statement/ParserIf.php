<?php

namespace onebone\triggerpe\parser\statement;

use onebone\triggerpe\parser\error\InvalidOperatorError;
use onebone\triggerpe\parser\Lines;
use onebone\triggerpe\parser\Parser;
use onebone\triggerpe\statement\Statement;
use onebone\triggerpe\statement\StatementAnd;
use onebone\triggerpe\statement\StatementBoolean;
use onebone\triggerpe\statement\StatementEquals;
use onebone\triggerpe\statement\StatementGreater;
use onebone\triggerpe\statement\StatementIf;
use onebone\triggerpe\Value;

class ParserIf extends StatementParser {
	const LOGIC_AND = 0;
	const LOGIC_OR = 1;

	public function parse(): Statement {
		$lines = $this->getLines();
		$logic = -1;

		$condStmt = null;

		while(true){
			$cond = $this->readCondition($lines);

			if($logic === self::LOGIC_AND){
				if($condStmt === null){
					$condStmt = $cond;
				}else{
					$condStmt = new StatementAnd($this->getPlugin(), $cond, $condStmt);
				}
			}else{
				$condStmt = $cond;
			}

			$lines->next();
			if(Parser::isCommand($lines->get())){
				$cmd = strtoupper(Parser::getCommand($lines->get()));

				if($cmd === 'AND'){
					$logic = self::LOGIC_AND;

					$lines->next();
				}elseif($cmd === 'OR'){
					$logic = self::LOGIC_OR;

					$lines->next();
				}else{
					break;
				}
			}
		}

		$parser = new Parser($this->getPlugin(), $lines, ['ELSE', 'ENDIF']);
		$stmt = $parser->parse();

		return new StatementIf($this->getPlugin(), $condStmt, $stmt); // TODO @ELSE
	}

	public function readCondition(Lines $lines): Statement {
		$val = $lines->get();
		$lines->next();
		$op = $lines->get();
		if(Parser::isCommand($op)){ // @IF $b @AND ...
			return new StatementBoolean($this->getPlugin(), new Value($val, Value::TYPE_BOOL));
		}else{ // @IF $b = $a ...
			$lines->next();
			$val2 = $lines->get();

			switch($op){
				case '=':
					return new StatementEquals($this->getPlugin(), new Value($val, Value::TYPE_UNKNOWN), new Value($val2, Value::TYPE_UNKNOWN));
				case '>':
					return new StatementGreater($this->getPlugin(), new Value($val, Value::TYPE_UNKNOWN), new Value($val2, Value::TYPE_UNKNOWN));
				case '<':
					return new StatementGreater($this->getPlugin(), new Value($val2, Value::TYPE_UNKNOWN), new Value($val, Value::TYPE_UNKNOWN));
				default:
					throw new InvalidOperatorError(
						$op,
						$lines->getLine(),
						$lines->getCurrentLine(),
						$lines->getCurrentColumn(),
						1);
			}
		}
	}
}
