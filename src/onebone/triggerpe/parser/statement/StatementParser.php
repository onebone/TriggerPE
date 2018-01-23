<?php

namespace onebone\triggerpe\parser\statement;

use onebone\triggerpe\parser\Lines;
use onebone\triggerpe\statement\Statement;
use onebone\triggerpe\TriggerPE;
use pocketmine\plugin\PluginBase;

abstract class StatementParser {
	/** @var PluginBase */
	private $plugin;

	/** @var Lines */
	private $lines;

	public function __construct(PluginBase $plugin, Lines $lines){
		$this->plugin = $plugin;

		$this->lines = $lines;
	}

	public function getPlugin(): PluginBase {
		return $this->plugin;
	}

	protected function getLines(): Lines {
		return $this->lines;
	}

	public function needNext(): bool {
		return true;
	}

	abstract public function parse(): Statement;
}
