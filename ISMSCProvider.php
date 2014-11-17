<?php

/**
 * @author nek
 * @link https://github.com/nek-v/yii-esmsc
 * @version $Id$
 */
interface ISMSCProvider {

    /**
     * @param ESMSC $component
     * @param array $options
     */
    public function init($component, $options = array());

    /**
    * @param string $key
    * @param mixed $default
    */
    public function getAttribute($key, $default = null);

    /**
     *
     */
    public function getAttributes();

    /**
     * @return string
     */
    public function getProviderName();

    /**
     * @return string
     */
    public function getProviderTitle();

    /**
     * @return ESMSC
     */
    public function getComponent();

    /**
     * @param ESMSC $component
     */
    public function setComponent($component);

    /**
     * @param mixed $phone
     * @param string $message
     */
    public function send($phone, $message);
}
