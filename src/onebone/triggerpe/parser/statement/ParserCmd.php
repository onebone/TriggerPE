<?php

namespace onebone\triggerpe\parser\statement;

use onebone\triggerpe\statement\Statement;
use onebone\triggerpe\statement\StatementCmd;
use onebone\triggerpe\Value;

class ParserCmd extends StatementParser {
	public function parse(): Statement{
		$cmd = $this->readUntilNextCommand();

		return new StatementCmd($this->getPlugin(), new Value($cmd, Value::TYPE_STRING));
	}
}
