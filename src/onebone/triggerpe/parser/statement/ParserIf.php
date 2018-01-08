<?php

namespace onebone\triggerpe\parser\statement;

use onebone\triggerpe\statement\Statement;

class ParserIf extends StatementParser {
	/** @var Statement */
	private $condition = null, $stmt = null, $elseStmt = null;

	public function isWordRequired(string $word): bool {

	}

	public function isArgumentCountAvailable(int $count): bool {
	}

	public function getDefaultArgumentCount(): int {
	}

	public function getFinalStatement(): Statement {
	}
}
