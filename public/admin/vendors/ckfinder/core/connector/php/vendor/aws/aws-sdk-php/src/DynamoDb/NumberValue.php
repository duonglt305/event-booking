<?php
namespace Aws\DynamoDb;

use JsonSerializable;

/**
 * Special object to represent a DynamoDB Number (N) value.
 */
class NumberValue implements JsonSerializable
{
    /** @var string Number value. */
    private $value;

    /**
     * @param string|int|float $value A number value.
     */
    public function __construct($value)
    {
        $this->value = (string) $value;
    }

    public function jsonSerialize()
    {
        return $this->value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
