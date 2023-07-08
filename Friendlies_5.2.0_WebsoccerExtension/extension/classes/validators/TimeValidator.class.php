<?php
/******************************************************

  Friendly module for HSE WebSoccer-Sim

  Copyright (c) 2013 by

  Pierre Keutel
  EMail: pierre.keutel@yahoo.fr
  Homepage: 
  
  Version: 1.0

******************************************************/

/**
 * @author Pierre Keutel
 * Validates time field input.
 */
class TimeValidator implements IValidator {
	private $_i18n;
	private $_websoccer;
	private $_value;
	
	/**
	 * @param I18n $i18n i18n instance.
	 * @param WebSoccer $websoccer Websoccer instance.
	 * @param mixed $value value to be validated.
	 */
	public function __construct($i18n, $websoccer, $value) {
		$this->_i18n = $i18n;
		$this->_websoccer = $websoccer;
		$this->_value = $value;
	}
	
	/**
	 * @see IValidator::isValid()
	 */
	public function isValid() {
	
		/*** the pattern we wish to match against ***/
		$pattern = "/^([01]?[0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?/";
		
		/*** try to validate with the regex pattern ***/
		if(filter_var($this->_value, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>$pattern))) === false) {
			return FALSE;
		}
		
		return TRUE;
	}
	
	/**
	 * @see IValidator::getMessage()
	 */
	public function getMessage() {
		return $this->_i18n->getMessage("validation_error_time");
	}
	
}

?>