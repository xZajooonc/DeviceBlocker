<?php

namespace DeviceBlocker;

use pocketmine\Player;
use pocketmine\Server;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\utils\Config;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\network\mcpe\protocol\LoginPacket;

class EventListener implements Listener{
	
	public $plugin;
	
	public function __construct(Main $plugin) {
		$this->plugin = $plugin;
	}
	
	public function onDataPacket(DataPacketReceiveEvent $event){
		$packet = $event->getPacket();
		if($packet instanceof LoginPacket){
			switch(strtolower($this->plugin->settings->get("block-device"))){
				case "android":
				$os = 1;
				break;
				
				case "ios":
				$os = 2;
				break;
				
				case "win":
				$os = 7;
				break;
			}
			
			if($packet->clientData["DeviceOS"] == $os){
				switch(strtolower($this->plugin->settings->get("action"))){
					case "kick":
					$this->plugin->getScheduler()->scheduleDelayedTask(new DelayedAction($this->plugin, $event->getPlayer(), 1), 200);
					break;
					
					case "transfer":
					$this->plugin->getScheduler()->scheduleDelayedTask(new DelayedAction($this->plugin, $event->getPlayer(), 2), 200);
					break;
					
					case "gm3":
					$this->plugin->getScheduler()->scheduleDelayedTask(new DelayedAction($this->plugin, $event->getPlayer(), 3), 200);
					break;
				}
			}
		}
	}
	
}