<?php
/**
 * @author Basic App Dev Team <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\Url;

use CodeIgniter\HTTP\URI;
use Config\App;

abstract class BaseUrl
{

    public static function getLocale()
    {
        return service('request')->getLocale();
    }

    public static function createUrl($path, array $params = [], string $scheme = null, App $alt = null) : string 
    {
        if (!$alt)
        {
            $alt = config(App::class);

            if ($alt->defaultLocale)
            {
                $locale = static::getLocale();
              
                if ($locale && ($alt->defaultLocale != $locale))
                {
                    $path = $locale . '/' . $path;
                }
            }
        }

        $return = site_url($path, $scheme, $alt);

        if (!$params)
        {
            return $return;
        }

        $uri = new URI($return);

        $uri->setQueryArray($params);

        return $uri->__toString();
    }

}