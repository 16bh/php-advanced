<?php
	class Myclass1{
		
		private $v1;
		private $v2;
		
		public function __construct(){
			$this->v1 = 'x';
			$this->v2 = 'y';
		}
		
		public function __destruct(){
			echo 'destroying:'.$this->v1.' and '.$this->v2.'\r\n';
		}
	}
?>