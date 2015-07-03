<?php

namespace Core;

class Config{

	private $config = array(
    	'mysql' => array(
			'host' => '127.0.0.1_default',
			'username' => 'root_default',
			'password' => '123_default',
			'db' => 'chrisdb_default'
    	),
		'session' => array(
			'session_name' => 'user_default',
			'token_name' => 'token_default'
		)
	);
	
	public function getVal($path = null){
        if($path){
            $config = $this->config;
            $path = explode('/', $path);
            foreach($path as $bit){
                if(isset($config[$bit])) {
                   $config = $config[$bit];
                }
            }
            return $config;
        }
        return false;
    }
	
	public function loadConfig($file = null){

		$format = $this->trimToDot($file);

		$method = 'parse'.ucfirst($format);

        if(method_exists($this, $method)){
			$this->$method($file);
		}else{
			return false;
		}		
	}
	
	private function trimToDot($str){
		$pos = strrpos($str, '.');
		if(!$pos){
			return false;
		}
		return substr($str, ($pos + 1), strlen($str));
	}
	
	private function parseYml($file){
		
		$file = URL . '/config/' . $file;

        if(!file_exists($file)){
            throw new \InvalidArgumentException('Failed to open yml file!!! ', 505);
            return false;
        }

        if(@!($parsed = yaml_parse_file($file))){
			throw new \InvalidArgumentException('Failed parse yml file');
			return false;
		}

		$this->config = $parsed;
	}
	
	private function parseJson($file){
		
		$file = $_SERVER['DOCUMENT_ROOT'] .'/../config/'.$file;
			
		if(!file_exists($file)){
			throw new \InvalidArgumentException('Failed to open json file!!! ', 505);
			return false;
		}
		
		$str = file_get_contents($file);
				
		if(!($parsed = json_decode($str, true))){
			throw new \InvalidArgumentException('Failed to parse json file!!! ');
			return false;
		}
		
		$this->config = $parsed;
	}
	
	private function parseTxt($file){
		$file = $_SERVER['DOCUMENT_ROOT'] .'/../config/'.$file;
		$handle = fopen($file, "r");
		$arr = array();
		if ($handle){
			while (($buffer = fgets($handle, 4096)) !== false) {
        		$d = explode('*',$buffer);				
				$e = explode('|',$d[1]);			
				if(!empty($e)){
					$keys = $values = array();
						for($i=0, $cnt = count($e); $i<$cnt; $i++){
							if($i % 2 == 0){
								$keys[] = $e[$i];
							}else{
								$values[] = $e[$i];
							}
						}
					$arr[$d[0]] = array_combine($keys, $values);
				}
			}
			if (!feof($handle)) {
				echo "Error: unexpected fgets() fail\n";
			}
			fclose($handle);
		}
		$this->config = $arr;		
	}
	
}