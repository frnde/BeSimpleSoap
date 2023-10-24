<?php

namespace BeSimple\SoapCommon\Mime;

use BeSimple\SoapBundle\Soap\SoapAttachment;

class PartFactory
{
    public static function createFromSoapAttachment(SoapAttachment $attachment)
    {
        return new AbstractPart(
            $attachment->getContent(),
            AbstractPart::CONTENT_TYPE_PDF,
            AbstractPart::CHARSET_UTF8,
            AbstractPart::ENCODING_BINARY,
            $attachment->getId()
        );
    }

    /**
     * @param SoapAttachment[] $attachments SOAP attachments
     * @return AbstractPart[]
     */
    public static function createAttachmentParts(array $attachments =[])
    {
        $parts = [];
        foreach ($attachments as $attachment) {
            $parts[] = self::createFromSoapAttachment($attachment);
        }

        return $parts;
    }
}
