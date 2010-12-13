<?php

namespace Application\YrchBundle\Helper;

use Symfony\Component\Templating\Helper\Helper;
use Symfony\Component\HttpFoundation\Session;

class LocaleHelper extends Helper
{
    /**
     * @var Session
     */
    protected $session;
    protected $languages;
    protected $availableLanguages;

    public function __construct(Session $session, array $availableLanguages)
    {
        $this->session = $session;
        $this->availableLanguages = $availableLanguages;
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
     * Return an array containing iso codes for all languages ordered alphabetically
     *
     * @return array
     */
    public function getLanguages()
    {
        if (null === $this->languages){
            $this->languages = include __DIR__.'/../Resources/config/languages.php';
        }
        return $this->languages;
    }

    /**
     * Return an array containing iso codes for languages supported by Yrch!
     *
     * @return array
     */
    public function getAvailableLanguages()
    {
        return $this->availableLanguages;
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

    public function getName()
    {
        return 'locale';
    }
}

