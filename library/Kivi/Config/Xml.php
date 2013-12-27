<?php
/**
 * Created by PhpStorm.
 * User: vikramraj
 * Date: 25/12/13
 * Time: 2:18 PM
 */

namespace Kivi\Config;
require_once "Kivi/Config.php";

class Xml extends \Kivi\Config {
    public function __construct($xml, $section = null)
    {
        if(empty($xml)) {
            //throw exception
        }
        //set error handler
        if(strstr($xml, '<?xml')) {
            $config = simplexml_load_string($xml);
        } else {
            $config = simplexml_load_file($xml);
        }
        //restore error handler

        //check for error
        if(is_null($section)) {

        }
    }
    protected function _processExtends(\SimpleXMLElement $element, $section, array $config = array())
    {
        if(!isset($element->$section)) {
            //throw exception
        }
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

    protected function _toArray(\SimpleXMLElement $xmlObject)
    {
        $config = array();
        $attributes = $xmlObject->attributes();

        //TODO: Check simplexmlelement is countable or not
        if(count($attributes) > 0) {
            foreach($attributes as $key=>$value) {
                if($key === "extends") {
                    continue;
                }
                if(array_key_exists($key, $config)) {
                    if(!is_array($config[$key])) {
                        $config[$key] = array($config[$key]);
                    }
                    $config[$key][] = $value;
                } else {
                    $config[$key] = $value;
                }
            }
        }

        //TODO: Check simplexmlelement is countable or not
        if(count($xmlObject->children()) > 0) {
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