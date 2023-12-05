<?php

abstract class PaymentDao
{
    protected array $payOption;

    protected string $payName;

    protected string $msg;

    protected string $apiMsg;

    protected array $result = [];

    protected int $status = 0;

    private const STATUS_MSG = [
        2 => '支付服务重试',
        1 => '支付服务成功',
        0 => '支付服务暂停',
        -1 => '支付服务不存在',
        -2 => '支付服务处理失败',
    ];

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @return array
     */
    public function getResult(): array
    {
        return $this->result;
    }

    /**
     * @return string
     */
    public function getPayName(): string
    {
        return $this->payName;
    }

    /**
     * @param string $payName
     */
    public function setPayName(string $payName): void
    {
        $this->payName = $payName;
    }

    /**
     * @return array
     */
    public function getPayOption(): array
    {
        return $this->payOption;
    }

    /**
     * @param array $payOption
     */
    public function setPayOption(array $payOption): void
    {
        $this->payOption = $payOption;
    }

    /**
     * @return string
     */
    public function getMsg(): string
    {
        return self::STATUS_MSG[$this->status];
    }

    public function createOrUpdatePaymentOrder(): bool
    {

        return true;
    }

    /**
     * @return string
     */
    public function getApiMsg(): string
    {
        return $this->apiMsg;
    }
}