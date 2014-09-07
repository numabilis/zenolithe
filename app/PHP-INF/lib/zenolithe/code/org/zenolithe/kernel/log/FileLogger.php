<?php
/**
 * 16-mai-06 - david : Creation
 *
 * This file dhould provide the basic logging functions :
 * error, warn, info, debug.
 *
 * Available options which sould be set in the zenolithe.conf.php file using the
 * log_options array :
 *   - level : the log level set the output verbosity :
 *         0 : none.
 *         1 : errors only.
 *         2 : errors and warnings.
 *         3 : errors, warnings and informations.
 *         4 : errors, warnings, informations and debug messages.
 *   - file_path : the path to the log file (should have write access).
 *
 * It's a good idea to set the default error and exception handler here.
 *
 * Tip for automatic debug log
 * register_tick_function('debug');
 * declare(ticks=5) {
 *   // Here a code to be monitored
 * }
 * unregister_tick_function('debug');
 *
 *
 * start_debug_monitor('var1','var2');
 * declare(ticks=5) {
 *   // big confusing block of code that
 *   // modifies $var1 and $var2 many times }
 * stop_debug_monitor();
 */

namespace org\zenolithe\kernel\log;

class FileLogger implements ILogger {
	private $level;
	private $filePath;
	private $fileTrim;
	private $dateFormat;
	private $timezone;
	private $logFile;
	
	public function setLevel($level) {
		$this->level = $level;
	}
	
	public function setFilePath($filePath) {
		if(!file_exists($filePath)) {
			$logDir = substr($filePath, 0, strrpos($filePath, '/'));
			if(!file_exists($logDir)) {
				mkdir($logDir, 0777, true);
			}
			touch($filePath);
		}
		$this->filePath = realpath($filePath);
	}
	
	public function setFileTrim($fileTrim) {
		$this->fileTrim = $fileTrim;
	}
	
	public function setDateFormat($dateFormat) {
		$this->dateFormat = $dateFormat;
	}
	
	public function setTimezone($timezone) {
		$this->timezone = $timezone;
		date_default_timezone_set($this->timezone);
	}
	
	public function trimFileName($filename) {
		return str_replace($this->fileTrim,'',$filename);
	}
	
	public function caller() {
		if($this->level > 3) {
			$trace = debug_backtrace();
			if ($trace[1]['file']) {
				$trace = $trace[1];
			} else {
				$trace = $trace[2];
			}
			$this->log($this->trimFileName($trace['file']).' ('.$trace['line'].')', "DEBUG");
		}
	}
	
	public function stack() {
		if($this->level > 3) {
			$traces = debug_backtrace();
			foreach($traces as $trace)
			if ($trace['file']) {
				$this->log($this->trimFileName($trace['file']).' ('.$trace['line'].')', "DEBUG");
			}
		}
	}
	
	public function start_debug_monitor(/*...*/) {
		global $debug_monitor_vars;
		$debug_monitor_vars = array();
		foreach (func_get_args() AS $key) {
			$debug_monitor_vars[$key] = null;
		}
		register_tick_function('user_error', "DEBUG_MONITOR" ,E_USER_ERROR);
	}
	
	public function stop_debug_monitor() {
		unregister_tick_function('user_error');
	}
	
	public function log($message, $level, $stack=NULL) {
		$indent = "  ";
			
		// If the file is not opened, open it and dump header.
		if ($this->logFile === null) {
			$this->logFile = fopen($this->filePath, 'a+');
		}
			
		$timestamp = date($this->dateFormat);
		fwrite($this->logFile, "$timestamp - [$level] $message\n");
			
		if ($stack != NULL) {
			$outStack = "";
			foreach($stack as $call) {
				$outStack .= $indent;
				if(isset($call['class'])) {
					$outStack .= $call['class'];
				}
				if(isset($call['type'])) {
					$outStack .= $call['type'];
				}
				$outStack .= $call['function'].'(';
				$arg = reset($call['args']);
				if ($arg) {
					$outStack .= $this->arrayToString($arg);
				}
				$arg = next($call['args']);
				while ($arg) {
					$outStack .= ', ' . $arg;
					$arg = next($call['args']);
				}
				$outStack .= ') : ';
				$outStack .= $this->trimFileName($call['file']);
				$outStack .= ' (' . $call['line'] . ')'."\n";
			}
			fwrite($this->logFile, $outStack);
		}
	}
	
	public function arrayToString($arry) {
		if(is_resource($arry)) {
			$arry = "".$arry." [".get_resource_type($arry)."]";
		} else if (!is_scalar($arry)) {
			ob_start();
			var_export($arry);
			$arry = ob_get_contents();
			ob_end_clean();
		}
			
		return (string) $arry;
	}
	
	/*
	 * Required function to log an error.
	*/
	public function error($message, $stack=null) {
		if(error_reporting() && ($this->level > 0)) {
			if($stack == NULL) {
				$this->log($message, "ERROR");
			} else {
				$this->log($message, "ERROR");
			}
		}
	}
	
	/*
	 * Required function to log a warning.
	*/
	public function warn($message) {
		if(error_reporting() && ($this->level > 1)) {
			$this->log($message, "WARNING");
		}
	}
	
	/*
	 * Required function to log an information.
	*/
	public function info($message) {
		if($this->level > 2) {
			$this->log($message, "INFO");
		}
	}
	
	/*
	 * Required function to log a debug message.
	*/
	public function debug($message=null) {
		if($this->level > 3) {
			if($message == NULL) {
				$trace = debug_backtrace();
				if ($trace[0]['file']) {
					$trace = $trace[0];
				} else {
					$trace = $trace[1];
				}
				$this->log($this->trimFileName($trace['file']).' ('.$trace['line'].')', "DEBUG");
			} else {
				$this->log($this->arrayToString($message), "DEBUG");
			}
		}
	}
	
	public function errorHandler($errno, $errstr, $errfile=null, $errline=0, array $errcontext=null) {
		$errfile = $this->trimFileName($errfile);
		switch ($errno) {
			case E_ERROR:
			case E_CORE_ERROR:
			case E_COMPILE_ERROR:
			case E_USER_ERROR:
				if (strcmp($errstr, "DEBUG_MONITOR") == 0) {
					global $debug_monitor_vars;
					// prevent tick functions from executing here
					declare(ticks=0) {
						$message = "MONITOR $errfile ($errline)\n   === app ===\n";
						// compare all of the defined vars to find those that have changed
						foreach((array)$debug_monitor_vars AS $key => $value) {
							if ($errapp[$key] !== $value) {
								$message .= "   $key = ".$this->arrayToString($errapp[$key]."\n");
								$debug_monitor_vars[$key] = $errapp[$key];
							}
						}
						$message .= "   ===== END =====";
						$this->debug($message);
					}
				} else {
					$this->error($errstr.' ('.$errno.') in '.$errfile.' ('.$errline.')');
				}
				break;
			case E_WARNING:
			case E_CORE_WARNING:
			case E_COMPILE_WARNING:
			case E_USER_WARNING:
				$this->warn($errstr.' ('.$errno.') in '.$errfile.' ('.$errline.')');
				break;
			case E_NOTICE:
			case E_USER_NOTICE:
			case E_STRICT:
				$this->info($errstr.' ('.$errno.') in '.$errfile.' ('.$errline.')');
				break;
			default:
				$this->info($errstr.' ('.$errno.') in '.$errfile.' ('.$errline.')');
				break;
		}
	}
 	
	public function exceptionHandler ( Exception $exception) {
		$message = $exception->getMessage().' ('.$exception->getCode().') in ';
		$message .= $this->trimFileName($exception->getFile());
		$message .= ' ('.$exception->getLine().')';
		$this->error($message, $exception->getTrace());
	}
}
?>
