<?php
/**
 * This file is part of the yannoff/composer-dotenv-handler project
 *
 * @copyright 2019 - Yannoff
 * @licence   MIT License
 * @author    Yannoff (https://github.com/yannoff)
 */

namespace Yannoff\DotenvHandler\Config;

/**
 * Class Config
 * Helper class for config values
 *
 * @package Yannoff\DotenvHandler\Config
 */
abstract class Config
{
    const OPTION_BEHAVIOR = 'behavior';
    const BEHAVIOR_FLEX = 'flex';
    const BEHAVIOR_NORMAL = 'normal';

    const DEFAULT_APPENV = 'local';

    /**
     * Holds the configuration option values
     *
     * @var array
     */
    protected $config = [];

    /**
     * Getter for the distribution filename
     *
     * @return string
     */
    abstract public function getDistFile();

    /**
     * Getter for the real dotenv filename
     *
     * @return mixed|string
     */
    abstract public function getRealFile();

    /**
     * Config constructor.
     *
     * @param array $options
     */
    public function __construct($options = [])
    {
        $this->set($options);
    }

    /**
     * Check if the script was configured as flex behavior mode
     *
     * @return bool
     */
    public function isFlex()
    {
        return (self::BEHAVIOR_FLEX === $this->config['behavior']);
    }

    /**
     * Getter for the "keep-outdated" option
     *
     * @return bool
     */
    public function keepOutdated()
    {
        return (bool) $this->config['keep-outdated'];
    }

    /**
     * Try to fetch the APP_ENV then ENV variable passed at runtime
     * If none is set, fallback to the defaults, i.e 'local'
     *
     * @return string
     */
    protected function getExecutionEnv()
    {
        foreach (['APP_ENV', 'ENV'] as $envvar) {
            $env = getenv($envvar);
            if (false !== $env) {
                return $env;
            }
        }

        return self::DEFAULT_APPENV;
    }

    /**
     * Merge user-defined config values with the defaults
     *
     * @param array $options
     */
    protected function set($options = [])
    {
        $defaults = $this->getDefaults();
        $this->config = array_merge($defaults, $options);
    }

    /**
     * Provide default config values
     *
     * @return array
     */
    protected function getDefaults()
    {
        return [
            'behavior' => 'normal',
            'file' => '.env',
            'dist-file' => '.env.dist',
            'keep-outdated' => true,
        ];
    }
}
