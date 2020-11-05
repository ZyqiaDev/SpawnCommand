<?php

namespace spawncommand\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use spawncommand\Main;

class SpawnCommand extends Command
{
	private $main;

	function __construct(Main $main)
	{
		parent::__construct("spawn", "Teleports you to the servers spawn #SpawnCommand", null);
		$this->main = $main;
	}

	function execute(CommandSender $s, string $commandLabel, array $args): bool
	{
		if ($s instanceof Player) {
			if (count($args) <= 0) {
				$s->teleport($this->main->getServer()->getDefaultLevel()->getSpawnLocation());
				if ($this->main->getConfig()->get("EnableSpawnMessage") == "Enabled") {
					$s->sendMessage($this->main->getConfig()->get("SpawnMessage"));
				}
			}
			if (count($args) >= 1) {
				$p = $this->main->getServer()->getPlayer($args[0]);
				if ($s->hasPermission("spawnothers.command")) {
					if ($p !== null) {
						$p->teleport($this->main->getServer()->getDefaultLevel()->getSpawnLocation());
						$p->sendMessage(str_replace(["{player}"], [$p->getDisplayName()], $this->main->getConfig()->get("SpawnOtherMessageSender")));
						$s->sendMessage(str_replace(["{sender}"], [$s->getDisplayName()], $this->main->getConfig()->get("SpawnOtherMessagePlayer")));
					}else{
						$s->sendMessage(str_replace(["{player}"], [$args[0]],$this->main->getConfig()->get("PlayerNotFound")));
					}
				} else {
					$s->teleport($this->main->getServer()->getDefaultLevel()->getSpawnLocation());
					if ($this->main->getConfig()->get("EnableSpawnMessage") == "Enabled") {
						$s->sendMessage($this->main->getConfig()->get("SpawnMessage"));
					}
				}
			}
		}
		return true;
	}
}