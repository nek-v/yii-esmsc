<?php

/**
 * @author nek
 * @link https://github.com/nek-v/yii-esmsc
 * @version $Id$
 */
class DummyProvider extends ESMSCProvider {
    
    /**
     * @var string
     */
    protected $name = 'dummy';

    /**
     * @var string
     */
    protected $title = 'Dummy';

    /**
     * @param string $phone
     * @param string $message
     */
    public function send($phone, $message) {
        Yii::log('Phone: '.$phone.' Message: '.$message, CLogger::LEVEL_INFO);
    }
}
