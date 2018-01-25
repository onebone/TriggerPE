<?php

namespace onebone\triggerpe;

use onebone\triggerpe\statement\error\RuntimeError;
use onebone\triggerpe\parser\Lines;
use pocketmine\event\Event;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\plugin\PluginBase;

class TriggerPE extends PluginBase implements Listener {
	const FLAG_EVENT_PLAYER = 0b1;
	const FLAG_EVENT_ITEM = 0b10;
	const FLAG_EVENT_BLOCK = 0b100;

	/** @var PlaceHolder[] */
	static $placeholders = [];

	private $scripts = [];

	/** @var TriggerPE */
	private static $instance = null;

	/**
	 * Returns instance of TriggerPE
	 *
	 * @return TriggerPE
	 */
	public static function getInstance(){
		return self::$instance;
	}

	public static function addPlaceHolder(string $name, PlaceHolder $placeholder){
		if(isset(self::$placeholders[$name])) return false;

		self::$placeholders[$name] = $placeholder;
		return true;
	}

	public static function getPlaceHolder(string $name, Event $event, int $flag): ?Value {
		if(isset(self::$placeholders[$name])){
			$ph = self::$placeholders[$name];
			if(($ph->flag() & $flag) === $ph->flag()){
				return self::$placeholders[$name]->getValue($event);
			}
		}

		return null;
	}

	public static function replacePlaceHolders(Environment $env, string $str): string {
		preg_match_all('<([a-zA-Z0-9]+)>', $str, $out);
		foreach($out[1] as $res){
			$val = TriggerPE::getPlaceHolder($res, $env->getEvent(), $env->getFlag());

			if($val === null) continue;

			$str = str_replace("<$res>", $val->getString($env), $str);
		}

		return $str;
	}

	/**
	 * Executes script directly.
	 *
	 * $flag provides what methods do event have.
	 * For instance, if event has method getPlayer(), you
	 * should provide TriggerPE::FLAG_EVENT_PLAYER to make
	 * placeholders and statements run properly. If script
	 * attempts to replace placeholder or run statement
	 * which flag did not include, TriggerPE will throw
	 * RuntimeError.
	 * If event has multiple methods, for instance, getPlayer()
	 * and getBlock(), you can provide with bit-OR(|) operation.
	 * TriggerPE::FLAG_EVENT_PLAYER | TriggerPE::FLAG_EVENT_BLOCK
	 *
	 * @param string $code
	 * @param Event $event
	 * @param int $flag
	 *
	 * @throws RuntimeError
	 *
	 * @return Environment
	 */
	public function executeScript(string $code, Event $event, int $flag): Environment{
		$env = new Environment($this, $event, $flag, new Lines([$code]));
		$env->execute();

		return $env;
	}

	/**
	 * Executes pre-defined scripts for events.
	 * To run script directly, use TriggerPE->executeScript() instead.
	 *
	 * @param string $name
	 * @param Event $event
	 * @param int $flag
	 *
	 * @throws RuntimeError
	 */
	public function runScripts(string $name, Event $event, int $flag){
		foreach($this->scripts[$name] ?? [] as $lines){
			$env = new Environment($this, $event, $flag, $lines);
			$env->execute();
		}
	}

	public function onEnable(){
		self::$instance = $this;

		$this->initPlaceHolders();

		$this->saveDefaultConfig();
		$this->saveResource('scripts/join.txt');
		$this->parseScripts();

		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	}

	private function parseScripts(){
		$scripts = $this->getConfig()->get("scripts", []);
		foreach($scripts as $e => $s){
			$e = strtoupper($e);

			$codes = [];
			foreach($s as $f){
				$codes[] = new Lines([file_get_contents($this->getDataFolder() . $f)]);
			}

			$this->scripts[$e] = $codes;
		}
	}

	private function initPlaceHolders(){
		$this->addPlaceHolder('username', new class implements PlaceHolder {
			public function flag(): int {
				return TriggerPE::FLAG_EVENT_PLAYER;
			}

			public function getValue(Event $event): Value {
				/** @var PlayerEvent $event */
				return new Value($event->getPlayer()->getName(), Value::TYPE_STRING);
			}
		});

		$this->addPlaceHolder('itemid', new class implements PlaceHolder {
			public function flag(): int {
				return TriggerPE::FLAG_EVENT_PLAYER;
			}

			public function getValue(Event $event): Value {
				/** @var PlayerEvent $event */
				return new Value($event->getPlayer()->getInventory()->getItemInHand()->getId(), Value::TYPE_INT);
			}
		});

		$this->addPlaceHolder('health', new class implements PlaceHolder {
			public function flag(): int {
				return TriggerPE::FLAG_EVENT_PLAYER;
			}

			public function getValue(Event $event): Value {
				/** @var PlayerEvent $event */
				return new Value($event->getPlayer()->getHealth(), Value::TYPE_INT);
			}
		});
	}

	public function onPlayerJoin(PlayerJoinEvent $event){
		$this->runScripts('JOIN', $event, TriggerPE::FLAG_EVENT_PLAYER);
	}
}
