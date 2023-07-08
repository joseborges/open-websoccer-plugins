<?php

class MwaApprovalLinkConverter implements IConverter {
	private $_i18n;
	private $_websoccer;
	
	public function __construct($i18n, $websoccer) {
		$this->_i18n = $i18n;
		$this->_websoccer = $websoccer;
	}
	
	/**
	 * @see IConverter::toHtml()
	 */
	public function toHtml($row) {
		if ($row["entity_anpassungen_admin_approval_pending"]) {
			$output = " <a href=\"?site=manage&entity=mwa&action=mwaapprove&id=". $row['id']. "\" class=\"btn btn-small btn-success\"><i class=\"icon-ok icon-white\"></i> ". $this->_i18n->getMessage("button_approve") ."</a>";
		} else { 
			$output = "<i class=\"icon-ban-circle\"></i>";
		}
    
		
		return $output;
	}
	
	/**
	 * @see IConverter::toText()
	 */
	public function toText($value) {
		return $value;
	}
	
	/**
	 * @see IConverter::toDbValue()
	 */
	public function toDbValue($value) {
		return $this->toText($value);
	}
	
}

?>