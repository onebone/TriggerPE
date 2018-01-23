<?php

namespace onebone\triggerpe\parser\statement;

use onebone\triggerpe\parser\Parser;
use onebone\triggerpe\statement\Statement;
use onebone\triggerpe\statement\StatementChat;
use onebone\triggerpe\Value;

class ParserChat extends StatementParser {
	public function parse(): Statement {
		$lines = $this->getLines();

		$message = '';
		while(!$lines->isEnd() and !Parser::isCommand($lines->get())){
			$message .= $lines->get() . ' ';

			$lines->next();
		}

		return new StatementChat($this->getPlugin(), new Value($message, Value::TYPE_STRING));
	}

	public function needNext(): bool{
		return false;
	}
}
