<?php

namespace Paper\PatternMatcher;

final class WildcardMatcher extends RegexMatcher
{
    const SAFE_STAR          = '__SAFE_STAR_WILCARD__';
    const SAFE_QUESTION_MARK = '__SAFE_QUESTION_MARK_WILCARD__';

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

        parent::__construct($this->compilePatternToRegex($pattern));
    }

    /**
     *
     * @param type $pattern
     *
     * @return string Regex pattern
     */
    private function compilePatternToRegex($pattern)
    {
        // Escape wildcards
        $safePattern = strtr($pattern, [
            '*' => self::SAFE_STAR,
            '?' => self::SAFE_QUESTION_MARK,
        ]);

        // Escape preg special chars
        $escapedPattern = preg_quote($safePattern);

        // Match wildcards
        return '#^'.strtr($escapedPattern, [
            self::SAFE_STAR => '.*',
            self::SAFE_QUESTION_MARK => '.',
        ]).'$#';
    }
}