<?php
/**
 * @link https://github.com/creocoder/yii2-flysystem
 * @copyright Copyright (c) 2015 Alexander Kochetov
 * @license http://opensource.org/licenses/BSD-3-Clause
 */

namespace app\components;

use Aws\S3\S3Client;
use creocoder\flysystem\AwsS3Filesystem as BaseAwsS3Filesystem;
use League\Flysystem\AwsS3v3\AwsS3Adapter;

/**
 * AwsS3Filesystem
 *
 * @author Alexander Kochetov <creocoder@gmail.com>
 */
class AwsS3Filesystem extends BaseAwsS3Filesystem
{


    /**
     * @return AwsS3Adapter|\app\components\AwsS3Adapter
     */
    protected function prepareAdapter(): AwsS3Adapter|\app\components\AwsS3Adapter
    {
        $config = [];

        if ($this->credentials === null) {
            $config['credentials'] = ['key' => $this->key, 'secret' => $this->secret];
        } else {
            $config['credentials'] = $this->credentials;
        }


        if ($this->pathStyleEndpoint === true) {
            $config['use_path_style_endpoint'] = true;
        }

        if ($this->region !== null) {
            $config['region'] = $this->region;
        }

        if ($this->baseUrl !== null) {
            $config['base_url'] = $this->baseUrl;
        }

        if ($this->endpoint !== null) {
            $config['endpoint'] = $this->endpoint;
        }

        $config['version'] = (($this->version !== null) ? $this->version : 'latest');

        $client = new S3Client($config);

        return new \app\components\AwsS3Adapter($client, $this->bucket, $this->prefix, $this->options, $this->streamReads);
    }
}