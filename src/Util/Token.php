<?php

namespace Instagram\Util;

final class Token
{
    private const PARAM_REGEX = '/\("([a-zA-Z]+)",[0-9]+,"([a-zA-Z]+)",([0-9]+),([0-9]+),[0-9]+\)/';
    const URL_TOKEN_REGEX = '/https:\/\/d\.rapidcdn\.app\/snapinst\?token=[^&\'" <>\s]+/';
    const TOKEN_REGEX = '/token=([^&]+)/';

    /**
     * @return string|false
     */
    public static function extract(string $string)
    {
        if (!preg_match(self::PARAM_REGEX, $string, $matches)) {
            return false;
        }
        array_shift($matches);

        /* @var array{0:string,1:string,2:int,3:int} $matches */
        [$h, $n, $t, $e] = $matches;

        $r = '';
        for ($i = 0, $len = strlen($h); $i < $len; ++$i) {
            $s = '';
            while ($h[$i] !== $n[$e]) {
                $s .= $h[$i];
                ++$i;
            }
            for ($j = 0; $j < strlen($n); ++$j) {
                $s = str_replace($n[$j], (string) $j, $s);
            }
            $r .= chr((int) ((int) base_convert($s, $e, 10) - $t));
        }

        preg_match_all(self::URL_TOKEN_REGEX, $r, $urlMatches);

        $tokens = [];
        foreach ($urlMatches[0] as $url) {
            if (preg_match(self::TOKEN_REGEX, $url, $tokenMatches)) {
                $tokens[] = $tokenMatches[1];
            }
        }

        if (empty($tokens)){
            return false;
        }
        return $tokens[count($tokens) -1];
    }
}
