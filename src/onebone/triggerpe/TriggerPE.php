<?php

namespace onebone\triggerpe;

use onebone\triggerpe\statement\Statement;
use pocketmine\event\Event;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;

class TriggerPE extends PluginBase{
	/** @var PlaceHolder[] */
	static $placeholders = [];

	public static function addPlaceHolder(string $name, PlaceHolder $placeholder){
		if(isset(self::$placeholders[$name])) return false;

		self::$placeholders[$name] = $placeholder;
		return true;
	}

	public static function getPlaceHolder(string $name, Player $player, ?Event $event): ?Value {
		if(isset(self::$placeholders[$name])){
			return self::$placeholders[$name]->getValue($player, $event);
		}

		return null;
	}

	public static function replacePlaceHolders(Environment $env, string $str): string {
		preg_match_all('<([a-zA-Z0-9]+)>', $str, $out);
		foreach($out[1] as $res){
			$val = TriggerPE::getPlaceHolder($res, $env->getPlayer(), null); // TODO: Pass event in the future

			if($val === null) continue;

			$str = str_replace("<$res>", $val->getString($env), $str);
		}

		return $str;
	}

	public function onEnable(){
		$this->initPlaceHolders();
	}

	private function initPlaceHolders(){
		$this->addPlaceHolder('username', new class implements PlaceHolder {
			public function getValue(Player $player, ?Event $event): Value {
				return new Value($player->getName(), Value::TYPE_STRING);
			}
		});

		$this->addPlaceHolder('itemid', new class implements PlaceHolder {
			public function getValue(Player $player, ?Event $event): Value {
				return new Value($player->getInventory()->getItemInHand()->getId(), Value::TYPE_INT);
			}
		});

		$this->addPlaceHolder('health', new class implements PlaceHolder {
			public function getValue(Player $player, ?Event $event): Value {
				return new Value($player->getHealth(), Value::TYPE_INT);
			}
		});
	}
}
