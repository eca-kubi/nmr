<?php


trait InitializeProperties
{
    public function initialize(?array $properties){
        if (is_array($properties))
        foreach ($properties as $property => $value) {
            if (property_exists($this, $property))
            $this->{$property} = $value;
        }
    }

    public function setProperties(array $properties)
    {
        $this->initialize($properties);
        return $this;
    }

    public function removeProperties(array $properties)
    {
        foreach ($properties as $property) {
            unset($this->$property);
        }
        return $this;
    }
}
