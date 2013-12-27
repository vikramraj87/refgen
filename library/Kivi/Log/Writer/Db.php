<?php
namespace Kivi\Log\Writer;


class Db extends \Kivi\log\Writer {
    private $_dbHandle = null;

    private $_table;

    private $_fields = array();

    public function __construct(\PDO $dbHandle, $table)
    {
        $this->_dbHandle   = $dbHandle;
        $this->_table      = $table;
    }

    public function shutdown()
    {
        $this->_dbHandle = null;
    }

    protected function _write($event)
    {
        if(is_null($this->_dbHandle)) {
            // throw exception
        }
        if(!isset($event["extra"])) {
            $event["extra"] = "";
        }

        $fields = $this->_getFields();
        $dataToInsert = array();
        foreach($fields as $field) {
            if(isset($event[$field])) {
                $dataToInsert[$field] = $event[$field];
            }
        }
        $sth = $this->_dbHandle->prepare("INSERT INTO " . $this->_table . " (priority, message, extra) values (:priority, :message, :extra)");
        $sth->execute($dataToInsert);
    }

    protected function _getFields()
    {
        if(empty($this->_fields)) {
            $sth = $this->_dbHandle->prepare("DESCRIBE " . $this->_table);
            $sth->execute();

            $this->_fields = $sth->fetchAll(\PDO::FETCH_COLUMN);
        }
        return $this->_fields;
    }
} 