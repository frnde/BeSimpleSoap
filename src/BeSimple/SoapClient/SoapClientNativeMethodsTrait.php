<?php

namespace BeSimple\SoapClient;

use BeSimple\SoapBundle\Soap\SoapAttachment;
use BeSimple\SoapClient\SoapOptions\SoapClientOptions;
use BeSimple\SoapCommon\SoapOptions\SoapOptions;
use Exception;

trait SoapClientNativeMethodsTrait
{
    protected $soapClientOptions;
    /** @var SoapAttachment[] */
    private $soapAttachmentsOnRequestStorage;
    /** @var SoapResponse */
    private $soapResponseStorage;

    /**
     * @param string $functionName
     * @param array $arguments
     * @param array|null $options
     * @param SoapAttachment[] $soapAttachments
     * @param null $inputHeaders
     * @param array|null $outputHeaders
     * @return SoapResponse
     */
    abstract public function soapCall(
        string $functionName,
        array $arguments,
        array $soapAttachments =[],
        array $options =null,
        $inputHeaders =null,
        array &$outputHeaders =null
    ): SoapResponse;

    /**
     * @param mixed $request Request object
     * @param string $location Location
     * @param string $action SOAP action
     * @param int $version SOAP version
     * @param SoapAttachment[] $soapAttachments SOAP attachments array
     * @return SoapResponse
     */
    abstract protected function performSoapRequest(
        $request,
        $location,
        $action,
        $version,
        array $soapAttachments =[]
    ): SoapResponse;

    /**
     * @return SoapClientOptions
     */
    abstract protected function getSoapClientOptions(): SoapClientOptions;

    /**
     * @return SoapOptions
     */
    abstract protected function getSoapOptions(): SoapOptions;

    /**
     * Avoid using __call directly, it's deprecated even in \SoapClient.
     *
     * @deprecated
     */
    public function __call($function_name, $arguments): mixed
    {
        throw new Exception(
            message: 'The __call method is deprecated. Use __soapCall/soapCall  instead.'
        );
    }

    /**
     * Using __soapCall returns only response string, use soapCall instead.
     *
     * @param string $function_name
     * @param array $arguments
     * @param array|null $options
     * @param null $input_headers
     * @param array|null $output_headers
     * @return string
     */
    public function __soapCall(
        $function_name,
        $arguments,
        $options =null,
        $input_headers =null,
        &$output_headers =null
    ): string {
        return $this->soapCall(
            $function_name,
            $arguments,
            $options,
            $input_headers,
            $output_headers
        )->getResponseContent();
    }

    /**
     * This is not performing any HTTP requests, but it is getting data from SoapClient that are needed for this Client
     *
     * @param string $request  Request string
     * @param string $location Location
     * @param string $action   SOAP action
     * @param int    $version  SOAP version
     * @param int    $oneWay   0|1
     *
     * @return string
     */
    public function __doRequest($request, $location, $action, $version, $oneWay =0): string
    {
        $soapResponse = $this->performSoapRequest(
            $request,
            $location,
            $action,
            $version,
            $this->getSoapAttachmentsOnRequestFromStorage()
        );

        $this->setSoapResponseToStorage($soapResponse);

        return $soapResponse->getResponseContent();
    }

    /** @deprecated */
    public function __getLastRequestHeaders(): ?string
    {
        $this->checkTracing();

        throw new Exception(
            message: 'The __getLastRequestHeaders method is now deprecated. ' .
            'Use callSoapRequest instead and get the tracing information from SoapResponseTracingData.'
        );
    }

    /** @deprecated */
    public function __getLastRequest(): ?string
    {
        $this->checkTracing();

        throw new Exception(
            message: 'The __getLastRequest method is now deprecated. ' .
            'Use callSoapRequest instead and get the tracing information from SoapResponseTracingData.'
        );
    }

    /** @deprecated */
    public function __getLastResponseHeaders(): ?string
    {
        $this->checkTracing();

        throw new Exception(
            message: 'The __getLastResponseHeaders method is now deprecated. ' .
            'Use callSoapRequest instead and get the tracing information from SoapResponseTracingData.'
        );
    }

    /** @deprecated */
    public function __getLastResponse(): ?string
    {
        $this->checkTracing();

        throw new Exception(
            message: 'The __getLastResponse method is now deprecated. ' .
            'Use callSoapRequest instead and get the tracing information from SoapResponseTracingData.'
        );
    }

    private function checkTracing(): void
    {
        if ($this->getSoapClientOptions()->getTrace() === false) {
            throw new Exception(message: 'SoapClientOptions tracing disabled, turn on trace attribute');
        }
    }

    private function setSoapResponseToStorage(SoapResponse $soapResponseStorage): void
    {
        $this->soapResponseStorage = $soapResponseStorage;
    }

    /**
     * @param SoapAttachment[] $soapAttachments
     */
    private function setSoapAttachmentsOnRequestToStorage(array $soapAttachments): void
    {
        $this->soapAttachmentsOnRequestStorage = $soapAttachments;
    }

    private function getSoapAttachmentsOnRequestFromStorage(): array
    {
        $soapAttachmentsOnRequest = $this->soapAttachmentsOnRequestStorage;
        $this->soapAttachmentsOnRequestStorage = null;

        return $soapAttachmentsOnRequest;
    }

    private function getSoapResponseFromStorage(): ?SoapResponse
    {
        $soapResponse = $this->soapResponseStorage;
        $this->soapResponseStorage = null;

        return $soapResponse;
    }
}
