<?php

require_once('Converter.php');

/**/
final class MyArray
{
    private $data = array();

    public function __construct( $file=null, $separator=",", $convertors=[])
    {
        if (! empty($file)) {
            if (empty($convertors)) {
                $convertors = [ 'Id' => new IntConverter(), 'Price' => new FloatConverter(), 'Name' => new StringConverter(), 'Tax' => new IntConverter()];
            }

            $this->Import($file, $separator, $convertors);

            // return $this;
        } else {
            throw new Exception("File '$file' not found");
        }
    }

    public function import($file, $separator = ",", $convertors = array())
    {
        $this->data = array();

        if (!file_exists($file) || !is_file($file))
            throw new Exception('File not found');


        $handle = fopen($file, 'r');

        $headerRead = false;
        $map        = array();
        while (($data = fgetcsv($handle, 1000, $separator)) !== FALSE)
        {
            if (count($data) < 2)
            {
                if (!reset($data))
                    continue;
            }

            if (!$headerRead)
            {
                $map        = $data;
                $headerRead = true;
                continue;
            }

            $row = array();
            foreach($data as $key => $value)
            {
                if (!isSet($map[$key]))
                    continue;

                $_key      = $map[$key];
                $convertor = (isSet($convertors[$_key]))
                            ? $convertors[$_key]
                            : null;

                $row[$_key] =  ($convertor instanceof ConverterInterface)
                            ? $convertor->Convert($value)
                            : $value;
            }

            if (!empty($row))
                $this->data[] = $row;
        }

        fclose($handle);

        return $this;
    }

    public function getAll()
    {
        return $this->data;
    }

    public function getFirst()
    {
        $items = $this->data;
        reset($items);
        return current($items);
    }

    public function getItemsKeys()
    {
        return array_keys($this->getFirst());
    }

    public function sortByPrice($desc = false)
    {
        $data = $this->data;

        usort($data, array($this, $desc ? 'desc' : "asc"));

        $this->data = $data;

        return $this;
    }

    // Извлекает все значения для заданного ключа
    public function pluck($key)
    {
        $result = [];

        $keys = $this->getItemsKeys();
        if ( ! in_array($key, $keys) ) {
            return $result;
        }

        foreach ($this->data as $item) {
            try {
                $value = $item[$key];
            } catch (Exception $e) {
                $value = null;
            }

            array_push($result, $value);
        }

        return $result;
    }

    // Возвращает первые N элементов
    public function getLimit($limit = 5)
    {
        $limit = (int)$limit;
        $data  = $this->data;

        if ($limit > 0)
        {
            $data = array_chunk($data, $limit);
            $data = array_shift($data);

            return (is_array($data))
                    ? $data
                    : array();
        }

        return array();
    }

    private function asc($value1, $value2)
    {
        $value1 = (is_array($value1))
                ? (object)$value1
                : $value1;

        $value2 = (is_array($value2))
                ? (object)$value2
                : $value2;

        if ($value1->Price == $value2->Price)
            return 0;

        return ($value1->Price < $value2->Price) ? -1 : 1;
    }

    private function desc($value1, $value2)
    {
        $value1 = (is_array($value1))
                ? (object)$value1
                : $value1;

        $value2 = (is_array($value2))
                ? (object)$value2
                : $value2;

        if ($value1->Price == $value2->Price)
            return 0;

        return ($value1->Price > $value2->Price) ? -1 : 1;
    }
}
