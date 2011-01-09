<?php

namespace Application\YrchBundle\Twig;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session;
use Symfony\Component\Routing\RouterInterface;

/**
 * LocaleHelper
 *
 * @author Christophe Coevoet
 * @copyright (c) 2010, Tolkiendil, Association loi 1901
 * @license GPLv2 (http://www.opensource.org/licenses/gpl-2.0.php)
 */
class YrchExtension extends \Twig_Extension
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Session
     */
    protected $session;

    /**
     * @var RouterInterface
     */
    protected $router;
    protected $availableLanguages;

    public function __construct(Request $request, Session $session, RouterInterface $router, array $availableLanguages)
    {
        $this->request = $request;
        $this->session = $session;
        $this->router = $router;
        $this->availableLanguages = $availableLanguages;
    }

    public function getFunctions()
    {
        return array(
            'yrch_locale' => new \Twig_Function_Method($this, 'getLocale'),
            'yrch_languageName' => new \Twig_Function_Method($this, 'getLanguageName'),
            'yrch_path' => new \Twig_Function_Method($this, 'getPath'),
            'yrch_url' => new \Twig_Function_Method($this, 'getUrl'),
            'yrch_currentRoute' => new \Twig_Function_Method($this, 'getCurrentRoute'),
            'yrch_currentRouteParameters' => new \Twig_Function_Method($this, 'getCurrentRouteParameters'),
        );
    }

    public function getGlobals()
    {
        return array(
            'yrch_availableLanguages' => $this->availableLanguages,
        );
    }

    public function getName()
    {
        return 'yrch';
    }

    /**
     * Get the current locale
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->session->getLocale();
    }

    /**
     * Get the language name in the used locale
     *
     * @param string $language the iso code of the language
     * @return string
     */
    public function getLanguageName($language)
    {
        return \Locale::getDisplayLanguage($language, $this->session->getLocale());
    }

    /**
     * Get the path for the given route
     *
     * @param string $name
     * @param array $parameters
     * @return string
     */
    public function getPath($name, array $parameters = array())
    {
        $parameters = array_merge(array('locale' => $this->getLocale()), $parameters);

        return $this->router->generate($name, $parameters, false);
    }

    /**
     * Get the url for the given route
     *
     * @param string $name
     * @param array $parameters
     * @return string
     */
    public function getUrl($name, array $parameters = array())
    {
        $parameters = array_merge(array('locale' => $this->getLocale()), $parameters);

        return $this->router->generate($name, $parameters, true);
    }

    /**
     * Get the current route
     *
     * @return string
     */
    public function getCurrentRoute()
    {
        return $this->request->attributes->get('_route');
    }

    /**
     * Get the current route parameters
     *
     * @return string
     */
    public function getCurrentRouteParameters()
    {
        $parameters = $this->request->attributes->all();
        unset($parameters['_controller']);
        unset($parameters['_route']);
        unset($parameters['_locale']);
        return $parameters;
    }
}

