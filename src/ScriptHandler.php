<?php
/**
 * This file is part of the yannoff/composer-dotenv-handler project
 *
 * @copyright 2019 - Yannoff
 * @licence   MIT License
 * @author    Yannoff (https://github.com/yannoff)
 */

namespace Yannoff\DotenvHandler;

use Composer\Script\Event;

/**
 * Class ScriptHandler
 *
 * @package Yannoff\DotenvHandler
 */
class ScriptHandler
{
    /** @var string The key in extra where user can configure the script */
    const EXTRA_CONFIG_KEY = 'yannoff-dotenv-handler';

    /**
     * Main entry point of the script, hte method called by composer
     *
     * @param Event $event
     */
    public static function updateEnvFile(Event $event)
    {
        $extras = $event->getComposer()->getPackage()->getExtra();

        $processor = new Processor($event->getIO());

        $config = array_merge(self::getDefaults(), self::extractConfig($extras));

        $processor->processFile($config);
    }

    /**
     * Provide default config values
     *
     * @return array
     */
    protected static function getDefaults()
    {
        return [
            'file' => '.env',
            'dist-file' => '.env.dist',
            'keep-outdated' => true,
        ];
    }

    /**
     * Extract dotenv-handler config from the extra config section
     *
     * @param array $extras The whole composer.json "extra" section
     *
     * @return array The config or an empty array if no config found
     */
    protected static function extractConfig($extras)
    {
        if (array_key_exists(self::EXTRA_CONFIG_KEY, $extras)) {
            return $extras[self::EXTRA_CONFIG_KEY];
        }

        return [];
    }
}
