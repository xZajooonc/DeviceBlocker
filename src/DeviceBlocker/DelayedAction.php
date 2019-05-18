<?php

namespace DeviceBlocker;

use pocketmine\scheduler\Task;
use pocketmine\Server;
use pocketmine\Player;

class DelayedAction extends Task{
	
	private $player;
	
	public function  __construct($plugin, $player, $action){
		$this->plugin = $plugin;
		$this->player = $player;
		$this->action = $action;
    }
	
	public function onRun($currentTick){
		if(!$this->player->isOnline()){
			return true;
		}
		
		switch($this->action){
			case 1:
			$this->player->kick($this->plugin->settings->get("kick-message"), false);
			break;
			
			case 2:
			$ip = $this->plugin->settings->get("transfer-ip");
			$port = $this->plugin->settings->get("transfer-port");
			$this->player->transfer($ip, $port);
			break;
			
			case 3:
			$this->player->setGamemode(3);
			$this->player->sendMessage($this->plugin->settings->get("gamemode-message"));
			break;
		}
	}
}