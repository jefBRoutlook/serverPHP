<?php
/**
 * 
 */
class Serve extends Base
{
	function __construct()
	{
		$this::load_config();
	}

	public function isRunning(): bool
	{
		$pid = (int) $this->cfg["PID"];
		try {
		
			if ( $pid !== 0 ){
			     $ret = exec("kill -0 $pid 2>/dev/null", $out, $status);
			     return $status === 0;
			}

		} catch (Exception $e) {
			
			echo "Err " . $e->getMessage() . PHP_EOL;
			return false;
		}
		return false;
	}

	public function on(): bool 
	{
	    $H = $this->cfg['HOSTNAME'];
	    $NP = (int) $this->cfg['NPORT'];
	    $D = $this->cfg['DOCROOT'];
	    $L = $this->cfg['LOG'];
		$P = $this->cfg['PID'];

		if ( !$this->status() ) {

			$cmd = sprintf(
			"nohup php -S %s:%d -t %s >> %s 2>&1 & echo $!",
			escapeshellarg($H),
			$NP,
			escapeshellarg($D),
			escapeshellarg($L)
			);

			$P = @shell_exec($cmd);

			if ($P === null || trim($P) === '') {
				echo "Falha ao iniciar o servidor.\n";
				return false;
			}

			$this->set_config("PID", $P);
			$this->save_config();

    		echo "URL => http://localhost:". (string) $NP . PHP_EOL;
    		echo "Servidor iniciado (PID {$P}). Log em server.log" . PHP_EOL;			
			return true;

		} else {

			echo "URL => http://localhost:". (string) $NP . PHP_EOL;
    		echo "Servidor ja está rodando (PID {$P})" . PHP_EOL;
    		return false;
		}
	}

	public function off(){

		$P = $this->cfg['PID'];
		$sig = 15; // SIGTERM
		$ok = @posix_kill($P, $sig);
		if (!$ok) {
			@exec("kill -9 $pid 2>/dev/null", $out, $status);
			if ($status !== 0) {
				return false;
			}
		}
		$this->set_config("PID",0);
		$this->save_config();
		return true;
	}

	public function status(){
		
		return $this->isRunning();
	}	

	public function set($atr, $vlr): bool
	{
		try {

			if ($atr === "" || $vlr ==="" ) {
				return false;
			}
			
			if ( !array_key_exists($atr, $this->cfg) ) {
				return false;
			}

	       $this->set_config($atr,$vlr);
	       $this->save_config();

		} catch (Exception $e) {
		
			    echo "Err " . $e->getMessage() . PHP_EOL;
		}	
		return true;
	}
}
