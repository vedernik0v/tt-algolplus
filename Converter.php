<?php

interface ConverterInterface
{
    public function Convert($value);
}

class IntConverter implements ConverterInterface
{
    public function Convert($value)
    {
        return (int)$value;
    }
}

class FloatConverter implements ConverterInterface
{
    public function Convert($value)
    {
        return (float)$value;
    }
}

class StringConverter implements ConverterInterface
{
    public function Convert($value)
    {
    	return trim((string)$value);
    }
}
