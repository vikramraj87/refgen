<?php
namespace Kivi\Config;

/**
 * @see Kivi\Config
 */
require_once dirname(__FILE__) . "/../Config.php";

/**
 * Xml Configuration class
 *
 * @package Kivi
 * @author Vikram
 * @version 1.0.1
 */
class Xml extends \Kivi\Config {
    /**
     * Constructor
     *
     * @param string $xml name of xml file or xml as string
     * @param string|null $section section of the xml config file
     * @throws Exception when simplexml_load_file generates error
     * @throws SectionNotFoundException when supplied section is not found in the xml document
     */
    public function __construct($xml, $section = null)
    {
        if(empty($xml)) {
            throw new \InvalidArgumentException("Argument xml must be a string containing xml document or xml filename");
        }

        set_error_handler(array($this, "_loadFileErrorHandler"));
        if(strstr($xml, '<?xml')) {
            $config = simplexml_load_string($xml);
        } else {
            $config = simplexml_load_file($xml);
        }
        restore_error_handler();

        if(!is_null($this->_loadFileErrorStr)) {
            require_once "Exception.php";
            throw new Exception($this->_loadFileErrorStr);
        }

        if(is_null($section)) {
            $dataArray = array();
            foreach($config as $sectionName => $sectionData) {
                $dataArray[$sectionName] = $this->_processExtends($config, $sectionName);
            }
            parent::__construct($dataArray);
        } else if(is_array($section)) {
            $dataArray = array();
            foreach($section as $sectionName) {
                if(!isset($config->$sectionName)) {
                    require_once "SectionNotFoundException.php";
                    throw new SectionNotFoundException($sectionName);
                }
                $dataArray = array_merge($this->_processExtends($config, $sectionName), $dataArray);
            }
            parent::__construct($dataArray);
        } else {
            if(!isset($config->$section)) {
                require_once "SectionNotFoundException.php";
                throw new SectionNotFoundException($section);
            }
            $dataArray = $this->_processExtends($config, $section);
            if (!is_array($dataArray)) {
                // Section in the XML file contains just one top level string
                $dataArray = array($section => $dataArray);
            }
            parent::__construct($dataArray);
        }

    }

    /**
     * Processes extension recursively
     *
     * @param \SimpleXMLElement $element
     * @param string $section
     * @param array $config
     * @return array
     * @throws SectionNotFoundException
     */
    protected function _processExtends(\SimpleXMLElement $element, $section, array $config = array())
    {
        if(!isset($element->$section)) {
            require_once "SectionNotFoundException.php";
            throw new SectionNotFoundException($section);
        }
        /** @var \SimpleXMLElement $thisSection */
        $thisSection = $element->$section;
        $attributes = $thisSection->attributes();

        if(isset($thisSection["extends"]) || isset($attributes["extends"])) {
            $extendedSection = (string) (isset($attributes["extends"]) ? $attributes["extends"] : $thisSection["extends"]);
            $this->_assertValidExtend($section, $extendedSection);
            $config = $this->_processExtends($element, $extendedSection, $config);
        }

        $config = $this->_arrayMergeRecursive($config, $this->_toArray($thisSection));
        return $config;
    }

    /**
     * XML object to array
     * 
     * @param \SimpleXMLElement $xmlObject
     * @return array
     */
    protected function _toArray(\SimpleXMLElement $xmlObject)
    {
        $config = array();
        $attributes = $xmlObject->attributes();

        if($attributes->count() > 0) {
            foreach($attributes as $key=>$value) {
                if($key === "extends") {
                    continue;
                }
                if(array_key_exists($key, $config)) {
                    if(!is_array($config[$key])) {
                        $config[$key] = array($config[$key]);
                    }
                    $config[$key][] = (string) $value;
                } else {
                    $config[$key] = (string) $value;
                }
            }
        }

        if($xmlObject->children()->count() > 0) {
            foreach($xmlObject->children() as $key => $value) {
                if(count($value->children()) > 0) {
                    $value = $this->_toArray($value);
                } else if (count($value->attributes()) > 0) {
                    $attributes = $value->attributes();
                    if(isset($attributes["value"])) {
                        $value = (string) $attributes["value"];
                    } else {
                        $value = $this->_toArray($value);
                    }
                } else {
                    $value = (string) $value;
                }

                if(array_key_exists($key, $config)) {
                    if(!is_array($config[$key]) || !array_key_exists(0, $config[$key])) {
                        $config[$key] = array($config[$key]);
                    }
                    $config[$key][] = $value;
                } else {
                    $config[$key] = $value;
                }
            }
        } else if (!isset($xmlObject["extends"]) && !isset($attributes["extends"])) {
            $config = (string) $xmlObject;
        }

        return $config;
    }
} 