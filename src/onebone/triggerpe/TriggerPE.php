<?php

namespace onebone\triggerpe;

use onebone\triggerpe\parser\Lines;
use pocketmine\event\Event;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\plugin\PluginBase;

class TriggerPE extends PluginBase implements Listener {
	/** @var PlaceHolder[] */
	static $placeholders = [];

	private $scripts = [];

	public static function addPlaceHolder(string $name, PlaceHolder $placeholder){
		if(isset(self::$placeholders[$name])) return false;

		self::$placeholders[$name] = $placeholder;
		return true;
	}

	public static function getPlaceHolder(string $name, Event $event): ?Value {
		if(isset(self::$placeholders[$name])){
			return self::$placeholders[$name]->getValue($event);
		}

		return null;
	}

	public static function replacePlaceHolders(Environment $env, string $str): string {
		preg_match_all('<([a-zA-Z0-9]+)>', $str, $out);
		foreach($out[1] as $res){
			$val = TriggerPE::getPlaceHolder($res, $env->getEvent());

			if($val === null) continue;

			$str = str_replace("<$res>", $val->getString($env), $str);
		}

		return $str;
	}

	public function runScripts(string $name, Event $event){
		foreach($this->scripts[$name] ?? [] as $lines){
			$env = new Environment($this, $event, $lines);
			$env->execute();
		}
	}

	public function onEnable(){
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
			public function getValue(Event $event): Value {
				/** @var PlayerEvent $event */
				return new Value($event->getPlayer()->getName(), Value::TYPE_STRING);
			}
		});

		$this->addPlaceHolder('itemid', new class implements PlaceHolder {
			public function getValue(Event $event): Value {
				/** @var PlayerEvent $event */
				return new Value($event->getPlayer()->getInventory()->getItemInHand()->getId(), Value::TYPE_INT);
			}
		});

		$this->addPlaceHolder('health', new class implements PlaceHolder {
			public function getValue(Event $event): Value {
				/** @var PlayerEvent $event */
				return new Value($event->getPlayer()->getHealth(), Value::TYPE_INT);
			}
		});
	}

	public function onPlayerJoin(PlayerJoinEvent $event){
		$this->runScripts('JOIN', $event);
	}
}
