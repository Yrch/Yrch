<?php

namespace Application\YrchBundle\Twig;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session;

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
    protected $availableLanguages;

    public function __construct(Request $request, Session $session, array $availableLanguages)
    {
        $this->request = $request;
        $this->session = $session;
        $this->availableLanguages = $availableLanguages;
    }

    public function  getFunctions()
    {
        return array(
            'yrch_locale' => new \Twig_Function_Method($this, 'getLocale'),
            'yrch_languageName' => new \Twig_Function_Method($this, 'getLanguageName'),
            'yrch_route' => new \Twig_Function_Method($this, 'getRoute'),
            'yrch_currentRoute' => new \Twig_Function_Method($this, 'getCurrentRoute'),
            'yrch_currentRouteParameters' => new \Twig_Function_Method($this, 'getCurrentRouteParameters'),
        );
    }

    public function  getGlobals()
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
     * Get the name of the i18n route for the given locale
     *
     * @param string $route The name of the route
     * @param string $locale (optional) The used locale. The current locale will be used if not provided
     * @return string 
     */
    public function getRoute($route, $locale = null)
    {
        if (null === $locale){
            $locale = $this->getLocale();
        }
        return $route.'_'.$locale;
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

