<?php
/**
 * Dublin(tm) : Bulletin board software (https://github.com/PropertyX)
 * Copyright (c) PropertyX Software Foundation, Inc. (https://github.com/Property)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) PropertyX Software Foundation, Inc. (https://github.com/PropertyX)
 * @link      https://github.com/PropertyX
 * @since     1.0
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */

namespace App\View\Helper;

use Cake\View\Helper;
use Cake\Core\Configure;
use Emojione\Client;
use Emojione\Emojione;
use Emojione\Ruleset;

class UbbHelper extends Helper
{

    public static function parse($string, $emojione = true)
    {
        $string = stripslashes($string);
        $string = nl2br($string);

        $string = self::setUbb($string);
        $string = self::image($string);
        $string = self::quote($string);
        $string = self::code($string);

        $string = (($emojione) ? self::emo($string) : $string);
        $string = str_replace("bmdiv", "div", $string);

        return $string;
    }

    public static function emo($string)
    {
        $client = new Client(new Ruleset());
        $client->imageType = 'svg';

       return $client->toImage($string);
    }

    public static function setUbb($bbcode)
    {
        $bbcode = preg_replace("_\[b\](.*?)\[/b\]_si", '<b>$1</b>', $bbcode);
        $bbcode = preg_replace('_\[i\](.*?)\[/i\]_si', '<i>$1</i>', $bbcode);
        $bbcode = str_replace("[hr]", '<hr />', $bbcode);
        $bbcode = preg_replace("_\[h3\](.*?)\[/h3\]_si", '<h3>$1</h3>', $bbcode);
        $bbcode = preg_replace("_\[u\](.*?)\[/u\]_si", '<u>$1</u>', $bbcode);
        $bbcode = preg_replace("_\[center\](.*?)\[/center\]_si", '<center>$1</center>', $bbcode);
        $bbcode = preg_replace("_\[list\](.*?)\[/list\]_si", '<ul>$1</ul>', $bbcode);
        $bbcode = preg_replace("_\[item\](.*?)\[/item\]_si", '<li>$1</li>', $bbcode);
        $bbcode = preg_replace("_\[s\](.*?)\[/s\]_si", '<strike>$1</strike>', $bbcode);
        $bbcode = preg_replace("_\[size=(.*?)\](.*?)\[/size\]_si", '<span style="font-size: $1px">$2</span>', $bbcode);
        $bbcode = preg_replace("_\[color=(.*?)\](.*?)\[/color\]_si", '<span style="color: $1;">$2</span>', $bbcode);
        $bbcode = preg_replace("_\[font=(.*?)\](.*?)\[/font\]_si", '<span style="font-family: $1">$2</span>', $bbcode);
        $bbcode = preg_replace("_\[hl=(.*?)\](.*?)\[/hl\]_si", '<span style="background: $1">$2</span>', $bbcode);
        $bbcode = preg_replace("_\[url\]http://(.*?)\[/url\]_si", '<a href="http://$1" target="_blank">$1</a>', $bbcode);
        $bbcode = preg_replace("_\[url\](.*?)\[/url\]_si", '<a href="http://$1" target="_blank">$1</a>', $bbcode);
        $bbcode = preg_replace("_\[url=http://(.*?)\](.*?)\[/url\]_si", '<a href="http://$1" target="_blank">$2</a>', $bbcode);
        $bbcode = preg_replace("_\[url=(.*?)\](.*?)\[/url\]_si", '<a href="http://$1" target="_blank">$2</a>', $bbcode);
        $bbcode = preg_replace("_\[align=center\](.*?)\[/align\]_si", '<div id="centerBlock">$1</div>', $bbcode);
        $bbcode = preg_replace("_\[align=left\](.*?)\[/align\]_si", '<div id="leftBlock">$1</div>', $bbcode);
        $bbcode = preg_replace("_\[align=right\](.*?)\[/align\]_si", '<div id="rightBlock">$1</div>', $bbcode);
        $bbcode = preg_replace("_\[youtube\](.*?)\[/youtube\]_si", '<iframe src="$1" id="ytBlock"></iframe>', $bbcode);
        $bbcode = preg_replace("_\[yt\](.*?)\[/yt\]_si", '<iframe src="$1" id="ytBlock"></iframe>', $bbcode);
        $bbcode = preg_replace('#(^|[ \n\r\t])([a-z0-9]{1,6}://([a-z0-9\-]{1,}(\.?)){1,}[a-z]{2,5}(:[0-9]{2,5}){0,1}((\/|~|\#|\?|=|&amp;|&|\+){1}[a-z0-9\-._%]{0,}){0,})#si', '\\1<a target="_blank" href="\\2">\\2</a>', $bbcode);
        $bbcode = preg_replace('#(^|[ \n\r\t])((www\.){1}([a-z0-9\-]{1,}(\.?)){1,}[a-z]{2,5}(:[0-9]{2,5}){0,1}((\/|~|\#|\?|=|&amp;|&|\+){1}[a-z0-9\-._%]{0,}){0,})#si', '\\1<a target="_blank" href="http://\\2">\\2</a>', $bbcode);
        $bbcode = preg_replace('#(^|[ \n\r\t])(([a-z0-9\-_]{1,}(\.?)){1,}@([a-z0-9\-]{1,}(\.?)){1,}[a-z]{2,5})#si', '\\1<a href="mailto:\\2">\\2</a>', $bbcode);
        $bbcode = preg_replace("_\[big](.*)\[/big\]_si", '<span style="font-size:16px">$1</span>', $bbcode);
        $bbcode = preg_replace("_\[small](.*)\[/small\]_si", '<small>$1</small>', $bbcode);

        return $bbcode;
    }

    public static function image($img)
    {
        $img = preg_replace("_\[img\](.*?)\[/img\]_si", '<img src="$1" style="max-width: 100%;" />', $img);
        $img = preg_replace("_\[imgr\](.*?)\[/imgr\]_si", '<img style="float: right" src="$1" />', $img);
        $img = preg_replace("_\[imgl\](.*?)\[/imgl\]_si", '<img style="float: left" src="$1" />', $img);

        return $img;
    }

    public static function quote($string)
    {
        while (preg_match("((\[quote=(.+?)\](.+?)\[\/quote\])|(\[quote\](.+?)\[\/quote]))is", $string)) {
            $quote = '<div class="quote"><div class="quote-user">{1}</div><div class="quote-inner">{2}</div></div>';

            $string = preg_replace("(\[quote=(.+?)\](.+?)\[\/quote\])si", str_replace("{1}", "$1", str_replace("{2}", "$2", $quote)), $string);
            $string = preg_replace("(\[quote\](.+?)\[\/quote\])si", str_replace("{1}", "Quote", str_replace("{2}", "$1", $quote)), $string);
        }

        return $string;
    }

    public static function code($string)
    {
        $bbcode = preg_replace("_\[code\](.*?)\[/code\]_si", '<pre class="brush: php">$1</pre>', $string);

        return $bbcode;
    }

    public static function tagURL($string)
    {

        $urlregex = "^(https?|ftp)\:\/\/([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?[a-z0-9+\$_-]+(\.[a-z0-9+\$_-]+)*(\:[0-9]{2,5})?(\/([a-z0-9+\$_-]\.?)+)*\/?(\?[a-z+&\$_.-][a-z0-9;:@/&%=+\$_.-]*)?(#[a-z_.-][a-z0-9+\$_.-]*)?\$";

       if (stristr($urlregex, $string)) {

            return '<a href="' . $string . '" target="_blank">' . $string . '</a>';

        }

        return $string;

    }
}