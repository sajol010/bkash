<?php

namespace Betacoders\Bkash;

class Token extends Arrayable
{

    protected $app_key;
    protected $app_secret;
    public function __construct(array $data)
    {
        parent::__construct($data);
    }


}
