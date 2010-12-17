<?php

namespace Application\YrchBundle\Helper;

use Symfony\Component\Templating\Helper\Helper;
use Symfony\Component\HttpFoundation\Request;

/**
 * The YrchRouteHelper gives access to the current toute in the templates
 *
 * @author Christophe Coevoet
 * @copyright (c) 2010, Tolkiendil, Association loi 1901
 * @license GPLv2 (http://www.opensource.org/licenses/gpl-2.0.php)
 */
class YrchRouteHelper extends Helper
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
        return 'yrch_route';
    }
}

