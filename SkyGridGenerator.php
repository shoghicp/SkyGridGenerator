<?php

/*
__PocketMine Plugin__
name=SkyGridGenerator
description=Adds a new world generator
version=0.1
author=shoghicp
class=none
apiversion=7
*/

class SkyGridGenerator implements LevelGenerator{
	public static $normalp = array(
		STONE => 120,
		GRASS => 80,
		DIRT => 20,
		STILL_WATER => 9,
		STILL_LAVA => 5,
		SAND => 20,
		GRAVEL => 10,
		GOLD_ORE => 10,
		IRON_ORE => 20,
		COAL_ORE => 40,
		TRUNK => 100,
		LEAVES => 40,
		GLASS => 1,
		LAPIS_ORE => 5,
		SANDSTONE => 10,
		COBWEB => 10,
		TALL_GRASS => 3,
		DEAD_BUSH => 3,
		WOOL => 25,
		DANDELION => 2,
		CYAN_FLOWER => 2,
		BROWN_MUSHROOM => 2,
		RED_MUSHROOM => 2,
		TNT => 2,
		BOOKSHELF => 2,
		MOSSY_STONE => 5,
		OBSIDIAN => 5,
		CHEST => 1,
		DIAMOND_ORE => 1,
		REDSTONE_ORE => 8,
		ICE => 4,
		CACTUS => 1,
		CLAY_BLOCK => 20,
		SUGARCANE_BLOCK => 15,
		MELON_BLOCK => 5
	);
	
	private $level, $options, $random, $floatSeed, $total, $cump, $gridlenght;
	
	public function pickBlock($size){
		$r = $this->random->nextFloat() * $size;
		foreach($this->cump as $key => $value){
			if($r >= $value[0] and $r < $value[1]){
				return $key;
			}
		}
	}
	
	public function __construct(array $options = array()){
		$this->gridlenght = 4;
	}
	
	public function init(Level $level, Random $random){
		$this->level = $level;
		$this->random = $random;
		$this->floatSeed = $this->random->nextFloat();
		$this->total = 0;
		$this->cump = array();
		foreach(self::$normalp as $key => $value){
			$this->cump[$key] = array($this->total, $this->total + $value);
			$this->total += $value;
		}
	}
		
	public function generateChunk($chunkX, $chunkY, $chunkZ){
		$this->random->setSeed((int) (($chunkX * 0xdead + $chunkZ * 0xbeef + $chunkY * 0x1337) * $this->floatSeed));
		$chunk = "";
		$startY = $chunkY << 4;
		$endY = $startY + 16;
		for($z = 0; $z < 16; ++$z){
			for($x = 0; $x < 16; ++$x){
				$blocks = "";
				$metas = "";
				for($y = $startY; $y < $endY; ++$y){
					if(($y % $this->gridlenght) === 0 and ($z % $this->gridlenght) === 0 and ($x % $this->gridlenght) === 0){
						$blocks .= chr($this->pickBlock($this->total));
					}else{
						$blocks .= "\x00";
					}
					$metas .= "0";
				}
				$chunk .= $blocks.Utils::hexToStr($metas)."\x00\x00\x00\x00\x00\x00\x00\x00";
			}
		}
		$this->level->setMiniChunk($chunkX, $chunkZ, $chunkY, $chunk);
	}
	
	public function populateChunk($chunkX, $chunkY, $chunkZ){

	}
	
	public function populateLevel(){
		
	}
	
	public function getSpawn(){
		return new Vector3(128, 128, 128);
	}
}