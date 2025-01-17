<?php

/*
 * This file is part of the BeSimpleSoapCommon.
 *
 * (c) Christian Kerl <christian-kerl@web.de>
 * (c) Francis Besset <francis.besset@gmail.com>
 * (c) Andreas Schamberger <mail@andreass.net>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace BeSimple\SoapCommon;

use BeSimple\SoapCommon\AbstractSoapResponse;

/**
 * SOAP response filter interface.
 *
 * @author Christian Kerl <christian-kerl@web.de>
 */
interface SoapResponseFilterInterface
{
    /**
     * Modify SOAP response.
     *
     * @param AbstractSoapResponse $response SOAP response
     * @param int $attachmentType = SoapOptions::SOAP_ATTACHMENTS_TYPE_SWA|SoapOptions::ATTACHMENTS_TYPE_MTOM|SoapOptions::ATTACHMENTS_TYPE_BASE64
     */
    public function filterResponse(AbstractSoapResponse $response, $attachmentType);
}
