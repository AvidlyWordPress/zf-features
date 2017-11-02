<?php

namespace ZF_Features;

class Config {

	/**
	 * User configuration.
	 *
	 * @var array
	 */
	protected $user_config = [];

	/**
	 * Initializes the config.
	 *
	 * @param string $app_filepath Path to the application configuration file.
	 * @param string $env_filepath Path to the environment configuration file.
	 */
	function __construct( string $app_filepath = '', string $env_filepath = '' ) {
		// Load the application configuration, should be located in.
		if ( file_exists( $app_filepath ) && $app_filepath ) {
			$this->user_config = include( $app_filepath );
		}

		// Load the environment configuration.
		if ( file_exists( $env_filepath ) && $env_filepath ) {
			$this->user_config = array_merge( (array) $this->user_config, include( $env_filepath ) );
		}
	}

	/**
	 * Fetches the whole config.
	 *
	 * @return array Complete config file.
	 */
	public function get() {
		return $this->user_config;
	}

	/**
	 * Fetches a single config property.
	 *
	 * @param  string $property_name Property name.
	 * @return mixed The property value.
	 */
	public function property( $property_name ) {
		return ( array_key_exists( $property_name, $this->user_config ) ) ? $this->user_config[ $property_name ] : null;
	}
}
