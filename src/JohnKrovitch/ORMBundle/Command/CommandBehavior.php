<?php

namespace JohnKrovitch\ORMBundle\Command;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\ORM\EntityManager;
use Exception;
use JohnKrovitch\ORMBundle\Database\Connection\Driver\YmlDriver;
use JohnKrovitch\ORMBundle\Database\Connection\Source\YmlSource;
use JohnKrovitch\ORMBundle\Database\Connection\Source;
use JohnKrovitch\ORMBundle\Database\Constants;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

trait CommandBehavior
{
    protected $entityManager;

    /**
     * @return ContainerInterface
     */
    abstract function getContainer();

    /**
     * Return entityManager
     *
     * @param string $em
     * @return EntityManager
     */
    protected function getEntityManager($em = null)
    {
        if (!$this->entityManager) {
            $this->entityManager = $this->getDoctrine()->getManager($em);
        }
        return $this->entityManager;
    }

    /**
     * Return Doctrine
     *
     * @return Registry
     */
    protected function getDoctrine()
    {
        return $this->getContainer()->get('doctrine');
    }

    /**
     * Create source(s) from options
     *
     * @param $options
     * @throws Exception
     * @internal param $source
     * @return array
     */
    protected function createSourcesFromOptions($options = [])
    {
        // yml by default
        $type = array_key_exists('type', $options) ? $options['type'] : 'yml';

        // yml
        if ($type == 'yml') {
            $sources = [];

            // try to find schema.yml locations
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
                die('Not implemented yet');
            }
        } else if ($type == 'database') {
            die('Not implemented yet;');
        } else {
            throw new Exception('Invalid value for source options : ' . $type);
        }
        return $sources;
    }

    /**
     * Create instance drivers according to various sources
     *
     * @param array $sources
     * @throws \Exception
     * @return array
     */
    public function createDriversFromSources(array $sources)
    {
        $drivers = [];

        /** @var Source $source */
        foreach ($sources as $source) {
            // we create a driver by source type
            if ($source->getType() == Constants::DATABASE_TYPE_YML) {
                $driver = new YmlDriver();
                $driver->setSource($source);
            } else {
                throw new Exception($source->getType() . ' driver is not implemented yet');
            }
            $drivers[$source->getType()][] = $driver;
        }
        return $drivers;
    }

    public function getMemoryUsage($formatted = true)
    {
        $memoryUsage = memory_get_usage(true);

        if ($formatted) {
            $memoryUsage = '<info>Memory usage</info> ' . round($memoryUsage / 1048576, 2) . 'Mb used';
        }
        return $memoryUsage;
    }
} 