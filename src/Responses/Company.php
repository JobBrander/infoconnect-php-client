<?php namespace JobBrander\Clients\Responses;

class Company
{
    public function __construct(\stdClass $object)
    {
        foreach ($object as $key => $value) {
            $this->{$key} = $value;
        }
    }
}
