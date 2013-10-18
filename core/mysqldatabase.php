<?php

	class MySQL {

		function __construct($host, $username, $password, $database = null)
		{
			$this->connection = mysql_connect($host, $username, $password) ;
			if ($this->connection === false) 
			{
				throw new Exception(mysql_error()) ;
			}
			if (! is_null($database)) 
			{
				if (! $this->use_db($database))
				 {
					throw new Exception(mysql_error()) ;
				}
			}
		}
		

		function error() 
		{
                return mysql_error($this->connection) ;
        }


        function use_db($database)
         {
                if (! $this->connection) 
                {
                        return false ;
                }
                
                return mysql_select_db($database, $this->connection) ;
        }


        function executeQuery($query, $data = null) 
        {
                if (! $this->connection) 
                {
                        return false ;
                }
                
			if (! is_null($data)) 
			{
                        foreach ($data as $key => $value) 
                        	{
                                
                                $value = mysql_real_escape_string($value, $this->connection) ;
                                
                                if ($value === false) 
                                {
                                        
                                        return false ;
                                }
                                
                                $query = str_replace($key, "'$value'", $query) ;
                        }
                }
                
                return mysql_query($query, $this->connection) ;
	}
	

	function insert($table, $row) 
	{
                if (! $this->connection || ! is_array($row) || count($row) == 0) 
                {
                        return false ;
                }
                
                $table = mysql_real_escape_string($table, $this->connection) ;
                
                $keys = array() ;
                $values = array() ;
                
                
                foreach ($row as $key => $value) 
                {
                        $keys[] = "`" . mysql_real_escape_string($key, $this->connection) . "`"  ;
                        $values[] = "'" . mysql_real_escape_string($value, $this->connection) . "'"  ;
                }
                

                $keys = join(',', $keys) ;
                $values = join(',', $values) ;
                
                return mysql_query("INSERT INTO `{$table}` ({$keys}) VALUES ({$values})") ;
        }
}