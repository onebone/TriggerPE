<?php

namespace onebone\triggerpe\parser\statement;

use onebone\triggerpe\parser\Parser;
use onebone\triggerpe\statement\Statement;
use onebone\triggerpe\statement\StatementChat;
use onebone\triggerpe\Value;

class ParserChat extends StatementParser {
	public function isWordRequired(string $word): bool{
		return $this->getWordCount() === 0 or !Parser::isCommand($word);
	}

	public function isArgumentCountAvailable(int $count): bool{
		return $count > 0;
	}

	public function getDefaultArgumentCount(): int{
		return 2;
	}

	public function getFinalStatement(): Statement{
		return new StatementChat($this->getPlugin(), new Value(implode(' ', $this->getWords()), Value::TYPE_STRING));
	}
}
