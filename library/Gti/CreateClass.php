<?php

/**
 * Classe que gera as classes para o mock webservice
 * @package Gti
 * @author Felipe Girotti <felipe.girotti@gmail.com>
 */

namespace Gti;

class CreateClass {
    
    protected $configClass;
    protected $pathUrl;
    protected $pathQueryString;	
    public $serverName;
    public $currentClass;

    public function __construct($configClass) 
    {
        $this->configClass = $configClass;
        $this->createUri();
    }
    
	/**
	 * Cria a classe webservice dinamicamente
	 * 
	 * @return void
	 * @throws \InvalidArgumentException
	 */
    public function generate()
    {       
        foreach ($this->configClass as $routes) {
			foreach ($routes as $class) {
				if ($this->checkUri($class['uri'])) {
					$this->currentClass = $class;
					eval ($this->createClass($class['class']));
					return;
				}
			}
        }
        throw new \InvalidArgumentException("Não foi encontrado a rota para {$this->pathUrl} no arquivo de configurações");
    }
    
    private function createUri()
    {
        $uri = parse_url($_SERVER['REQUEST_URI']);       
        $this->pathUrl = $uri['path'];
        $this->pathQueryString = isset($uri['query']) ? $uri['query'] : null;
        $port =  $_SERVER['SERVER_PORT'] == 80 ? null : ':' . $_SERVER['SERVER_PORT'];
        $this->serverName = $_SERVER['SERVER_NAME'] . $port;        
    }
    
    private function checkUri($uri)
    {
        return $this->pathUrl == $uri;
    }
    
    /**
     * Cria uma classe PHP em string
     * 
     * @param array $arrClass
     * @return string
     */
    private function createClass($arrClass) {
        $class = "class {$arrClass['name']} { ";
        foreach ($arrClass['methods'] as $name => $method) {
			$method['name'] = $name;
            $class .= $this->createMethod($method);
        }
        $class .= '};';
        return $class;
    }
    
    /**
     * Cria um método public
     * 
     * @param array $method
     * @return string
     */
    private function createMethod(array $method) {
        $createMethod = new CreateMethod($method);
		return $createMethod->generate();
    }

}
