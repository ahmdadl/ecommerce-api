<?php

namespace Modules\Wallets\ValueObjects;

final class WalletBalance
{
    public function __construct(
        public float $available,
        public float $pending,
        public float $total
    ) {}

    // Optional: Add validation logic
    public static function validate(array $data): void
    {
        if (!isset($data["available"]) || !is_numeric($data["available"])) {
            throw new \InvalidArgumentException(
                "Available must be a numeric value."
            );
        }

        if (!isset($data["pending"]) || !is_numeric($data["pending"])) {
            throw new \InvalidArgumentException(
                "Pending must be a numeric value."
            );
        }

        if (!isset($data["total"]) || !is_numeric($data["total"])) {
            throw new \InvalidArgumentException(
                "Total must be a numeric value."
            );
        }

        if ($data["available"] + $data["pending"] !== $data["total"]) {
            throw new \InvalidArgumentException(
                "Total must be sum of available and pending."
            );
        }
    }

    // Convert the object to an array
    public function toArray(): array
    {
        return [
            "available" => $this->available,
            "pending" => $this->pending,
            "total" => $this->total,
        ];
    }

    // Create a Totals object from an array
    public static function fromArray(array $data): self
    {
        self::validate($data);

        return new self($data["available"], $data["pending"], $data["total"]);
    }

    /**
     * generate default cart totals
     */
    public static function default(): self
    {
        return new self(0, 0, 0);
    }

    /**
     * turn to string
     * @return string
     */
    public function __toString(): string
    {
        return (string) json_encode($this->toArray());
    }

    public function credit(float $amount): self
    {
        return new self(
            $this->available + $amount,
            $this->pending,
            $this->total + $amount
        );
    }

    public function creditPending(float $amount): self
    {
        return new self(
            $this->available,
            $this->pending + $amount,
            $this->total + $amount
        );
    }

    public function debit(float $amount): self
    {
        self::validateAmountLte($amount, $this->available);
        self::validateAmountLte($amount, $this->total);

        return new self(
            $this->available - $amount,
            $this->pending,
            $this->total - $amount
        );
    }

    public function debitPending(float $amount): self
    {
        self::validateAmountLte($amount, $this->available);

        return new self(
            $this->available - $amount,
            $this->pending + $amount,
            $this->total
        );
    }

    public function completePendingCredit(float $amount): self
    {
        self::validateAmountLte($amount, $this->pending);

        return new self(
            $this->available + $amount,
            $this->pending - $amount,
            $this->total
        );
    }

    public function cancelPendingCredit(float $amount): self
    {
        self::validateAmountLte($amount, $this->pending);
        self::validateAmountLte($amount, $this->total);

        return new self(
            $this->available,
            $this->pending - $amount,
            $this->total - $amount
        );
    }

    public function completePendingDebit(float $amount): self
    {
        self::validateAmountLte($amount, $this->total);
        self::validateAmountLte($amount, $this->pending);

        return new self(
            $this->available,
            $this->pending - $amount,
            $this->total - $amount
        );
    }

    public function cancelPendingDebit(float $amount): self
    {
        self::validateAmountLte($amount, $this->pending);

        return new self(
            $this->available + $amount,
            $this->pending - $amount,
            $this->total
        );
    }

    public static function validateNonNegative(float $amount): void
    {
        if ($amount < 0) {
            throw new \InvalidArgumentException("Amount must be non-negative.");
        }
    }

    public static function validateAmountGte(
        float $amount,
        float $checkAgainst
    ): void {
        if ($amount < $checkAgainst) {
            throw new \InvalidArgumentException(
                "Amount must be greater than other."
            );
        }
    }

    public static function validateAmountLte(
        float $amount,
        float $checkAgainst
    ): void {
        if ($amount > $checkAgainst) {
            throw new \InvalidArgumentException(
                "Amount must be less than other."
            );
        }
    }
}
