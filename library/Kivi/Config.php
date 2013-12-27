<?php
namespace Kivi;


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
     * Used when unsetting values during iteration to ensure we don't skip
     * the next element
     *
     * @var boolean
     */
    protected $_skipNextIteration;

    /**
     * Contains array of configuration data
     *
     * @var array
     */
    protected $_data;

    protected $_extends;

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
        $this->_skipNextIteration = false;
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
        if($this->_skipNextIteration) {
            $this->_skipNextIteration = false;
            return;
        }
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
        $this->_skipNextIteration = false;
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

    protected function _assertValidExtend($extendingSection, $extendedSection)
    {
        $extendedSectionCurrent = $extendedSection;
        if(array_key_exists($extendedSectionCurrent, $this->_extends)) {
            if($this->_extends[$extendedSectionCurrent] == $extendingSection) {
                //throw exception
            }
            $extendedSectionCurrent = $this->_extends[$extendedSectionCurrent];
        }
        $this->_extends[$extendingSection] = $extendedSection;
    }

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