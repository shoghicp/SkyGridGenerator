<?php

namespace shoghicp\SkyGridGenerator;

use pocketmine\level\generator\Generator;
use pocketmine\level\ChunkManager;
use pocketmine\math\Vector3;
use pocketmine\utils\Random;
use pocketmine\block\Block;

class SkyGridGenerator extends Generator{
	private $normalp, $level, $options, $random, $floatSeed, $total, $cump, $gridlength;
	
	public function pickBlock($size){
		$r = $this->random->nextFloat() * $size;
		foreach($this->cump as $key => $value){
			if($r >= $value[0] and $r < $value[1]){
				return $key;
			}
		}
	}
	
	public function getSettings(){
		return $this->options;
	}

	public function getName(){
		return "skygrid";
	}
	
	public function __construct(array $options = []){
		$this->gridlength = 4;
		$this->options = $options;
		$this->normalp = [
			Block::STONE => 120,
			Block::GRASS => 80,
			Block::DIRT => 20,
			Block::STILL_WATER => 10,
			Block::STILL_LAVA => 5,
			Block::SAND => 20,
			Block::GRAVEL => 10,
			Block::GOLD_ORE => 10,
			Block::IRON_ORE => 20,
			Block::COAL_ORE => 40,
			Block::TRUNK => 100,
			Block::LEAVES => 40,
			Block::GLASS => 1,
			Block::LAPIS_ORE => 5,
			Block::SANDSTONE => 10,
			Block::COBWEB => 10,
			Block::TALL_GRASS => 3,
			Block::DEAD_BUSH => 3,
			Block::WOOL => 25,
			Block::DANDELION => 2,
			Block::ROSE => 2,
			Block::BROWN_MUSHROOM => 2,
			Block::RED_MUSHROOM => 2,
			Block::TNT => 2,
			Block::BOOKSHELF => 3,
			Block::MOSSY_STONE => 5,
			Block::OBSIDIAN => 5,
			Block::CHEST => 1,
			Block::MONSTER_SPAWNER => 1,
			Block::DIAMOND_ORE => 1,
			Block::REDSTONE_ORE => 8,
			Block::ICE => 4,
			Block::SNOW_BLOCK => 8,
			Block::CACTUS => 1,
			Block::CLAY_BLOCK => 20,
			Block::SUGARCANE_BLOCK => 15,
			Block::PUMPKIN => 5,
			Block::MELON_BLOCK => 5,
			Block::MYCELIUM => 15
		];
	}
	
	public function init(ChunkManager $level, Random $random){
		$this->level = $level;
		$this->random = $random;
		$this->floatSeed = $this->random->nextFloat();
		$this->total = 0;
		$this->cump = [];
		
		foreach($this->normalp as $key => $value){
			$this->cump[$key] = [$this->total, $this->total + $value];
			$this->total += $value;
		}
	}
		
	public function generateChunk($chunkX, $chunkZ){
		$this->random->setSeed((int) (($chunkX * 0xdead + $chunkZ * 0xbeef) * $this->floatSeed));
		
		$chunk = $this->level->getChunk($chunkX, $chunkZ);
		
		for($y = 0; $y < 128; $y += $this->gridlength){
			for($z = 0; $z < 16; $z += $this->gridlength){
				for($x = 0; $x < 16; $x += $this->gridlength){
					$blockId = $this->pickBlock($this->total);
										
					if($blockId === Block::WOOL){
						$chunk->setBlockId($x, $y, $z, $blockId);
						$chunk->setBlockData($x, $y, $z, $this->random->nextInt() & 0xf);
					}elseif($blockId === 6 or $blockId === 31 or $blockId === 32 or $blockId === 37 or $blockId === 38 or $blockId === 39 or $blockId === 40 or $blockId === 83){
						$chunk->setBlockId($x, $y, $z, 3);
						$chunk->setBlockId($x, $y + 1, $z, $blockId);
						if($blockId === 83){
							$chunk->setBlockId($x + 1, $y, $z, 9);
						}
					}elseif($blockId === 83){
						$chunk->setBlockId($x, $y, $z, 12);
						$chunk->setBlockId($x, $y + 1, $z, $blockId);
					}else{
						$chunk->setBlockId($x, $y, $z, $blockId);
					}
				}
			}
		}
	}
	
	public function populateChunk($chunkX, $chunkZ){

	}
	
	public function getSpawn(){
		return new Vector3(128.5, 64, 128.5);
	}
}
