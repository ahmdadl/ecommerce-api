<?php

namespace Modules\Payments\Interfaces;

interface Payable
{
    /**
     * payment is completed
     */
    public function paymentCompleted(): void;

    /**
     * payment failed
     */
    public function paymentFailed(): void;
}
