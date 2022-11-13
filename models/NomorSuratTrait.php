<?php

namespace app\models;

trait NomorSuratTrait
{
    /**
     * @return string
     */
    public function getNomorDisplay(): string
    {
        $nomor = explode('/', $this->nomor);
        return $nomor[0] . '-' . ($nomor[count($nomor) - 2]) . '-' . end($nomor);
    }
}