<?php

namespace Application\YrchBundle\Helper;

use Symfony\Component\Templating\Helper\Helper;
use Symfony\Component\HttpFoundation\Request;

class RouteHelper extends Helper
{
    /**
     * @var Request
     */
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Get the current route
     *
     * @return string
     */
    public function getCurrent()
    {
        return $this->request->attributes->get('_route');
    }

    /**
     * Get the current route
     *
     * @return string
     */
    public function getParameters()
    {
        $parameters = $this->request->attributes->all();
        unset($parameters['_controller']);
        unset($parameters['_route']);
        unset($parameters['_locale']);
        return $parameters;
    }

    public function getName()
    {
        return 'route';
    }
}

