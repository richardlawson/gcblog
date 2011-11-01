<?php
namespace GC\Entity;

class EntityBase{
	
	public function __construct(array $options = null){
		if (is_array($options)) {
            $this->setOptions($options);
        }
    }
    
	public function populate(array $options = null){
		if (is_array($options)) {
            $this->setOptions($options);
        }
    }
	
	public function setOptions(array $options){
		$methods = get_class_methods($this);
		foreach($options as $key => $value){
			$method = 'set' . ucfirst($key);
			if(in_array($method, $methods)){
				$this->$method($value);
			}
		}
		return $this;
	}
	
	public function __set($name, $value){
		$method = 'set' . $name;
		if(!method_exists($this, $method)){
			throw new \Exception('Invalid ' . __CLASS__ . ' property');
		}
		$this->$method($value);
    }
 
    public function __get($name){
		$method = 'get' . $name;
		if(!method_exists($this, $method)){
			throw new \Exception('Invalid ' . __CLASS__ . ' property');
		}
		return $this->$method();
    }
}