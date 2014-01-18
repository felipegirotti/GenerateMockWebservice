<?php

/**
 * Classe gerado de métodos publicos para o webservice
 * @package Gti
 * @author Felipe Girotti <felipe.girotti@gmail.com>
 */

namespace Gti;

class CreateMethod 
{
	protected $annotation;
	protected $name;
	protected $bodyBlock;
	protected $parameters;
	protected $returns;
	protected $config;
	
	/**
	 * Método construtor, inicia as configurações iniciais,
	 * setando todos os atributos necessários
	 * 
	 * @param array $method configurações do método
	 */
	public function __construct(array $method) 
	{		
		$this->setAttrib($method, 'name')
			->setAttrib($method, 'annotation')
			->setAttrib($method, 'bodyBlock')
			->setAttrib($method, 'parameters')
			->setAttrib($method, 'returns');
	}
	
	/**
	 * Checa se existe o nome no array de configurações,
	 * atribue o valor de configurações ao atributo
	 * 
	 * @param array $config O array de configurações do método
	 * @param string $nameAttrib O nome do atributo da classe
	 * @return \Gti\CreateMethod Retorna o próprio objeto
	 */
	private function setAttrib(array $config, $nameAttrib)
	{
		if (array_key_exists($nameAttrib, $config))
			$this->$nameAttrib = $config[$nameAttrib];
		return $this;			
	}
	
	/**
	 * Gera o método público para o mock webservice
	 * 
	 * @return string O método gerado
	 */
	public function generate()
	{
		$parameters = implode(',', $this->parameters);
		$method = "\t" . $this->createAnnotation();
		$method .= "\tpublic function {$this->name}({$parameters}) \n\t{";
		$method .= "\n\t\t" . "{$this->bodyBlock}\n";
		$method .= "\t\t" . "return {$this->returns}\n";
		$method .= "\t}\n";
		return $method;
	}
	
	/**
	 * Gera a annotation, caso não exista gera com o nome da classe
	 * 
	 * @return string
	 */
	private function createAnnotation()
	{		
		if ($this->annotation)
			return $this->annotation;
		return "/**\n*{$this->name} mock webservice\n*\n*/";
	}
}

