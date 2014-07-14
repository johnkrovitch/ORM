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
        // yml by default
        $type = array_key_exists('type', $options) ? $options['type'] : 'yml';

        // yml
        if ($type == 'yml') {
            $sources = [];

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

            if (in_array(['host', 'name', 'port', 'login', 'password'], array_keys($options))) {
                $host = $options['host'];
                $name = $options['name'];
                $port = $options['port'];
                $login = $options['login'];
                $password = $options['password'];

            } else {
                throw new Exception('Invalid Mysql source options');
            }
            $source = new MysqlSource();
            $source->setParameters($host, $name, $port, $login, $password);
        } else {
            throw new Exception('Invalid value for source options : ' . $type);
        }
        return $sources;
    }
} 