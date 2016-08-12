<?php

namespace Mark\PatternMatcher\Pattern;

use Countable, IteratorAggregate, ArrayIterator;

/**
 * Collection of Result
 */
final class Results implements Countable, IteratorAggregate
{
    /**
     *
     * @var Result[]
     */
    private $results;

    /**
     *
     * @param Result[] $results
     */
    public function __construct(array $results)
    {
        $this->results = $results;
    }

    /**
     *
     * @return Result[]
     */
    public function toArray()
    {
        return $this->results;
    }

    // Countable implementation

    /**
     *
     * @return int
     */
    public function count()
    {
        return count($this->results);
    }

    // IteratorAggregate implementation

    public function getIterator()
    {
        return new ArrayIterator($this->results);
    }
}
