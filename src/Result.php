<?php

namespace Paper\PatternMatcher;

use Countable, ArrayAccess, DomainException;

final class Result implements Countable, ArrayAccess
{
    /**
     *
     * @var string
     */
    private $sequence;

    /**
     *
     * @var string[]
     */
    private $subsequences;

    /**
     *
     * @param string $sequence
     * @param array $subsequences
     */
    public function __construct($sequence, array $subsequences = [])
    {
        $this->sequence = $sequence;
        $this->subsequences = $subsequences;
    }

    /**
     * The string sequence matching the pattern
     *
     * @return string
     */
    public function getSequence()
    {
        return $this->sequence;
    }

    /**
     * Return all matching subsequences
     *
     * @param string|int $index
     * @param string $default
     *
     * @return string
     */
    public function getSubsequence($index, $default = null)
    {
        if (!key_exists($index, $this->subsequences)) {
            return $default;
        }

        return $this->subsequences[$index];
    }

    /**
     * Return all matching subsequences
     *
     * @return string[]
     */
    public function getSubsequences()
    {
        return $this->subsequences;
    }

    /**
     *
     * @alias getSequence()
     *
     * @return string
     */
    public function __toString()
    {
        return $this->sequence;
    }

    // Countable implementation

    /**
     *
     * @return int
     */
    public function count()
    {
        return count($this->subsequences);
    }

    // ArrayAccess implementation

    /**
     *
     * @param string $offset
     *
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return key_exists($offset, $this->subsequences);
    }

    /**
     *
     * @param string $offset
     *
     * @return string
     */
    public function offsetGet($offset)
    {
        return $this->subsequences[$offset];
    }

    /**
     *
     * @param string $offset
     * @param mixed $value
     *
     * @throws DomainException
     */
    public function offsetSet($offset, $value)
    {
        throw new DomainException(__CLASS__.'::'.__METHOD__.' not implemented.');
    }

    /**
     *
     * @param string $offset
     *
     * @throws DomainException
     */
    public function offsetUnset($offset)
    {
        throw new DomainException(__CLASS__.'::'.__METHOD__.' not implemented.');
    }
}
