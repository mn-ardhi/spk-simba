<?php

namespace App\Traits;

trait UppercaseText
{
    protected static function bootUppercaseText()
    {
        static::saving(function ($model) {
            // Daftar kolom yang TIDAK BOLEH dikapitalkan
            $except = [
                'status_berkas', 
                'file_berkas', 
                'bukti_sertifikat', 
                'email', 
                'password'
            ];

            foreach ($model->getAttributes() as $key => $value) {
                if (is_string($value) && !in_array($key, $except)) {
                    $model->{$key} = strtoupper($value);
                }
            }
        });
    }
}