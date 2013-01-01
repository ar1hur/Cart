<?php

	namespace Shop\Lib;

	class Session
	{
		static private $instance;
		private function __clone() {}
		private function __construct() {}

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

			self::$instance->start();

			return self::$instance;
		}


		/**
		 * Starts the session
		 * @return Session
		 */
		public function start()
		{
			if( !session_id() ) {
				session_start();
			}

			return $this;
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