<?php

namespace Mark\PatternMatcher;

use Mark\PatternMatcher\Exception\NoMatch;

final class RegexMatcher implements Matcher
{
    /**
     *
     * @var string
     */
    private $pattern;

    /**
     *
     * @param string $pattern
     */
    public function __construct($pattern)
    {
        $this->pattern = $pattern;
    }

    /**
     *
     * @param string $text
     *
     * @return boolean
     */
    public function matches($text)
    {
        return (boolean) preg_match($this->pattern, $text);
    }

    /**
     *
     * @param string $text
     *
     * @throws NoMatch
     *
     * @return Result
     */
    public function first($text)
    {
        if (!preg_match($this->pattern, $text, $matches)) {
            throw new NoMatch;
        }

        return new Result($matches[0], array_slice($matches, 1));
    }

    /**
     *
     * @param string $text
     *
     * @return Results
     */
    public function all($text)
    {
        if (!preg_match_all($this->pattern, $text, $matches, PREG_SET_ORDER)) {
            throw new NoMatch;
        }

        return new Results(array_map([$this, 'buildResultFromMatches'], $matches));
    }

    /**
     *
     * @param array $matches
     *
     * @return Result
     */
    private function buildResultFromMatches($matches)
    {
        return new Result($matches[0], array_slice($matches, 1));
    }

    /**
     *
     * @return string A representation of the pattern
     */
    public function __toString()
    {
        return $this->pattern;
    }
}
