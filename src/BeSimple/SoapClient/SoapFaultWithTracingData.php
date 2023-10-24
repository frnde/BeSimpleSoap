<?php

namespace BeSimple\SoapClient;

use SoapFault;

class SoapFaultWithTracingData extends SoapFault
{
    private $soapResponseTracingData;

    public function __construct(SoapResponseTracingData $soapResponseTracingData, $code =0, $message ="")
    {
        $this->soapResponseTracingData = $soapResponseTracingData;
        parent::__construct($code, $message);
    }

    public function getSoapResponseTracingData(): SoapResponseTracingData
    {
        return $this->soapResponseTracingData;
    }
}
