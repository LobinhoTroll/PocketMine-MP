<?php

/*

           -
         /   \
      /         \
   /   PocketMine  \
/          MP         \
|\     @shoghicp     /|
|.   \           /   .|
| ..     \   /     .. |
|    ..    |    ..    |
|       .. | ..       |
\          |          /
   \       |       /
      \    |    /
         \ | /

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU Lesser General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.


*/

class TileEntityAPI{
	private $server;
	function __construct(PocketMinecraftServer $server){
		$this->server = $server;
	}

	public function get($eid){
		if(isset($this->server->tileEntities[$eid])){
			return $this->server->tileEntities[$eid];
		}
		return false;
	}
	
	public function init(){
	
	}

	public function getAll(){
		return $this->server->tileEntities;
	}

	public function add($class, $x, $y, $z, $data = array()){
		$id = $this->tCnt++;
		$this->server->tileEntities[$id] = new TileEntity($this->server, $id, $class, $x, $y, $z, $data);
		return $this->server->tileEntities[$id];
	}

	public function spawnTo($id, $player){
		$t = $this->get($id);
		if($t === false){
			return false;
		}
		$t->spawn($player);
	}

	public function spawnToAll($id){
		$t = $this->get($id);
		if($t === false){
			return false;
		}
		foreach($this->server->api->player->getAll() as $player){
			if($player->eid !== false){
				$t->spawn($player);
			}
		}
	}

	public function spawnAll($player){
		foreach($this->getAll() as $t){
			$t->spawn($player);
		}
	}

	public function remove($id){
		if(isset($this->server->tileEntities[$id])){
			$t = $this->server->tileEntities[$eid];
			$this->server->tileEntities[$id] = null;
			unset($this->server->tileEntities[$id]);
			$t->closed = true;
			$t->close();
			$this->server->query("DELETE FROM tileentities WHERE ID = ".$id.";");
			$t = null;
			unset($t);			
		}
	}
}