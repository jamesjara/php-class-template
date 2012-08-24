<?php

exit( main() );

function main( ) {	

	$object = new class_prototype();
	$object->setDebug(false);
	$object->main();
	
}

//Set namespace if is necesary

/**
 * @package    Class_patito
 * @copyright  Copyright (c) 2010-2014 Your Company. (Your Page)
 * @license    LicenseUrl	LicenseName
 */
class class_prototype {
	
	//=============Some LOG modes==================
    const log_info  = "Info";
    const log_error = "Error";
    const log_debug = "Debug";
    const log_always = "Always";
	
	//=============1.Set variables==================
	private static $instance;
	
	protected $debug = null;
	
	//=============2.Set constructors==================
	/**
	 * Create a singleton 
	 *
	 * @return self object instance
	 */
	public static function getInstance(){
		if(!self::$instance){
			return self::$instance = new self();
		}
		return self::$instance; 
	}
	
	/**
	 * Initiate the object class_prototype
	 */
	public function __construct(){ }
	
	//=============3.Set setters and getters==================
	/**
	 * Set the debug mode
	 *
	 * @param  boolean will show debug information if set to true, else will not show anything
	 */
	public function setDebug($value ){
		$this->debug = (($value==true) ? true : false);
	}
	
	/**
	 * Function to print log information
	 *
	 * @param  $msg			Message to display
	 * @param  $severity	The kind of Log 
	 */
	private function _log( $msg , $severity ) {
		$string =  sprintf( "[%s]\t[%s] : %s \n", $severity, date('c') , $msg );
		if( ($this->debug==true) or ( $severity == self::log_always) ) {
			echo $string;
		}
	}
	
	/**
	 * Function to write only log errors
	 *
	 * @param  $msg		Message to write
	 */
	private function write_Log_error( $msg ){
		$error_log_path = date('y_d_m').'.log';
		if(!$this->writeToFile( $error_log_path, $msg."\n" , true )){
			echo " CRITICAL ERROR Error writing log error. \n";
			die();
		}
	}
	
	/**
	 * Function to write a msg to a specific file
	 *
	 * @param  $path		Path of the target file, using fopen(W)
	 * @param  $data		Msg to write
	 * @param  $appened		if is true will appened the data to the end of  the file
	 */
	public function writeToFile( $path , $data , $appened = false ){
		$mode = ( ($appened==true) ? 'a' : 'w' );
		if(is_writable(dirname($path))){
			$handle = fopen( $path  , $mode);
			if (!$handle){
				$this->write_Log_error("Cant open the file $path ");
				$this->_log("Cant open the file $path ", 'Error' );
				return false;
			}
			if (!fwrite($handle,$data)) {
				$this->write_Log_error("Cannot write the file $path ");
				$this->_log("Cannot write the file $path ", 'Error' );
				exit; //in this case should stop the program
			} else {
				fclose( $handle );
				return true;
			}
		}
	}

	//=============4.Set OUR basic functions here==================
	
	//=============5.Set main function==================
	/**
	 * Call this function to execute your program logic.
	 *
	 */
	public function main() {
		echo 'test';
	}
	
}
