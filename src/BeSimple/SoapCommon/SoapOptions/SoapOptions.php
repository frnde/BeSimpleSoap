<?php

namespace BeSimple\SoapCommon\SoapOptions;

use BeSimple\SoapCommon\Cache;
use BeSimple\SoapCommon\ClassMap;
use BeSimple\SoapCommon\Converter\TypeConverterCollection;
use BeSimple\SoapCommon\Helper;
use BeSimple\SoapCommon\SoapOptions\SoapFeatures\SoapFeatures;

class SoapOptions
{
    public final const SOAP_VERSION_1_1 = \SOAP_1_1;
    public final const SOAP_VERSION_1_2 = \SOAP_1_2;
    public final const SOAP_CONNECTION_KEEP_ALIVE_ON = true;
    public final const SOAP_CONNECTION_KEEP_ALIVE_OFF = false;
    public final const SOAP_ENCODING_UTF8 = 'UTF-8';
    public final const SOAP_SINGLE_ELEMENT_ARRAYS_OFF = 0;
    public final const SOAP_CACHE_TYPE_NONE = Cache::TYPE_NONE;
    public final const SOAP_CACHE_TYPE_DISK = Cache::TYPE_DISK;
    public final const SOAP_CACHE_TYPE_MEMORY = Cache::TYPE_MEMORY;
    public final const SOAP_CACHE_TYPE_DISK_MEMORY = Cache::TYPE_DISK_MEMORY;
    public final const SOAP_ATTACHMENTS_OFF = null;
    public final const SOAP_ATTACHMENTS_TYPE_BASE64 = Helper::ATTACHMENTS_TYPE_BASE64;
    public final const SOAP_ATTACHMENTS_TYPE_MTOM = Helper::ATTACHMENTS_TYPE_MTOM;
    public final const SOAP_ATTACHMENTS_TYPE_SWA = Helper::ATTACHMENTS_TYPE_SWA;

    /**
     * @param int $soapVersion = SoapOptions::SOAP_VERSION_1_1|SoapOptions::SOAP_VERSION_1_2
     * @param string $encoding = SoapOptions::SOAP_ENCODING_UTF8
     * @param bool $connectionKeepAlive = SoapOptions::SOAP_CONNECTION_KEEP_ALIVE_ON|SoapOptions::SOAP_CONNECTION_KEEP_ALIVE_OFF
     * @param SoapFeatures $soapFeatures
     * @param string $wsdlFile
     * @param int $wsdlCacheType = SoapOptions::SOAP_CACHE_TYPE_NONE|SoapOptions::SOAP_CACHE_TYPE_MEMORY|SoapOptions::SOAP_CACHE_TYPE_DISK|SoapOptions::SOAP_CACHE_TYPE_DISK_MEMORY
     * @param ClassMap $classMap
     * @param TypeConverterCollection $typeConverterCollection
     * @param string|null $wsdlCacheDir = null
     * @param int|null $attachmentType = SoapOptions::SOAP_ATTACHMENTS_OFF|SoapOptions::SOAP_ATTACHMENTS_TYPE_SWA|SoapOptions::ATTACHMENTS_TYPE_MTOM|SoapOptions::ATTACHMENTS_TYPE_BASE64
     */
    public function __construct(
        private $soapVersion,
        private $encoding,
        private $connectionKeepAlive,
        private SoapFeatures $soapFeatures,
        private $wsdlFile,
        private $wsdlCacheType,
        private ClassMap $classMap,
        private TypeConverterCollection $typeConverterCollection,
        private ?string $wsdlCacheDir =null,
        private $attachmentType =null
    ) {
    }

    public function getSoapVersion()
    {
        return $this->soapVersion;
    }

    public function getEncoding()
    {
        return $this->encoding;
    }

    public function isConnectionKeepAlive()
    {
        return $this->connectionKeepAlive;
    }

    public function getWsdlFile()
    {
        return $this->wsdlFile;
    }

    public function hasWsdlCacheDir()
    {
        return $this->wsdlCacheDir !== null;
    }

    public function getWsdlCacheDir()
    {
        return $this->wsdlCacheDir;
    }

    public function isWsdlCached()
    {
        return $this->wsdlCacheType !== self::SOAP_CACHE_TYPE_NONE;
    }

    public function getWsdlCacheType()
    {
        return $this->wsdlCacheType;
    }

    public function hasAttachments()
    {
        return $this->attachmentType !== self::SOAP_ATTACHMENTS_OFF;
    }

    public function getAttachmentType()
    {
        return $this->attachmentType;
    }

    public function getSoapFeatures()
    {
        return $this->soapFeatures;
    }

    public function getClassMap()
    {
        return $this->classMap;
    }

    public function getTypeConverterCollection()
    {
        return $this->typeConverterCollection;
    }

    public function toArray()
    {
        $optionsAsArray = [
            'soap_version' => $this->getSoapVersion(),
            'encoding' => $this->getEncoding(),
            'features' => $this->getSoapFeatures()->getFeaturesSum(),
            'wsdl' => $this->getWsdlFile(),
            'cache_wsdl' => $this->getWsdlCacheType(),
            'classmap' => $this->getClassMap()->getAll(),
            'typemap' => $this->getTypeConverterCollection()->getTypemap(),
            'keep_alive' => $this->isConnectionKeepAlive(),
        ];
        if ($this->hasWsdlCacheDir()) {
            $optionsAsArray['wsdl_cache_dir'] = $this->getWsdlCacheDir();
        }

        return $optionsAsArray;
    }
}
