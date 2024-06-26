<?php

namespace Vikuraa\Helpers;

use DI\Container;

class FileImporter
{
    private Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function generateImportItemsCsv($stockLocations, $attributes)
    {
        // Encode the Byte-Order Mark (BOM) so that UTF-8 File headers display properly in Microsoft Excel
        $csvHeaders = pack('CCC', 0xef,0xbb,0xbf);
        $csvHeaders .= 'Id,Barcode,"Item Name",Category,"Supplier ID","Cost Price","Unit Price","Tax 1 Name","Tax 1 Percent","Tax 2 Name","Tax 2 Percent","Reorder Level",Description,"Allow Alt Description","Item has Serial Number",Image,HSN';

        $csvHeaders .= $this->generateStockLocationHeaders($stockLocations);
	    $csvHeaders .= $this->generateAttributeHeaders($attributes);

	return $csvHeaders;
    }

    public function generateStockLocationHeaders($locations)
    {
        $locationHeaders = '';

        foreach ($locations as $location) {
            $locationHeaders .= ',"' . $location . '"';
        }
        return $locationHeaders;
    }

    public function generateAttributeHeaders($attributeNames)
    {
        $attributeHeaders = '';
        
        unset($attributeNames[-1]);

        foreach ($attributeNames as $attributeName) {
            $attributeHeaders .= ',"attribute_' . $attributeName . '"';
        }

        return $attributeHeaders;
    }

    public function getCsvFile($fileName)
    {
        // TODO: current implementation reads the entire file in.  This is memory intensive for large files.
        // We may want to rework the CSV import feature to read the file in chunks, process it and continue.
        // It must be done in a way that does not significantly negatively affect performance.
        
        ini_set('auto_detect_line_endings', true);

        $csvRows = false;

        if (($csvFile = fopen($fileName,'r')) !== false) {

            $csvRows = [];

            //Skip Byte-Order Mark
            if ($this->bomExists($csvFile) === true) {
                fseek($csvFile, 3);
            }

            $headers = fgetcsv($csvFile);

            $security = $this->container->get(Security::class);

            while (($row = fgetcsv($csvFile)) !== false) {
                //Skip empty lines
                if ($row !== array(null)) {
                    $csv_rows[] = array_combine($headers, $security->xssClean($row));
                }
            }

            fclose($csvFile);
        }

        return $csvRows;
    }

    public function bomExists(&$fileHandle)
    {
        $result = false;
        $candidate = fread($fileHandle, 3);

        rewind($fileHandle);

        $bom = pack('CCC', 0xef, 0xbb, 0xbf);

        if (0 === strncmp($candidate, $bom, 3)) {
            $result = TRUE;
        }

        return $result;
    }
}