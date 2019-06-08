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
 * Class ConfigFactory
 * Factory for FlexConfig/StandardConfig instances
 *
 * @package Yannoff\DotenvHandler\Config
 */
class ConfigFactory
{
    /**
     * Factory method for Config class creation
     *
     * The class returned will depend on the 'behavior' setting:
     *
     * - FlexConfig     if $options['behavior'] is set to 'flex'
     * - StandardConfig otherwise
     *
     * @param array $options
     *
     * @return Config
     */
    static public function create($options = [])
    {
        $behavior = Config::BEHAVIOR_NORMAL;

        if (array_key_exists(Config::OPTION_BEHAVIOR, $options)) {
            $behavior = $options[Config::OPTION_BEHAVIOR];
        }

        switch ($behavior):
            case Config::BEHAVIOR_FLEX:
                $class = FlexConfig::class;
                break;

            default:
            case Config::BEHAVIOR_NORMAL:
                $class = StandardConfig::class;
                break;
        endswitch;

        return new $class($options);
    }
}
