<?php

namespace App\Asset;

use Symfony\Component\Asset\VersionStrategy\VersionStrategyInterface;
use Symfony\Component\Process\Process;

final class GitVersionStrategy implements VersionStrategyInterface
{
    private static $hash;

    public function getVersion($path)
    {
        if (self::$hash !== null) {
            return self::$hash;
        }

        $process = Process::fromShellCommandline('git rev-parse --short HEAD');
        $process->mustRun();

        self::$hash = $process->getOutput();

        return self::$hash;
    }

    public function applyVersion($path)
    {
        $version = $this->getVersion($path);

        $versionized = sprintf('%s?%s', $path, $version);

        return $versionized;
    }
}
