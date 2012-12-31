<?php

	namespace Lib;

	class Session
	{
		static private $instance;

		private function __clone() {}
		private function __construct() {}


		static public function getInstance() 
		{
			if( !self::$instance instanceof self ) {
				self::$instance = new self;
			}

			self::$instance->start();

			return self::$instance;
		}


		public function start()
		{
			if( !session_id() ) {
				session_start();
			}

			return $this;
		}


		public function __isset($name)
		{
			return isset($_SESSION[$name]);
		}

		public function __unset($name)
		{
			unset($_SESSION[$name]);
		}


		public function __get($name)
		{
			return $_SESSION[$name];
		}


		public function __set($name, $value)
		{
			$_SESSION[$name] = $value;
			return $this;
		}


		public function destroy()
		{
			if( session_id() ) {
				session_destroy();
				unset($_SESSION);
			}

			return $this;
		}
	}