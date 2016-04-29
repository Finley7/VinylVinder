<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;

/**
 * RSSReader component
 */
class RSSReaderComponent extends Component
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public function getFeed($url)
    {
        $content = file_get_contents($url);
        $x = new \SimpleXmlElement($content);

       return $x;
    }
}
