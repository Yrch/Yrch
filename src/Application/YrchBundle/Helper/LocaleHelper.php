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

    public function __construct(Session $session)
    {
        $this->session = $session;
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

    public function getName()
    {
        return 'locale';
    }
}

