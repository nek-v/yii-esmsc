<?php

/**
 * @author nek
 * @link https://github.com/nek-v/yii-esmsc
 * @link https://github.com/onlinecity/php-smpp
 * @link http://opensmpp.org/specs/smppv34_gsmumts_ig_v10.pdf
 * @link http://www.kannel.org/
 * @version $Id$
 */
Yii::import(Yii::getPathOfAlias(Yii::setPathOfAlias('php-smpp', dirname(__FILE__).'/../../php-smpp/php-smpp').'.*'));
class SMPP extends ESMSCProvider {

    /**
     * @var string
     */
    protected $name = 'smpp';

    /**
     * @var string
     */
    protected $title = 'SMPP';

    /**
     * @var string
     */
    protected $server;

    /**
     * @var integer
     */
    protected $port;

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
    protected $source;

    /**
     * @param integer $phone
     * @param string $message
     */
    public function send($phone, $message) {
        $transport = new SocketTransport(array($this->sever), (int)  $this->port);
        $transport->setRecvTimeout(10000);
        $smpp = new SmppClient($transport);
        $transport->open();
        $smpp->bindTransmitter($this->login, $this->password);
        $encodedMessage = GsmEncoder::utf8_to_gsm0338($message);
        $from = new SmppAddress($this->source, SMPP::TON_ALPHANUMERIC);
        $to = new SmppAddress((int)$phone, SMPP::TON_INTERNATIONAL, SMPP::NPI_E164);
        try {
            $smpp->sendSMS($from, $to, $encodedMessage);
            $smpp->close();
        } catch (ESMSCException $e) {
            Yii::log($e->getMessage(), CLogger::LEVEL_ERROR);
        }
    }
}