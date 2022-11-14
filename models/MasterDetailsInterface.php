<?php

namespace app\models;

interface MasterDetailsInterface
{

    public function createWithDetails(array $modelsDetail): array;

    public function updateWithDetails(array $modelsDetail, array $deletedDetailsID): array;
}