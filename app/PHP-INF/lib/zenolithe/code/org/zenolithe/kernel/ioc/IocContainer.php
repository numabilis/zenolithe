<?php
namespace org\zenolithe\kernel\ioc;

class IocContainer {
	static private $instance;
	private $registry = array();
	private $requestRegistry = array();
	
	static public function getInstance($registry = array()) {
		if(!self::$instance) {
			self::$instance = new IocContainer($registry);
		}
		
		return self::$instance;
	}
	
	private function __construct($registry = array()) {
		$this->registry = $registry;
		$this->registry['ioc.container'] = $this;
		$this->registry['iocInitiator'] = $this->get('iocInitiator');
	}
	
	public function get($name) {
		$object = null;
		
		if(isset($this->requestRegistry[$name])) {
			$object = $this->requestRegistry[$name];
		} else if(isset($this->registry[$name])) {
			$object = $this->registry[$name];
		} else {
			$definition = @include('ioc/'.$name.'.conf.php');
			if($definition) {
				$object = new $definition['class'];
				$this->inject($object, $definition);
				$this->registry[$name] = $object;
			}
		}
		
		return $object;
	}
	
	public function set($name, $object, $definition = null) {
		if($definition) {
			$this->inject($object, $definition);
		}
		$this->requestRegistry[$name] = $object;
	}
	
	public function remove($name) {
		unset($this->requestRegistry[$name]);
	}
	
	public function inject($object, $definition) {
		if(isset($definition['injected']) && $definition['injected']) {
			foreach($definition['injected'] as $attribute => $injectable) {
				$setter = 'set'.ucfirst($attribute);
				if(is_array($injectable)) {
					$arry = array();
					foreach($injectable as $inj) {
						$arry[] = $this->get($inj);
					}
					$object->$setter($arry);
				} else {
					$object->$setter($this->get($injectable));
				}
			}
		}
		if(isset($definition['parameters']) && $definition['parameters']) {
			foreach($definition['parameters'] as $attribute => $value) {
				if(is_array($value)) {
					$finalValue = $value;
				} else {
					$valueParts = preg_split('/({[^{}]*})/', $value, 0, PREG_SPLIT_DELIM_CAPTURE);
					$finalValue = '';
					$i = 0;
					foreach($valueParts as $valuePart) {
						if($i % 2) {
							$finalValue .= $this->get(substr($valuePart, 1, strlen($valuePart) -2));
						} else {
							$finalValue .= $valuePart;
						}
						$i++;
					}
				}
				$setter = 'set'.ucfirst($attribute);
				$object->$setter($finalValue);
			}
		}
	}
}
?>