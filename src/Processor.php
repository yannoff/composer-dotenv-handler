<?php
/**
 * This file is part of the yannoff/composer-dotenv-handler project
 *
 * @copyright 2019 - Yannoff
 * @licence   MIT License
 * @author    Yannoff (https://github.com/yannoff)
 */

namespace Yannoff\DotenvHandler;

use Composer\IO\IOInterface;
use Yannoff\DotenvHandler\Component\Env;

/**
 * Class Processor
 *
 * @package Yannoff\DotenvHandler
 */
class Processor
{
    use IOTrait;

    /**
     * Processor constructor.
     *
     * @param IOInterface $io
     */
    public function __construct(IOInterface $io)
    {
        $this->setIO($io);
    }

    /**
     * @param array $config
     */
    public function processFile(array $config)
    {
        $realFile = $config['file'];
        $distFile = $config['dist-file'];

        $exists = is_file($realFile);

        $action = $exists ? 'Updating' : 'Creating';

        $this->printf('<info>%s the "%s" file</info>', $action, $realFile);

        // Find the expected params
        $distData = $this->load($distFile);
        $expectedValues = Env::parse($distData, $distFile);
        $expectedParams = (array) $expectedValues;

        // find the actual params
        $actualValues = [];
        if ($exists) {
            $realData = $this->load($realFile);
            $existingValues = Env::parse($realData, $realFile);

            if (!is_array($existingValues)) {
                throw new RuntimeException('The existing "%s" file does not contain an array', $realFile);
            }
            $actualValues = array_merge($actualValues, $existingValues);
        }

        $actualValues = $this->processParams($config, $expectedParams, (array) $actualValues);

        $this->save($realFile, Env::dump($actualValues));
    }

    /**
     * @param array $config
     * @param array $expectedParams
     * @param array $actualParams
     *
     * @return array
     */
    private function processParams(array $config, array $expectedParams, array $actualParams)
    {
        $keepOutdatedParams = (boolean) $config['keep-outdated'];

        if (!$keepOutdatedParams) {
            $actualParams = array_intersect_key($actualParams, $expectedParams);
        }

        return $this->getParams($expectedParams, $actualParams);
    }

    /**
     * Build params array, prompting for user to give the missing values
     *
     * @param array $expectedParams
     * @param array $actualParams
     *
     * @return array
     */
    private function getParams(array $expectedParams, array $actualParams)
    {
        // Simply use the expectedParams value as default for the missing params.
        if (!$this->io->isInteractive()) {
            return array_replace($expectedParams, $actualParams);
        }

        $isStarted = false;

        foreach ($expectedParams as $key => $message) {
            if (array_key_exists($key, $actualParams)) {
                continue;
            }

            if (!$isStarted) {
                $isStarted = true;
                $this->printf('<comment>Some environment variables are missing. Please provide them.</comment>');
            }

            $default = $message;
            $value = $this->askf('<question>%s</question>: ',$default, $key, $default);

            $actualParams[$key] = $value;
        }

        return $actualParams;
    }

    /**
     * Save data to the given file
     *
     * @param string $file Absolute or relative filename
     * @param string $data String representation of the data
     */
    protected function save($file, $data)
    {
        file_put_contents($file, "# This file is auto-generated during the composer install\n" . $data . "\n");
    }

    /**
     * Load string content of the given file
     *
     * @param string $file Absolute or relative filename
     *
     * @return string
     */
    protected function load($file)
    {
        return file_get_contents($file);
    }
}
