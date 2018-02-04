<?php

namespace onebone\triggerpe\parser\statement;


use onebone\triggerpe\statement\Statement;
use onebone\triggerpe\statement\StatementCmdOp;
use onebone\triggerpe\Value;

class ParserCmdOp extends StatementParser {
	public function parse(): Statement{
		$cmd = $this->readUntilNextCommand();

		return new StatementCmdOp($this->getPlugin(), new Value($cmd, Value::TYPE_STRING));
	}
}
