<?php

namespace onebone\triggerpe\parser\statement;

use onebone\triggerpe\statement\Statement;

class ParserAnd extends StatementParser {
	public function isWordRequired(string $word): bool{
		return false;
	}

	public function isArgumentCountAvailable(int $count): bool{
		// TODO: Implement isArgumentCountAvailable() method.
	}

	public function getDefaultArgumentCount(): int{
		// TODO: Implement getDefaultArgumentCount() method.
	}

	public function getFinalStatement(): Statement{
		// TODO: Implement getFinalStatement() method.
	}
}
