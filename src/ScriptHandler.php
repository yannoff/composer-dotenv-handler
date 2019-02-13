<?php

namespace Yannoff\DotenvHandler;

use Composer\Script\Event;

class ScriptHandler
{
    public static function updateEnvFile(Event $event)
    {
        //$extras = $event->getComposer()->getPackage()->getExtra();

        $processor = new Processor($event->getIO());

        $config = [
            'file' => '.env',
            'dist-file' => '.env.dist',
        ];

        $processor->processFile($config);
    }
}
