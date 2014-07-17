<?php

namespace JohnKrovitch\ORMBundle\Manager;

use Exception;
use JohnKrovitch\ORMBundle\Database\Connection\Source\MysqlSource;
use JohnKrovitch\ORMBundle\Database\Connection\Source\YmlSource;
use JohnKrovitch\ORMBundle\Database\Connection\Source;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\Finder\Finder;

class SourceManager
{
    /**
     * Create source(s) from options
     *
     * @param $options
     * @throws Exception
     * @internal param $source
     * @return array|Source
     */
    public function createSourcesFromOptions($options = [])
    {
        $sources = [];
        // yml by default
        $type = array_key_exists('type', $options) ? $options['type'] : 'yml';

        // yml
        if ($type == 'yml') {
            // if no option are provided, we try to find schema.yml locations
            if (!array_key_exists('location', $options)) {
                $sourcePath = realpath(__DIR__ . '/../../');
                $finder = new Finder();
                // we look for schema.yml files into "src/" directory
                $finder->files()->in($sourcePath)->path('/Resources/config')->name('schema.yml');

                /** @var SplFileInfo $file */
                foreach ($finder as $file) {
                    $nameArray = explode('/', $file->getRelativePath());
                    $name = $nameArray[0] . ':Resources:schema.yml';
                    // add one source by yml file
                    $sources[] = new YmlSource($name, $type, $file->getRealPath());
                }
            } else {
                throw new Exception('Specified yml files locations is not implemented yet');
            }
        } else if ($type == 'pdo_mysql') {
            foreach ($options as $optionsForSource) {
                if (is_array($optionsForSource)) {
                    $source = new MysqlSource();
                    $source->setParameters(
                        $optionsForSource['host'],
                        $optionsForSource['name'],
                        $optionsForSource['port'],
                        $optionsForSource['login'],
                        $optionsForSource['password']
                    );
                    $sources[] = $source;
                }
            }
        } else {
            throw new Exception('Invalid value for source options : ' . $type);
        }
        return $sources;
    }
} 