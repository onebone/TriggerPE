<?php

namespace onebone\triggerpe\parser\statement;

use onebone\triggerpe\parser\error\UnexpectedArgumentTypeError;
use onebone\triggerpe\statement\Statement;
use onebone\triggerpe\statement\StatementSetInt;
use onebone\triggerpe\Value;
use onebone\triggerpe\Variable;

class ParserSetInt extends StatementParser {
	public function parse(): Statement{
		$lines = $this->getLines();

		$var = $lines->get();
		if(!Variable::isVariable($var)){
			throw new UnexpectedArgumentTypeError(
				'value', 'variable',
				$lines->getLine(),
				$lines->getCurrentLine(),
				$lines->getCurrentColumn(),
				strlen($var));
		}

		$lines->next();
		$val = $lines->get();

		return new StatementSetInt($this->getPlugin(), $var, new Value($val, Value::TYPE_INT));
	}
}
