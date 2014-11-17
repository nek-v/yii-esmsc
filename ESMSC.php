<?php

/**
 * @author nek
 * @link https://github.com/nek-v/yii-esmsc
 * @version $Id$
 */
class ESMSC extends CApplicationComponent {

    /**
     * @var array
     */
    public $providers = array();

    /**
     *
     */
    public function init() {
        Yii::setPathOfAlias('esmsc', dirname(__FILE__));
        Yii::import('esmsc.*');
        Yii::import('esmsc.providers.*');
    }

    /**
     * @param string $provider
     * @return array
     * @throws ESMSCException
     */
    public function getProvider($provider) {
        $provider = strtolower($provider);
        $providers = $this->getProviders();
        if (!isset($providers[$provider])) {
            throw new ESMSCException(Yii::t('esmsc', 'Undefined provider: {provider}', array('{provider}' => $provider)), 500);
        }
        return $provider[$provider];
    }

    /**
     * @return array
     */
    public function getProviders() {
        $providers = false;
        if ($providers === false || !is_array($providers)) {
            $providers = array();
            foreach ($this->providers as $provider => $options) {
                $class = $this->getIdentity($provider, $options);
                $providers[$provider] = (object) array(
                    'id' => $class->getProviderName(),
                    'title' => $class->getProviderTitle()
                );
            }
        }
        return $providers;
    }

    public function getInstance($provider, $options = array()) {
        $provider = strtolower($provider);
        if (!isset($this->providers[$provider])) {
            throw new ESMSCException(Yii::t('esmsc', 'Undefined provider: {provider}.', array('{provider}' => $provider)), 500);
        }
        $provider = $this->providers[$provider];
        $class = $provider['class'];
        $point = strrpos($class, '.');
        if ($point > 0) {
            Yii::import($class);
            $class = substr($class, $point + 1);
        }
        unset($provider['class']);
        $identity = new $class();
        $identity->init($this, array_merge($provider, $options));
        return $identity;
    }

}
