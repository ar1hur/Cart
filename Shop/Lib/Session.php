<?php

	namespace Shop\Lib;

	class Session
	{
		static private $instance;
		private function __clone() {}
		
		/**
		 * Starts the session automatically
		 */
		protected function __construct() 
		{
			if( !session_id() ) {
				session_start();
			}

			return $this;
		}

		/**
		 * Singleton
		 * Starts the session instantly
		 * @return Session
		 */
		static public function getInstance() 
		{
			if( !self::$instance instanceof self ) {
				self::$instance = new self;
			}

			return self::$instance;
		}


		/**
		 * Checks if variable is in session 
		 * @param string  $name
		 * @return boolean
		 */
		public function __isset($name)
		{
			return isset($_SESSION[$name]);
		}


		/**
		 * Removes a variable from session
		 * @param string $name   
		 */
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


		/**
		 * Removes all session vars
		 * @return Session
		 */
		public function destroy()
		{
			if( session_id() ) {
				session_destroy();
				unset($_SESSION);
			}

			return $this;
		}
	}