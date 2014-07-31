<?php

namespace JohnKrovitch\ORMBundle\Behavior;

use JohnKrovitch\ORMBundle\DataSource\Connection\Source;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

trait CommandBehavior
{
    protected $entityManager;
    protected $ormConsoleMarkup = '>>>> ORM';

    /**
     * @return ContainerInterface
     */
    abstract function getContainer();

    // TODO comments
    public function get($service)
    {
        return $this->getContainer()->get($service);
    }

    /**
     * Return current memory usage
     *
     * @param bool $formatted
     * @return int|string
     */
    protected function getMemoryUsage($formatted = true)
    {
        $memoryUsage = memory_get_usage(true);

        if ($formatted) {
            $memoryUsage = '<info>Memory usage</info> ' . date('Y/m/d h:i:s ') . round($memoryUsage / 1048576, 2) . 'Mb used';
        }
        return $memoryUsage;
    }

    /**
     * Display a string into <info> markup plus an optional string
     *
     * @param OutputInterface $output
     * @param $infoString
     * @param string $normalString
     */
    public function writeInfo(OutputInterface $output, $infoString, $normalString = '')
    {
        $output->writeln('<info>' . $infoString . '</info>' . $normalString);
    }
} 