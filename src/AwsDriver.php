<?php

/*
 * This file is part of Flarum.
 *
 * For detailed copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

namespace Flarum\Filesystem;

use Aws\S3\S3Client;
use League\Flysystem\AwsS3v3\AwsS3Adapter as S3Adapter;
use League\Flysystem\Filesystem as Flysystem;
use Flarum\Foundation\Config;
use Flarum\Settings\SettingsRepositoryInterface;
use Illuminate\Contracts\Filesystem\Cloud;
use League\Flysystem\FilesystemInterface;

class AwsDriver implements DriverInterface
{
    public function build(string $diskName, SettingsRepositoryInterface $settings, Config $config, array $localConfig): Cloud
    {
        return $this->adapt(new Flysystem(
            new S3Adapter(new S3Client([
                'credentials' => [
                    'key'    => $config['azure-config'][$diskName]['key'],
                    'secret' => $config['azure-config'][$diskName]['secret'],
                ],
                'region' => $config['azure-config'][$diskName]['region'],
                'version' => 'latest',
            ]), $config['azure-config'][$diskName]['bucket'], $config['azure-config'][$diskName]['root'])
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