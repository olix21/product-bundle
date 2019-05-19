<?php

namespace Dywee\ProductBundle\Service;

use Symfony\Component\HttpFoundation\Session\Session;

class SessionManager
{

    private $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function setTrackingKey()
    {
        $key = time() . '_' . $_SERVER['REMOTE_ADDR'] . '_' . rand(0, 99);
        $this->session->set('product_tracking_key', $key);
        return $key;
    }

    public function getTrackingKey()
    {
        $trackingKey = $this->session->get('product_tracking_key');
        if (!$trackingKey) {
            return $this->setTrackingKey();
        }
        return $trackingKey;
    }

    public function removeTrackingKey()
    {
        $this->session->remove('product_tracking_key');
    }
}
