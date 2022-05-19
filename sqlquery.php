<?php
 
class SQLQuery {
    protected $_dbHandle;
    protected $_result;
 
    /** Connects to database **/
 
    function connect($address, $account, $pwd, $name) {
        $this->_dbHandle = @mysqli_connect($address, $account, $pwd);
        if ($this->_dbHandle != 0) {
            if (mysqli_select_db($name, $this->_dbHandle)) {
                return 1;
            }
            else {
                return 0;
            }
        }
        else {
            return 0;
        }
    }
 
    /** Disconnects from database **/
 
    function disconnect() {
        if (@mysqli_close($this->_dbHandle) != 0) {
            return 1;
        }  else {
            return 0;
        }
    }
     
    function selectAll() {
        $query = 'select * from `'.$this->_table.'`';
        return $this->query($query);
    }
     
    function select($id) {
        $query = 'select * from `'.$this->_table.'` where `id` = \''.mysql_real_escape_string($id).'\'';
        return $this->query($query, 1);    
    }
 
     
    /** Custom SQL Query **/
 
    function query($query, $singleResult = 0) {
 
        $this->_result = mysqli_query($query, $this->_dbHandle);
 
        if (preg_match("/select/i",$query)) {
        $result = array();
        $table = array();
        $field = array();
        $tempResults = array();
        $numOfFields = mysql_num_fields($this->_result);
        for ($i = 0; $i < $numOfFields; ++$i) {
            array_push($table,mysql_field_table($this->_result, $i));
            array_push($field,mysql_field_name($this->_result, $i));
        }
 
         
            while ($row = mysql_fetch_row($this->_result)) {
                for ($i = 0;$i < $numOfFields; ++$i) {
                    $table&#91;$i&#93; = trim(ucfirst($table&#91;$i&#93;),"s");
                    $tempResults&#91;$table&#91;$i&#93;&#93;&#91;$field&#91;$i&#93;&#93; = $row&#91;$i&#93;;
                }
                if ($singleResult == 1) {
                    mysql_free_result($this->_result);
                    return $tempResults;
                }
                array_push($result,$tempResults);
            }
            mysql_free_result($this->_result);
            return($result);
        }
         
 
    }
 
    /** Get number of rows **/
    function getNumRows() {
        return mysqli_num_rows($this->_result);
    }
 
    /** Free resources allocated by a query **/
 
    function freeResult() {
        mysqli_free_result($this->_result);
    }
 
    /** Get error string **/
 
    function getError() {
        return mysqli_error($this->_dbHandle);
    }
}