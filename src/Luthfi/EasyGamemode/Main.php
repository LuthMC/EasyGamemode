<?php

namespace Luthfi\EasyGamemode;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\GameMode;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;
use Luthfi\EasyGamemode\libs\LootSpace369\LSFormAPI\SimpleForm;

class Main extends PluginBase implements Listener {

    public function onEnable(): void {
        $this->getLogger()->info("EasyGamemode Enabled");
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool {
        if (!$sender instanceof Player) {
            $sender->sendMessage("§cThis command can only be used in-game.");
            return false;
        }

        switch ($command->getName()) {
            case "gmc":
                $this->setPlayerGamemode($sender, GameMode::CREATIVE(), "Creative", "eg.gmc");
                return true;
            case "gms":
                $this->setPlayerGamemode($sender, GameMode::SURVIVAL(), "Survival", "eg.gms");
                return true;
            case "gma":
                $this->setPlayerGamemode($sender, GameMode::ADVENTURE(), "Adventure", "eg.gma");
                return true;
            case "gmsp":
                $this->setPlayerGamemode($sender, GameMode::SPECTATOR(), "Spectator", "eg.gmsp");
                return true;
            case "easygamemode":
                $this->handleEasyGamemodeCommand($sender, $args);
                return true;
            default:
                return false;
        }
    }

    private function setPlayerGamemode(Player $player, GameMode $gamemode, string $modeName, string $permission): void {
        if ($player->hasPermission($permission)) {
            $player->setGamemode($gamemode);
            $player->sendMessage("§l§bEasy§3Gamemode§r §7| §aChange gamemode to $modeName");
        } else {
            $player->sendMessage("§cYou do not have permission to use this command.");
        }
    }

    private function handleEasyGamemodeCommand(CommandSender $sender, array $args): void {
        if (count($args) === 0) {
            $sender->sendMessage("Usage: §3/eg §bhelp §7| §3/eg §bui");
        } elseif ($args[0] === "help") {
            $sender->sendMessage("§7===== §l§bEasy§3Gamemode §r§7=====§r\n- /gmc » Change gamemode to Creative.\n- /gms » Change gamemode to Survival\n- /gma » Change gamemode to Adventure\n- /gmsp » Change gamemode to Spectator\n§7===== §l§bEasy§3Gamemode §r§7=====§r");
        } elseif ($args[0] === "ui") {
            if ($sender instanceof Player) {
                $this->openGamemodeForm($sender);
            } else {
                $sender->sendMessage("§cThis command can only be used in-game.");
            }
        } else {
            $sender->sendMessage("Usage: §3/eg §bhelp §7| §3/eg §bui");
        }
    }

    public function openGamemodeForm(Player $player): void {
        $form = new SimpleForm("§l§bSelect §3Gamemode", "§7Please select your desired gamemode:", function (Player $player, $data) {
            if ($data === null) {
                return;
            }

            switch ($data) {
                case 0:
                    $this->setPlayerGamemode($player, GameMode::CREATIVE(), "Creative", "eg.gmc");
                    break;
                case 1:
                    $this->setPlayerGamemode($player, GameMode::SURVIVAL(), "Survival", "eg.gms");
                    break;
                case 2:
                    $this->setPlayerGamemode($player, GameMode::ADVENTURE(), "Adventure", "eg.gma");
                    break;
                case 3:
                    $this->setPlayerGamemode($player, GameMode::SPECTATOR(), "Spectator", "eg.gmsp");
                    break;
            }
        });
        
        $form->addButton("§bCreative","https://iili.io/dhFAs4I.png");
        $form->addButton("§cSurvival","https://iili.io/dhFaLe1.png");
        $form->addButton("§aAdventure","https://iili.io/dhFaO57.png");
        $form->addButton("§eSpectator","https://iili.io/dhFc5hu.png");

        $player->sendForm($form);
    }
}
