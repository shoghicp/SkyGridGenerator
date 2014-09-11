<?php

namespace shoghicp\SkyGridGenerator;

use pocketmine\plugin\PluginBase;
use pocketmine\level\generator\Generator;

class Plugin extends PluginBase{
	
	public function onEnable(){
		//$this->getServer()->getGenerationManager()->addNamespace(__NAMESPACE__, realpath(dirname(__FILE__) . "/../.."));
		Generator::addGenerator(SkyGridGenerator::class, "skygrid");
	}
}
