<?php

/**
 * @author nek
 * @link https://github.com/nek-v/yii-esmsc
 * @version $Id$
 */
require_once(dirname(__FILE__) . '/ISMSCProvider.php');

abstract class ESMSCProvider extends CComponent implements ISMSCProvider {

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var array
     */
    protected $attribute = array();

    /**
     * @var string
     */
    private $component;

    /**
     * @param ESMSC $component
     * @param array $options
     */
    public function init($component, $options = array()) {
        if (isset($component)) {
            $this->setComponent($component);
        }
        foreach ($options as $key => $value) {
            $this->$key = $value;
        }
    }

    /**
     * @return string
     */
    public function getProviderName() {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getProviderTitle() {
        return Yii::t('esmsc', $this->title);
    }

    /**
     * @return ESMSC
     */
    public function getComponent() {
        return $this->component;
    }

    /**
     * @param ESMSC $component
     */
    public function setComponent($component) {
        $this->component = $component;
    }

    /**
     * @return array
     */
    public function getAttributes() {
        $attributes = array();
        foreach ($this->attributes as $key => $val) {
            $attributes[$key] = $this->getAttribute($key);
        }
        return $attributes;
    }

    /**
     * @param mixed $key
     * @param mixed $default
     * @return mixed
     */
    public function getAttribute($key, $default = null) {
        $getter = 'get' . $key;
        if (method_exists($this, $getter)) {
            return $this->$getter();
        } else {
            return isset($this->attributes[$key]) ? $this->attributes[$key] : $default;
        }
    }

    
    public function __get($name) {
        return parent::__get($name);
    }

    public function __isset($name) {
        return parent::__isset($name);
    }

}
