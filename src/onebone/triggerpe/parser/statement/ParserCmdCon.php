<?php

namespace onebone\triggerpe\parser\statement;

use onebone\triggerpe\statement\Statement;
use onebone\triggerpe\statement\StatementCmdCon;
use onebone\triggerpe\Value;

class ParserCmdCon extends StatementParser {
	public function parse(): Statement{
		$cmd = $this->readUntilNextCommand();

		return new StatementCmdCon($this->getPlugin(), new Value($cmd, Value::TYPE_STRING));
	}
}
