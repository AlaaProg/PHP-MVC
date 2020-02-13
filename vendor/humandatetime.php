<?php 


class HumanDateTime extends DateTime{
	protected $datetime_format = [
			'year'   => 'Y',
			'month'  => 'M',
			'day'    => 'd',
			'minute' => 'i',
			'hour'   => 'H',
			'second' => 's',
			'week'   => 'W'
	];


	function __call($name, $argv){

		if (!isset($argv[0])){
			return $this->format($this->datetime_format[$name]);
		}

		$this->modify("+{$argv[0]} {$name}");
		return $this;
	}

	function readable(String $format='l, jS Y h:m A'){
		return (new class($this, $format){
			private $parent ;
			private $format ; 

			public function __construct($parent, $format)
		    {$this->parent = $parent;$this->format = $format;}

		    function date($format='l, jS Y')
		    {return $this->parent->format($format);}

		    function time($format='h:m A')
		    {return $this->parent->format($format);}

			function __toString()
			{return $this->parent->format($this->format);}
		});
	}

	function differend($date=null, String $format='%R %y Year %m Month %d Day,  %h Hours %i Minute %s Seconds'){
		return (new class ($date, $format, $this) extends DateTime{
			private $parent;
			private $format;
			protected $_format = [
					'year'   => 'y',
					'month'  => 'm',
					'day'    => 'd',
					'minute' => 'i',
					'hour'   => 'h',
					'second' => 's',
					'days'   => 'a',
			];


			function __construct($date, $format, $parent)
			{ parent::__construct($date);$this->parent = $parent;$this->format = $format; }

			function __toString(){
				print_r($this->format("Y-m-d"));
				echo "\n";
				return $this->diff($this->parent)->format($this->format);;
			}

			function get_format(){
				return $this->format;
			}

			function __get($key){
				if (isset($this->_format[$key])){
					return $this->diff($this->parent)->format("%{$this->_format[$key]}");
				}
				return null;
			}

		});
	}

	function __toString(){

		return $this->format("Y-m-d H:m:s");
	}
}


