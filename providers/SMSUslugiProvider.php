<?php

/**
 * @author nek
 * @link https://github.com/nek-v/yii-esmsc
 * @link http://sms-uslugi.ru
 * @version $Id$
 */
class SMSUslugiProvider extends ESMSCProvider {

    /**
     * @var string
     */
    protected $name = 'smsuslugi';

    /**
     * @var string
     */
    protected $title = 'Sms-Uslugi.Ru';

    /**
     * @var string
     */
    protected $login;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var string
     */
    protected $source = null;

    /**
     *
     * @var integer
     */
    protected $onlyDelivery = 0;

    /**
     *
     * @var integer
     */
    protected $useAlfasource = 0;

    /**
     * @param mixed $phone
     * @param string $text
     */
    public function send($phone, $message) {
        if (is_array($phone)) {
            $phones = implode(',', $phone);
        } else {
            $phones = $phone;
        }
        $query = http_build_query(array(
            'login'             => $this->login,
            'password'          => $this->password,
            'to'                => $phones,
            'txt'               => $message,
            'source'            => $this->source,
            'onlydelivery'      => $this->onlyDelivery,
            'use_alfasource'    => $this->useAlfasource
        ));
        $responce = file_get_contents('https://lcab.sms-uslugi.ru/lcabApi/sendSms.php?' . $query);
        $responce = CJSON::decode($responce);
        if (isset($responce['code']) && (int) $responce['code'] !== 1) {
            throw new ESMSCException(Yii::t('esmsc', $responce['descr']), (int) $responce['code']);
        }
    }

}
