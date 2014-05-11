<?php

class UtilCsv
{
    /**
     * @param  array $data
     * @param string $path
     * @param $filename
     * @return bool
     */
    public static function createCsv(array $data, $path, $filename)
    {
        if(!file_exists($path))
            mkdir($path, 0770, true);

        $fp = fopen($path . DIRECTORY_SEPARATOR . $filename , 'w');

        if(!$fp)
        {
            return false;
        }

        foreach ($data as $row)
        {
            fputcsv($fp, $row);
        }

        fclose($fp);

        return true;
    }
}
