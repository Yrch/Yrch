<?php

namespace Yrch\YrchBundle\DataCollector;

use Symfony\Component\HttpKernel\DataCollector\DataCollector;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * YrchDataCollector.
 *
 * @author Christophe Coevoet
 * @copyright (c) 2010, Tolkiendil, Association loi 1901
 * @license GPLv2 (http://www.opensource.org/licenses/gpl-2.0.php)
 */
class YrchDataCollector extends DataCollector
{
    protected $logger;

    public function __construct($logger = null)
    {
        if (null !== $logger) {
            $this->logger = $logger->getDebugLogger();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
        if (null !== $this->logger) {
            $this->data = array(
                'count' => count($this->logger->getLogs()),
                'logs'  => $this->logger->getLogs(),
            );
        }
    }

    /**
     * Gets the number of logs
     *
     * @return integer
     *
     */
    public function count()
    {
        return isset($this->data['count']) ? $this->data['count'] : 0;
    }

    /**
     * Gets the logs.
     *
     * @return array An array of logs
     */
    public function getLogs()
    {
        return isset($this->data['logs']) ? $this->data['logs'] : array();
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'yrch';
    }
}
