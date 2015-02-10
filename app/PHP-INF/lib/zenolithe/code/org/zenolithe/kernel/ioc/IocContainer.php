<?php
namespace org\zenolithe\kernel\ioc;

class IocContainer {
	private static $instance;
	private $applicationRegistry = array ();
	private $requestRegistry = array ();

	static public function getInstance($registry = array()) {
		if(!self::$instance) {
			self::$instance = new IocContainer($registry);
			foreach($registry['ioc.init'] as $toInitialize) {
				self::$instance->get($toInitialize);
			}
		}
		
		return self::$instance;
	}

	private function __construct($registry = array()) {
		$this->applicationRegistry = $registry;
		$this->applicationRegistry['ioc.container'] = $this;
	}

	public function get($name) {
		$object = null;
		
		if(isset($this->requestRegistry[$name])) {
			$object = $this->requestRegistry[$name];
		} else if(isset($this->applicationRegistry[$name])) {
			$object = $this->applicationRegistry[$name];
		} else {
			$definition = @include ('conf/ioc/' . $name . '.conf.php');
			if($definition) {
				$object = new $definition['class']();
				$this->inject($object, $definition);
				if(isset($definition['name'])) {
					$name = $definition['name'];
				}
				if(isset($definition['scope'])) {
					$scope = $definition['scope'];
				} else {
					$scope = 'request';
				}
				switch($scope) {
					case 'request':
						$this->requestRegistry[$name] = $object;
						break;
					case 'application':
						$this->applicationRegistry[$name] = $object;
						break;
				}
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
	
	public function register(array $definition) {
		$name = null;
		$scope = null;
		$object = null;
		
		if(isset($definition['alias'])) {
			$object = $this->get($definition['alias']);
		} else {
			$name = $definition['name'];
			if(isset($definition['scope'])) {
				$scope = $definition['scope'];
			} else {
				$scope = 'request';
			}
			switch($scope) {
				case 'request':
					if(isset($this->requestRegistry[$name])) {
						$object = $this->requestRegistry[$name];
					} else {
						$object = new $definition['class']();
						$this->inject($object, $definition);
						$this->requestRegistry[$name] = $object;
					}
					break;
				case 'application':
					if(isset($this->applicationRegistry[$name])) {
						$object = $this->applicationRegistry[$name];
					} else {
						$object = new $definition['class']();
						$this->inject($object, $definition);
						$this->applicationRegistry[$name] = $object;
					}
					break;
			}
		}
		
		return $object;
	}
	
	public function inject($object, $definition) {
		if(isset($definition['injected']) && $definition['injected']) {
			foreach($definition['injected'] as $attribute => $injectable) {
				$setter = 'set' . ucfirst($attribute);
				if(is_array($injectable)) {
					$arry = array ();
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
							$finalValue .= $this->get(substr($valuePart, 1, strlen($valuePart) - 2));
						} else {
							$finalValue .= $valuePart;
						}
						$i++;
					}
				}
				$setter = 'set' . ucfirst($attribute);
				$object->$setter($finalValue);
			}
		}
	}
}
?>