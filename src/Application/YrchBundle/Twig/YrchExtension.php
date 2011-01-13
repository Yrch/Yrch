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
    const color1 = '#FF0000';
    const color2 = '#50C53A';

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
            'yrch_scoreColor' => new \Twig_Function_Method($this, 'getScoreColor'),
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

    public function getScoreColor($score)
    {
        $scale = (int) (10 * $score);

        if ($scale > 100 || $scale < 0) {
            throw new \InvalidArgumentException(sprintf('The score "%s" is out of range'), $score);
        }

        $color1 = $this->colorSplit(self::color1);
        $color2 = $this->colorSplit(self::color2);

        $red_steps = ($color2[0] - $color1[0]) / 100;
        $green_steps = ($color2[1] - $color1[1]) / 100;
        $blue_steps = ($color2[2] - $color1[2]) / 100;

        $col[0] = round($red_steps * $scale);
        $col[1] = round($green_steps * $scale);
        $col[2] = round($blue_steps * $scale);

        for ($i = 0; $i < 3; $i++) {
            $partcolor = $color1[$i] + $col[$i];
            // If the color is less than 256
            if ($partcolor < 256) {
                // Makes sure the color is not less than 0
                if ($partcolor > -1) {
                    $newcolor[$i] = $partcolor;
                } else {
                    $newcolor[$i] = 0;
                }
                // Color was greater than 255
            } else {
                $newcolor[$i] = 255;
            }
        }

        return "#".sprintf('%02X%02X%02X', $newcolor[0], $newcolor[1], $newcolor[2]);
    }

    private function colorSplit($color)
    {
        $c[] = hexdec(substr($color, 1, 2));
        $c[] = hexdec(substr($color, 3, 2));
        $c[] = hexdec(substr($color, 5, 2));

        return $c;
    }
}

