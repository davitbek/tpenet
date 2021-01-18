<?php

function humanize($string, $delimiter = '_', $isUcFirst = true)
{
    $string  = Str::slug($string, '_');
    $result = explode(' ', str_replace($delimiter, ' ', $string));
    foreach ($result as &$word) {
        if ($isUcFirst) {
            $word = mb_strtoupper(mb_substr($word, 0, 1)) . mb_substr($word, 1);
        } else {
            $word = mb_substr($word, 0);
        }
    }
    $result = implode(' ', $result);

    return $result;
}
