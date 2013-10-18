<?php 
	class Session {
		public function __construct()
		{
			session_start() ; 
		}

		public function __destruct()
		{
			unset($this) ;
		}

		public function registr($time = 60) {
			$_SESSION['session_id'] = session_id() ; 
			$_SESSION['session_start'] = session_start() ; 
			$_SESSION['session_time'] = intval($time) ;  
		}

		public function isRegistered()
		{
			if(!empty($_SESSION['session_id']))
			{
				return true ;
			}
			else{
				return false ; 
			}
		}

		public function set($key, $value)
		{
			$_SESSION['key'] = $value ; 
		}

		public function get($key)
		{
			return $_SESSION['key'] ; 
		}

		public function getSession()
		{
			return $_SESSION ;
		}

		public function getSessionId()
		{
			return $_SESSION['session_id'] ; 
		}

		public function isExiperd()
		{
			if($_SESSION['session_start'] < $this->timeNow())
			{
				return true ;
			}
			else {
				return false ; 
			}
		}

		public function renew() {
			$_SESSION['session_start'] = $this->timeNow() ; 
		}

		private function timeNow()
		{
			$currentHour = date('H') ;
			$currentMin = date('i') ; 
			$currentSec = date('s') ; 
			$currentMon = date('m') ;
			$currentDay = date('d') ;
			$currentYear = date('y') ; 
			return mktime($currentHour, $currentMin, $currentSec, $currentMon, $currentDay, $currentYear) ;   
		}

		private function newTime()
		{
			$currentHour = date('H') ;
			$currentMin = date('i') ; 
			$currentSec = date('s') ; 
			$currentMon = date('m') ;
			$currentDay = date('d') ;
			$currentYear = date('y') ;
				return mktime($currentHour, ($currentMin + $_SESSION['session_time']), $currentSec, $currentMon, $currentDay, $currentYear) ; 
		}

		public function end()
		{
			session_destroy() ;
			$_SESSION = array() ; 
		}
	}
	

 ?>