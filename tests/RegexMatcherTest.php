<?php

namespace Mark\PatternMatcher\Tests\Pattern;

use Mark\PatternMatcher\RegexMatcher;
use Mark\PatternMatcher\Result;
use Mark\PatternMatcher\Exception\NoMatch;

final class RegexMatcherTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     * @dataProvider matchesProvider
     */
    public function testMatches($pattern, $text, $isMatching)
    {
        $matcher = new RegexMatcher($pattern);
        $this->assertEquals($isMatching, $matcher->matches($text));
    }

    /**
     *
     * @dataProvider firstProvider
     */
    public function testFirst($pattern, $text, $sequence, $subsequences)
    {
        $matcher = new RegexMatcher($pattern);
        $result = $matcher->first($text);

        $this->assertEquals($sequence, $result->getSequence());
        $this->assertEquals($subsequences, $result->getSubsequences());
    }

    /**
     *
     * @dataProvider firstProvider
     * @expectedException Mark\PatternMatcher\Exception\NoMatch
     */
    public function testNoMatchfirst($pattern, $text)
    {
        $matcher = new RegexMatcher($pattern);
        $result = $matcher->first($text);
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

    public function matchesProvider()
    {
        return [
            ['/^.+station$/', 'space station', true],
            ['/^.*station$/', 'space station', true],
            ['/^.?station$/', 'space station', false],
            ['/.?station/',   'space station', true],
        ];
    }

    public function firstProvider()
    {
        return [
            ['/^(.+)station$/', 'space station', 'space station', ['space ']],
            ['/^(.*)station$/', 'space station', 'space station', ['space ']],
            ['/(.?)station/',   'space station', 'space station', ['space ']],
        ];
    }

    public function firstNoMatchProvider()
    {
        return [
            ['/^(.?)station$/', 'space station'],
        ];
    }
}
