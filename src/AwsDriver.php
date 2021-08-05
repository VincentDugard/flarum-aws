<?php

namespace VincentDugard\FlarumAws;

use Aws\S3\S3Client;
use League\Flysystem\AwsS3v3\AwsS3Adapter as S3Adapter;
use League\Flysystem\Filesystem as Flysystem;
use Flarum\Foundation\Config;
use Flarum\Settings\SettingsRepositoryInterface;
use Illuminate\Contracts\Filesystem\Cloud;
use League\Flysystem\FilesystemInterface;
use Flarum\Filesystem\DriverInterface;

class AwsDriver implements DriverInterface
{
    public function build(string $diskName, SettingsRepositoryInterface $settings, Config $config, array $localConfig): Cloud
    {
        return $this->adapt(new Flysystem(
            new S3Adapter(new S3Client([
                'credentials' => [
                    'key'    => $settings->get("flarum-aws.key"),
                    'secret' => $settings->get("flarum-aws.secret"),
                ],
                'region' => $settings->get("flarum-aws.region"),
                'version' => 'latest',
            ]), $settings->get("flarum-aws.bucket"), $diskName)
        ));
    }

    /**
     * Adapt the filesystem implementation.
     *
     * @param  \League\Flysystem\FilesystemInterface  $filesystem
     * @return \Illuminate\Contracts\Filesystem\Filesystem
     */
    protected function adapt(FilesystemInterface $filesystem)
    {
        return new \Illuminate\Filesystem\FilesystemAdapter($filesystem);
    }
}