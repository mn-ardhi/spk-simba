<?php

namespace App\Traits;

trait UppercaseText
{
    public function setAttribute($key, $value)
    {
        if (is_string($value) && !in_array($key, ['password', 'email', 'username'])) {
            $value = strtoupper($value);
        }
        return parent::setAttribute($key, $value);
    }
}
