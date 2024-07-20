<?php

namespace Luthfi\EasyGamemode;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\GameMode;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;
use LootSpace369\LSFormAPI\SimpleForm;

class Main extends PluginBase implements Listener {

    public function onEnable(): void {
        $this->getLogger()->info("EasyGamemode Plugin Enabled!");
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool {
        if (!$sender instanceof Player) {
            $sender->sendMessage("§cThis command can only be used in-game.");
            return false;
        }

        if ($command->getName() === "gm") {
            $this->openGamemodeForm($sender);
            return true;
        }

        return false;
    }

    public function openGamemodeForm(Player $player): void {
        $form = new SimpleForm(function (Player $player, $data) {
            if ($data === null) {
                return;
            }

            switch ($data) {
                case 0:
                    if ($player->hasPermission("eg.gmc")) {
                        $player->setGamemode(GameMode::CREATIVE());
                        $player->sendMessage("§bEasy§3Gamemode §7| §aGamemode set to Creative.");
                    } else {
                        $player->sendMessage("§cYou do not have permission to use this command.");
                    }
                    break;
                case 1:
                    if ($player->hasPermission("eg.gms")) {
                        $player->setGamemode(GameMode::SURVIVAL());
                        $player->sendMessage("§bEasy§3Gamemode §7| §aGamemode set to Survival.");
                    } else {
                        $player->sendMessage("§cYou do not have permission to use this command.");
                    }
                    break;
                case 2:
                    if ($player->hasPermission("eg.gma")) {
                        $player->setGamemode(GameMode::ADVENTURE());
                        $player->sendMessage("§bEasy§3Gamemode §7| §aGamemode set to Adventure.");
                    } else {
                        $player->sendMessage("§cYou do not have permission to use this command.");
                    }
                    break;
                case 3:
                    if ($player->hasPermission("eg.gmsp")) {
                        $player->setGamemode(GameMode::SPECTATOR());
                        $player->sendMessage("§bEasy§3Gamemode §7| §aGamemode set to Spectator.");
                    } else {
                        $player->sendMessage("§cYou do not have permission to use this command.");
                    }
                    break;
            }
        });

        $form->setTitle("§l§bSelect §3Gamemode");
        $form->setContent("§7Please select your desired gamemode:");
        $form->addButton("§bCreative");
        $form->addButton("§cSurvival");
        $form->addButton("§aAdventure");
        $form->addButton("§eSpectator");

        $player->sendForm($form);
    }
}
