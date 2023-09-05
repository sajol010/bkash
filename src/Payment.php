<?php

namespace Betacoders\Bkash;

class Payment extends Arrayable
{
    protected $amount;
    protected $currency = 'BDT';
    protected $intent = 'sale';
    protected $merchantInvoiceNumber;
    protected $merchantAssociationInfo;

    public function __construct(array $data)
    {
        parent::__construct($data);
    }

    public function create(){
        $payloadData = $this->toArray();

    }
}
