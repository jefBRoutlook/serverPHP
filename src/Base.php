<?php

/**
 * Classe base
 */

abstract class Base
{
	public array $cfg = array(
		'PID' => 0,
		'LOG' => 'server.log', 
		'HOSTNAME' => 'localhost',
		'NPORT' => 8090,
		'DOCROOT' => '.'
	);

	public function set_config($attributo , $value)  
	{
		$this->cfg[$attributo]=$value;
	}
	public function load_config()
	{
		if (file_exists(CONFIG_FILE)) {
			
			$content = file_get_contents(CONFIG_FILE);
			$this->cfg = json_decode($content, true);
		} else {
			
		}
	}

	public function save_config()
	{
		try {
		 
		    $data = json_encode($this->cfg);
		    file_put_contents(CONFIG_FILE, $data);
		} catch (Exception $e) {
		 
		    echo "Err " . $e->getMessage() . PHP_EOL;
		}
	}

}