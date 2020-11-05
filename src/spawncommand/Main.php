<?php

namespace spawncommand;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\plugin\PluginBase;
use spawncommand\command\SpawnCommand;

class Main extends PluginBase implements Listener
{
	function onEnable()
	{
		$this->getLogger()->info("§bSpawnCommand§bPlugin §r§7»§r §2Enabled");
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->registerCommands();
		@mkdir($this->getDataFolder());
		$this->saveDefaultConfig();
	}

	function registerCommands()
	{
		$this->getServer()->getCommandMap()->register("spawn", new SpawnCommand($this));
	}

	function spawnOnJoin(PlayerJoinEvent $ev){
		$p = $ev->getPlayer();
		if($this->getConfig()->get("SpawnOnJoin") == "Enabled"){
			$p->teleport($this->getServer()->getDefaultLevel()->getSpawnLocation());
		}
	}

	function onDisable()
	{
		$this->getLogger()->info("§bSpawnCommand§bPlugin §r§7»§r §cDisabled");
		$this->reloadConfig();
	}
}