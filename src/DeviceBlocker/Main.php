<?php

namespace DeviceBlocker;

use pocketmine\Player;
use pocketmine\Server;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\utils\Config;

class Main extends PluginBase implements Listener{
	
	public $settings;
	
	public function onEnable(){ 
		@mkdir($this->getDataFolder());
		if(!file_exists($this->getDataFolder() . "settings.yml")){
            $this->saveDefaultConfig();
        }
        $this->saveResource("settings.yml");
		$this->settings = new Config($this->getDataFolder() . "settings.yml", Config::YAML, array());	
		$this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
		
		$this->getLogger()->notice("*------------------------------*");
		$this->getLogger()->notice("Zablokowane urzadzenie: " . $this->settings->get("block-device"));
		$this->getLogger()->notice("Akcja jaka ma zostac wykonana: " . $this->settings->get("action"));
		if($this->settings->get("action") == "kick"){
			$this->getLogger()->notice("Wiadomosc kicka: " . $this->settings->get("kick-message"));
		}
		
		if($this->settings->get("action") == "transfer"){
			$this->getLogger()->notice("Ip transferu: " . $this->settings->get("transfer-ip"));
			$this->getLogger()->notice("Port transferu: " . $this->settings->get("transfer-port"));
		}
		
		if($this->settings->get("action") == "gm3"){
			$this->getLogger()->notice("Wiadomosc po wejsciu zablokowanego urzadzenia: " . $this->settings->get("gamemode-message"));
		}
		$this->getLogger()->notice("*------------------------------*");
	}
	
	
}