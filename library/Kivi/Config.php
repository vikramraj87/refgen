<?php
namespace Kivi;

/**
 * Configuration base class
 *
 * @package Kivi
 * @author Vikram
 * @version 1.0.1
 */
class Config implements \Countable, \Iterator {
    /**
     * Number of config items
     *
     * @var int
     */
    protected $_count;

    /**
     * Iteration index
     *
     * @var int
     */
    protected $_index;

    /**
     * Contains array of configuration data
     *
     * @var array
     */
    protected $_data;

    /**
     * This is used to track section inheritance. The keys are names of sections that
     * extend other sections, and the values are the extended sections.
     *
     * @var array
     */
    protected $_extends = array();

    /**
     * Contains which config file sections were loaded. This is null
     * if all sections were loaded, a string name if one section is loaded
     * and an array of string names if multiple sections were loaded.
     *
     * @var mixed
     */
    protected $_loadedSection = null;

    /**
     * Load file error string
     *
     * @var null|string
     */
    protected $_loadFileErrorStr = null;

    /**
     * Constructor
     *
     * @param  array   $array
     */
    public function __construct(array $array)
    {
        $this->_index = 0;
        $this->_data = array();
        foreach($array as $k => $v) {
            if(is_array($v)) {
                $this->_data[$k] = new self($v);
            } else {
                $this->_data[$k] = $v;
            }
        }
        $this->_count = count($this->_data);
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Count elements of an object
     * @link http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     */
    public function count()
    {
        return $this->_count;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     */
    public function current()
    {
        return current($this->_data);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     */
    public function key()
    {
        return key($this->_data);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     */
    public function next()
    {
        next($this->_data);
        $this->_index++;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     */
    public function rewind()
    {
        reset($this->_data);
        $this->_index = 0;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Checks if current position is valid
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     */
    public function valid()
    {
        return $this->_index < $this->_count;
    }

    /**
     * Returns config data in associative array format
     *
     * @return array
     */
    public function toArray()
    {
        $array = array();
        $data = $this->_data;
        foreach($data as $k => $v) {
            if($v instanceof Config) {
                $array[$k] = $v->toArray();
            } else {
                $array[$k] = $v;
            }
        }
        return $array;
    }

    /**
     * Retrieve a value from config data and return default if nothing found
     * @param string $name
     * @param mixed  $default
     * @return mixed
     */
    public function get($name, $default = null)
    {
        $result = $default;
        if(array_key_exists($name, $this->_data)) {
            $result = $this->_data[$name];
        }
        return $result;
    }

    /**
     * Magic getter
     *
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->get($name);
    }

    /**
     * Magic isset function
     *
     * @param string $name
     * @return bool
     */
    public function __isset($name)
    {
        return isset($this->_data[$name]);
    }

    /**
     * Extends the section with the section to be extended. Checks for circular reference error
     *
     * @param string $extendingSection
     * @param string $extendedSection
     * @throws Config\CircularReferenceException
     */
    protected function _assertValidExtend($extendingSection, $extendedSection)
    {
        $extendedSectionCurrent = $extendedSection;
        while(array_key_exists($extendedSectionCurrent, $this->_extends)) {
            if($this->_extends[$extendedSectionCurrent] == $extendingSection) {
                require_once "Config/CircularReferenceException.php";
                throw new Config\CircularReferenceException();
            }
            $extendedSectionCurrent = $this->_extends[$extendedSectionCurrent];
        }
        $this->_extends[$extendingSection] = $extendedSection;
    }

    /**
     * Handle any errors from simplexml_load_file or parse_ini_file
     *
     * @param int    $errno
     * @param string $errstr
     * @param string $errfile
     * @param int    $errline
     */
    protected function _loadFileErrorHandler($errno, $errstr, $errfile, $errline)
    {
        if($this->_loadFileErrorStr === null) {
            $this->_loadFileErrorStr = $errstr;
        } else {
            $this->_loadFileErrorStr .= (PHP_EOL . $errstr);
        }
    }

    /**
     * Merges the second array with the first array overwriting any existing keys
     *
     * @param array $firstArray
     * @param array $secondArray
     * @return array
     */
    protected function _arrayMergeRecursive($firstArray, $secondArray)
    {
        if(is_array($firstArray) && is_array($secondArray)) {
            foreach($secondArray as $key => $value) {
                if(isset($firstArray[$key])) {
                    $firstArray[$key] = $this->_arrayMergeRecursive($firstArray[$key], $value);
                } else {
                    if($key === 0) {
                        $firstArray = array(0 => $this->_arrayMergeRecursive($firstArray, $value));
                    } else {
                        $firstArray[$key] = $value;
                    }
                }
            }
        } else {
            $firstArray = $secondArray;
        }
        return $firstArray;
    }
} 