<?php

namespace BeSimple\SoapCommon;

/**
 * SoapKernel provides methods to pre- and post-process SoapRequests and SoapResponses using
 * chains of SoapRequestFilter and SoapResponseFilter objects (roughly following
 * the chain-of-responsibility pattern).
 *
 * @author Christian Kerl <christian-kerl@web.de>
 * @author Petr Bechyně <mail@petrbechyne.com>
 */
class SoapKernel
{
    /**
     * Applies all registered SoapRequestFilter to the given SoapRequest.
     *
     * @param AbstractSoapRequest $request Soap request
     * @param SoapRequestFilterInterface[]|SoapResponseFilterInterface[] $filters
     * @param int $attachmentType = SoapOptions::SOAP_ATTACHMENTS_TYPE_SWA|SoapOptions::ATTACHMENTS_TYPE_MTOM|SoapOptions::ATTACHMENTS_TYPE_BASE64
     * @return AbstractSoapRequest
     */
    public static function filterRequest(AbstractSoapRequest $request, array $filters, $attachmentType)
    {
        foreach ($filters as $filter) {
            if ($filter instanceof SoapRequestFilterInterface) {
                $request = $filter->filterRequest($request, $attachmentType);
            }
        }

        return $request;
    }

    /**
     * Applies all registered SoapResponseFilter to the given SoapResponse.
     *
     * @param AbstractSoapResponse $response SOAP response
     * @param SoapRequestFilterInterface[]|SoapResponseFilterInterface[] $filters
     * @param int $attachmentType = SoapOptions::SOAP_ATTACHMENTS_TYPE_SWA|SoapOptions::ATTACHMENTS_TYPE_MTOM|SoapOptions::ATTACHMENTS_TYPE_BASE64
     * @return \BeSimple\SoapClient\SoapResponse|\BeSimple\SoapServer\SoapResponse
     */
    public static function filterResponse(AbstractSoapResponse $response, array $filters, $attachmentType)
    {
        foreach ($filters as $filter) {
            if ($filter instanceof SoapResponseFilterInterface) {
                $response = $filter->filterResponse($response, $attachmentType);
            }
        }

        return $response;
    }
}
