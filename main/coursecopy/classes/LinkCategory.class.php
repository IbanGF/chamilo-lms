<?php
/* For licensing terms, see /license.txt */

require_once 'Resource.class.php';

/**
 * A LinkCategory
 * @author Bart Mollet <bart.mollet@hogent.be>
 * @package chamilo.backup
 */
class LinkCategory extends Resource
{
	/**
	 * The title
	 */
	var $title;
	/**
	 * The description
	 */
	var $description;
	/**
	 * The display order
	 */
	var $display_order;
	/**
	 * Create a new LinkCategory
	 * @param int $id
	 * @param string $title
	 * @param string $description
	 */
	function __construct($id,$title,$description,$display_order)
	{
		parent::__construct($id,RESOURCE_LINKCATEGORY);
		$this->title = $title;
		$this->description = $description;
		$this->display_order = $display_order;
	}
	/**
	 * Show this LinkCategory
	 */
	function show()
	{
		parent::show();
		echo $this->title.' '.$this->description.'<br />';
	}
}
