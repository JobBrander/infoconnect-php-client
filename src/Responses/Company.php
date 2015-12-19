<?php namespace JobBrander\Clients\Responses;

class Company
{
    public function __construct(\stdClass $object)
    {
        foreach ($object AS $key => $value) {
            $this->{$key} = $value;
        }
    }
}