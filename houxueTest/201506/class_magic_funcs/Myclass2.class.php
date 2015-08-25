<?php
	class Myclass2{
		
		private $v3;
		private $v4;
		
		public function __construct(){
			$this->v3 = 'a';
			$this->v4 = 'b';
		}
		
		public function __destruct(){
			echo 'destroying:'.$this->v3.' and '.$this->v4.'\r\n';
		}
	}
?>