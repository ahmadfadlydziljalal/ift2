<?php

namespace app\components;

use League\Flysystem\AwsS3v3\AwsS3Adapter as BaseAwsS3Adapter;
use League\Flysystem\Util;


class AwsS3Adapter extends BaseAwsS3Adapter
{
    public function listContents($directory = '', $recursive = false): array
    {
        $prefix = $this->applyPathPrefix(rtrim($directory, '/') . '/');
        $options = ['Bucket' => $this->bucket, 'Prefix' => ltrim($prefix, '/')];

        if ($recursive === false) {
            $options['Delimiter'] = '';
        }

        $listing = $this->retrievePaginatedListing($options);
        $normalizer = [$this, 'normalizeResponse'];
        $normalized = array_map($normalizer, $listing);

        return Util::emulateDirectories($normalized);
    }
}