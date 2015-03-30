<?php
/*
	This SQL query will create the table to store your object.

	CREATE TABLE `users` (
	`usersid` int(11) NOT NULL auto_increment,
	`id` BIGINT NOT NULL,
	`first_name` VARCHAR(255) NOT NULL,
	`last_name` VARCHAR(255) NOT NULL,
	`email` VARCHAR(255) NOT NULL,
	`password` VARCHAR(255) NOT NULL,
	`created_at` DATETIME NOT NULL,
	`modified_at` DATETIME NOT NULL, PRIMARY KEY  (`usersid`)) ENGINE=MyISAM;
*/

/**
* <b>users</b> class with integrated CRUD methods.
* @author Php Object Generator
* @version POG 3.2 / PHP5
* @copyright Free for personal & commercial use. (Offered under the BSD license)
* @link http://www.phpobjectgenerator.com/?language=php5&wrapper=pog&objectName=users&attributeList=array+%28%0A++0+%3D%3E+%27id%27%2C%0A++1+%3D%3E+%27first_name%27%2C%0A++2+%3D%3E+%27last_name%27%2C%0A++3+%3D%3E+%27email%27%2C%0A++4+%3D%3E+%27password%27%2C%0A++5+%3D%3E+%27created_at%27%2C%0A++6+%3D%3E+%27modified_at%27%2C%0A%29&typeList=array+%28%0A++0+%3D%3E+%27BIGINT%27%2C%0A++1+%3D%3E+%27VARCHAR%28255%29%27%2C%0A++2+%3D%3E+%27VARCHAR%28255%29%27%2C%0A++3+%3D%3E+%27VARCHAR%28255%29%27%2C%0A++4+%3D%3E+%27VARCHAR%28255%29%27%2C%0A++5+%3D%3E+%27DATETIME%27%2C%0A++6+%3D%3E+%27DATETIME%27%2C%0A%29
*/
include_once('class.pog_base.php');
class users extends POG_Base
{
	public $usersId = '';

	/**
	 * @var BIGINT
	 */
	public $id;
	
	/**
	 * @var VARCHAR(255)
	 */
	public $first_name;
	
	/**
	 * @var VARCHAR(255)
	 */
	public $last_name;
	
	/**
	 * @var VARCHAR(255)
	 */
	public $email;
	
	/**
	 * @var VARCHAR(255)
	 */
	public $password;
	
	/**
	 * @var DATETIME
	 */
	public $created_at;
	
	/**
	 * @var DATETIME
	 */
	public $modified_at;
	
	public $pog_attribute_type = array(
		"usersId" => array('db_attributes' => array("NUMERIC", "INT")),
		"id" => array('db_attributes' => array("NUMERIC", "BIGINT")),
		"first_name" => array('db_attributes' => array("TEXT", "VARCHAR", "255")),
		"last_name" => array('db_attributes' => array("TEXT", "VARCHAR", "255")),
		"email" => array('db_attributes' => array("TEXT", "VARCHAR", "255")),
		"password" => array('db_attributes' => array("TEXT", "VARCHAR", "255")),
		"created_at" => array('db_attributes' => array("TEXT", "DATETIME")),
		"modified_at" => array('db_attributes' => array("TEXT", "DATETIME")),
		);
	public $pog_query;
	
	
	/**
	* Getter for some private attributes
	* @return mixed $attribute
	*/
	public function __get($attribute)
	{
		if (isset($this->{"_".$attribute}))
		{
			return $this->{"_".$attribute};
		}
		else
		{
			return false;
		}
	}
	
	function users($id='', $first_name='', $last_name='', $email='', $password='', $created_at='', $modified_at='')
	{
		$this->id = $id;
		$this->first_name = $first_name;
		$this->last_name = $last_name;
		$this->email = $email;
		$this->password = $password;
		$this->created_at = $created_at;
		$this->modified_at = $modified_at;
	}
	
	
	/**
	* Gets object from database
	* @param integer $usersId 
	* @return object $users
	*/
	function Get($usersId)
	{
		$connection = Database::Connect();
		$this->pog_query = "select * from `users` where `usersid`='".intval($usersId)."' LIMIT 1";
		$cursor = Database::Reader($this->pog_query, $connection);
		while ($row = Database::Read($cursor))
		{
			$this->usersId = $row['usersid'];
			$this->id = $this->Unescape($row['id']);
			$this->first_name = $this->Unescape($row['first_name']);
			$this->last_name = $this->Unescape($row['last_name']);
			$this->email = $this->Unescape($row['email']);
			$this->password = $this->Unescape($row['password']);
			$this->created_at = $row['created_at'];
			$this->modified_at = $row['modified_at'];
		}
		return $this;
	}
	
	
	/**
	* Returns a sorted array of objects that match given conditions
	* @param multidimensional array {("field", "comparator", "value"), ("field", "comparator", "value"), ...} 
	* @param string $sortBy 
	* @param boolean $ascending 
	* @param int limit 
	* @return array $usersList
	*/
	function GetList($fcv_array = array(), $sortBy='', $ascending=true, $limit='')
	{
		$connection = Database::Connect();
		$sqlLimit = ($limit != '' ? "LIMIT $limit" : '');
		$this->pog_query = "select * from `users` ";
		$usersList = Array();
		if (sizeof($fcv_array) > 0)
		{
			$this->pog_query .= " where ";
			for ($i=0, $c=sizeof($fcv_array); $i<$c; $i++)
			{
				if (sizeof($fcv_array[$i]) == 1)
				{
					$this->pog_query .= " ".$fcv_array[$i][0]." ";
					continue;
				}
				else
				{
					if ($i > 0 && sizeof($fcv_array[$i-1]) != 1)
					{
						$this->pog_query .= " AND ";
					}
					if (isset($this->pog_attribute_type[$fcv_array[$i][0]]['db_attributes']) && $this->pog_attribute_type[$fcv_array[$i][0]]['db_attributes'][0] != 'NUMERIC' && $this->pog_attribute_type[$fcv_array[$i][0]]['db_attributes'][0] != 'SET')
					{
						if ($GLOBALS['configuration']['db_encoding'] == 1)
						{
							$value = POG_Base::IsColumn($fcv_array[$i][2]) ? "BASE64_DECODE(".$fcv_array[$i][2].")" : "'".$fcv_array[$i][2]."'";
							$this->pog_query .= "BASE64_DECODE(`".$fcv_array[$i][0]."`) ".$fcv_array[$i][1]." ".$value;
						}
						else
						{
							$value =  POG_Base::IsColumn($fcv_array[$i][2]) ? $fcv_array[$i][2] : "'".$this->Escape($fcv_array[$i][2])."'";
							$this->pog_query .= "`".$fcv_array[$i][0]."` ".$fcv_array[$i][1]." ".$value;
						}
					}
					else
					{
						$value = POG_Base::IsColumn($fcv_array[$i][2]) ? $fcv_array[$i][2] : "'".$fcv_array[$i][2]."'";
						$this->pog_query .= "`".$fcv_array[$i][0]."` ".$fcv_array[$i][1]." ".$value;
					}
				}
			}
		}
		if ($sortBy != '')
		{
			if (isset($this->pog_attribute_type[$sortBy]['db_attributes']) && $this->pog_attribute_type[$sortBy]['db_attributes'][0] != 'NUMERIC' && $this->pog_attribute_type[$sortBy]['db_attributes'][0] != 'SET')
			{
				if ($GLOBALS['configuration']['db_encoding'] == 1)
				{
					$sortBy = "BASE64_DECODE($sortBy) ";
				}
				else
				{
					$sortBy = "$sortBy ";
				}
			}
			else
			{
				$sortBy = "$sortBy ";
			}
		}
		else
		{
			$sortBy = "usersid";
		}
		$this->pog_query .= " order by ".$sortBy." ".($ascending ? "asc" : "desc")." $sqlLimit";
		$thisObjectName = get_class($this);
		$cursor = Database::Reader($this->pog_query, $connection);
		while ($row = Database::Read($cursor))
		{
			$users = new $thisObjectName();
			$users->usersId = $row['usersid'];
			$users->id = $this->Unescape($row['id']);
			$users->first_name = $this->Unescape($row['first_name']);
			$users->last_name = $this->Unescape($row['last_name']);
			$users->email = $this->Unescape($row['email']);
			$users->password = $this->Unescape($row['password']);
			$users->created_at = $row['created_at'];
			$users->modified_at = $row['modified_at'];
			$usersList[] = $users;
		}
		return $usersList;
	}
	
	
	/**
	* Saves the object to the database
	* @return integer $usersId
	*/
	function Save()
	{
		$connection = Database::Connect();
		$rows = 0;
		if ($this->usersId!=''){
			$this->pog_query = "select `usersid` from `users` where `usersid`='".$this->usersId."' LIMIT 1";
			$rows = Database::Query($this->pog_query, $connection);
		}
		if ($rows > 0)
		{
			$this->pog_query = "update `users` set 
			`id`='".$this->Escape($this->id)."', 
			`first_name`='".$this->Escape($this->first_name)."', 
			`last_name`='".$this->Escape($this->last_name)."', 
			`email`='".$this->Escape($this->email)."', 
			`password`='".$this->Escape($this->password)."', 
			`created_at`='".$this->created_at."', 
			`modified_at`='".$this->modified_at."' where `usersid`='".$this->usersId."'";
		}
		else
		{
			$this->pog_query = "insert into `users` (`id`, `first_name`, `last_name`, `email`, `password`, `created_at`, `modified_at` ) values (
			'".$this->Escape($this->id)."', 
			'".$this->Escape($this->first_name)."', 
			'".$this->Escape($this->last_name)."', 
			'".$this->Escape($this->email)."', 
			'".$this->Escape($this->password)."', 
			'".$this->created_at."', 
			'".$this->modified_at."' )";
		}
		$insertId = Database::InsertOrUpdate($this->pog_query, $connection);
		if ($this->usersId == "")
		{
			$this->usersId = $insertId;
		}
		return $this->usersId;
	}
	
	
	/**
	* Clones the object and saves it to the database
	* @return integer $usersId
	*/
	function SaveNew()
	{
		$this->usersId = '';
		return $this->Save();
	}
	
	
	/**
	* Deletes the object from the database
	* @return boolean
	*/
	function Delete()
	{
		$connection = Database::Connect();
		$this->pog_query = "delete from `users` where `usersid`='".$this->usersId."'";
		return Database::NonQuery($this->pog_query, $connection);
	}
	
	
	/**
	* Deletes a list of objects that match given conditions
	* @param multidimensional array {("field", "comparator", "value"), ("field", "comparator", "value"), ...} 
	* @param bool $deep 
	* @return 
	*/
	function DeleteList($fcv_array)
	{
		if (sizeof($fcv_array) > 0)
		{
			$connection = Database::Connect();
			$pog_query = "delete from `users` where ";
			for ($i=0, $c=sizeof($fcv_array); $i<$c; $i++)
			{
				if (sizeof($fcv_array[$i]) == 1)
				{
					$pog_query .= " ".$fcv_array[$i][0]." ";
					continue;
				}
				else
				{
					if ($i > 0 && sizeof($fcv_array[$i-1]) !== 1)
					{
						$pog_query .= " AND ";
					}
					if (isset($this->pog_attribute_type[$fcv_array[$i][0]]['db_attributes']) && $this->pog_attribute_type[$fcv_array[$i][0]]['db_attributes'][0] != 'NUMERIC' && $this->pog_attribute_type[$fcv_array[$i][0]]['db_attributes'][0] != 'SET')
					{
						$pog_query .= "`".$fcv_array[$i][0]."` ".$fcv_array[$i][1]." '".$this->Escape($fcv_array[$i][2])."'";
					}
					else
					{
						$pog_query .= "`".$fcv_array[$i][0]."` ".$fcv_array[$i][1]." '".$fcv_array[$i][2]."'";
					}
				}
			}
			return Database::NonQuery($pog_query, $connection);
		}
	}
}
?>
