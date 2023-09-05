<?php

namespace Betacoders\Bkash;

use ReflectionClass;
use ReflectionProperty;

class Arrayable
{
    private $readable;

    public function __construct(array $data)
    {
        $cls = new ReflectionClass($this);
        $this->readable = array_map(function ($property){
            return $property->getName();
        }, $cls->getProperties(ReflectionProperty::IS_PROTECTED));

        foreach ($data as $key => $value){
            if (($cls->hasProperty($key)) && in_array($key, $this->readable)) $this->$key = $value;
        }
    }

    public function __get($property){
        if (in_array($property, $this->readable)){
            return $this->$property;
        }
    }

    public function toArray(){
        $data = [];
        foreach ($this->readable as $value) {
            if ($this->$value instanceof Arrayable) {
                $data[$value] = $this->$value->toArray();
            } elseif (!empty($this->$value)) {
                $data[$value] = $this->$value;
            }
        }
        return $data;
    }

}
