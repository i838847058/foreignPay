<?php

abstract class PaymentDao
{
    protected array $payOption;

    protected string $payName;

    protected array $result = [];

    protected int $status = 0;
}