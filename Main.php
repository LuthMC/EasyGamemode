<?php

namespace Luthfi\EasyGamemode;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\GameMode;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

class Main extends PluginBase implements Listener {

    public function onEnable(): void {
        $this->getLogger()->info("EasyGamemode Plugins Enabled!");
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool {
        if (!$sender instanceof Player) {
            $sender->sendMessage(TextFormat::RED . "This command can only be used in-game.");
            return false;
        }

        switch ($command->getName()) {
            case "gmc":
                if ($sender->hasPermission("eg.gmc")) {
                    $sender->setGamemode(GameMode::CREATIVE());
                    $sender->sendMessage(TextFormat::GREEN . "Gamemode set to Creative.");
                } else {
                    $sender->sendMessage(TextFormat::RED . "You do not have permission to use this command.");
                }
                return true;

            case "gms":
                if ($sender->hasPermission("eg.gms")) {
                    $sender->setGamemode(GameMode::SURVIVAL());
                    $sender->sendMessage(TextFormat::GREEN . "Gamemode set to Survival.");
                } else {
                    $sender->sendMessage(TextFormat::RED . "You do not have permission to use this command.");
                }
                return true;

            case "gma":
                if ($sender->hasPermission("eg.gma")) {
                    $sender->setGamemode(GameMode::ADVENTURE());
                    $sender->sendMessage(TextFormat::GREEN . "Gamemode set to Adventure.");
                } else {
                    $sender->sendMessage(TextFormat::RED . "You do not have permission to use this command.");
                }
                return true;

            case "gmsp":
                if ($sender->hasPermission("eg.gmsp")) {
                    $sender->setGamemode(GameMode::SPECTATOR());
                    $sender->sendMessage(TextFormat::GREEN . "Gamemode set to Spectator.");
                } else {
                    $sender->sendMessage(TextFormat::RED . "You do not have permission to use this command.");
                }
                return true;

            default:
                return false;
        }
    }
}
