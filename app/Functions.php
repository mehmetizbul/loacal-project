<?php

namespace App;
use Illuminate\Support\Facades\File;

class Functions
{
    public static function sanitizeStringForUrl($string){
        $string = iconv("UTF-8","ascii//IGNORE",utf8_encode($string));
        return $string;
    }
    public static function maybe_unserialize( $original ) {
        if ( Functions::is_serialized( $original ) ) {
            $fixed = preg_replace_callback(
                '!(?<=^|;)s:(\d+)(?=:"(.*?)";(?:}|a:|s:|b:|i:|o:|N;))!s',
                function($match){
                    return 's:' . strlen($match[2]);
                },
                $original
            );
            return @unserialize( $fixed );
        }
        return $original;
    }
    public static function is_serialized( $data, $strict = true ) {
        // if it isn't a string, it isn't serialized.
        if ( ! is_string( $data ) ) {
            return false;
        }
        $data = trim( $data );
        if ( 'N;' == $data ) {
            return true;
        }
        if ( strlen( $data ) < 4 ) {
            return false;
        }
        if ( ':' !== $data[1] ) {
            return false;
        }
        if ( $strict ) {
            $lastc = substr( $data, -1 );
            if ( ';' !== $lastc && '}' !== $lastc ) {
                return false;
            }
        } else {
            $semicolon = strpos( $data, ';' );
            $brace     = strpos( $data, '}' );
            // Either ; or } must exist.
            if ( false === $semicolon && false === $brace )
                return false;
            // But neither must be in the first X characters.
            if ( false !== $semicolon && $semicolon < 3 )
                return false;
            if ( false !== $brace && $brace < 4 )
                return false;
        }
        $token = $data[0];
        switch ( $token ) {
            case 's' :
                if ( $strict ) {
                    if ( '"' !== substr( $data, -2, 1 ) ) {
                        return false;
                    }
                } elseif ( false === strpos( $data, '"' ) ) {
                    return false;
                }
            // or else fall through
            case 'a' :
            case 'O' :
                return (bool) preg_match( "/^{$token}:[0-9]+:/s", $data );
            case 'b' :
            case 'i' :
            case 'd' :
                $end = $strict ? '$' : '';
                return (bool) preg_match( "/^{$token}:[0-9.E-]+;$end/", $data );
        }
        return false;
    }
    public static function sanitize($string, $force_lowercase = true, $anal = false)
    {
        $strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]",
            "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
            "â€”", "â€“", ",", "<", ".", ">", "/", "?");
        $clean = trim(str_replace($strip, "", strip_tags($string)));
        $clean = preg_replace('/\s+/', "-", $clean);
        $clean = ($anal) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean ;

        return ($force_lowercase) ?
            (function_exists('mb_strtolower')) ?
                mb_strtolower($clean, 'UTF-8') :
                strtolower($clean) :
            $clean;
    }

    public static function uniqueFilename($dir,$filename,$extension){
        $filename = Functions::sanitize($filename);
        $fullname = $dir."/".$filename.".".$extension;
        if ( File::exists($fullname) )
        {
            // Generate token for image
            $imageToken = substr(sha1(mt_rand()), 0, 5);
            return $filename . '-' . $imageToken . '.' . $extension;
        }

        return $filename . '.' . $extension;
    }

    public static function nl2br_special($string){

        // Step 1: Add <br /> tags for each line-break
        $string = nl2br($string);

        // Step 2: Remove the actual line-breaks
        $string = str_replace("\n", "", $string);
        $string = str_replace("\r", "", $string);

        // Step 3: Restore the line-breaks that are inside <pre></pre> tags
        if(preg_match_all('/\<pre\>(.*?)\<\/pre\>/', $string, $match)){
            foreach($match as $a){
                foreach($a as $b){
                    $string = str_replace('<pre>'.$b.'</pre>', "<pre>".str_replace("<br />", PHP_EOL, $b)."</pre>", $string);
                }
            }
        }

        // Step 4: Removes extra <br /> tags

        // Before <pre> tags
        $string = str_replace("<br /><br /><br /><pre>", '<br /><br /><pre>', $string);
        // After </pre> tags
        $string = str_replace("</pre><br /><br />", '</pre><br />', $string);

        // Arround <ul></ul> tags
        $string = str_replace("<br /><br /><ul>", '<br /><ul>', $string);
        $string = str_replace("</ul><br /><br />", '</ul><br />', $string);
        // Inside <ul> </ul> tags
        $string = str_replace("<ul><br />", '<ul>', $string);
        $string = str_replace("<br /></ul>", '</ul>', $string);

        // Arround <ol></ol> tags
        $string = str_replace("<br /><br /><ol>", '<br /><ol>', $string);
        $string = str_replace("</ol><br /><br />", '</ol><br />', $string);
        // Inside <ol> </ol> tags
        $string = str_replace("<ol><br />", '<ol>', $string);
        $string = str_replace("<br /></ol>", '</ol>', $string);

        // Arround <li></li> tags
        $string = str_replace("<br /><li>", '<li>', $string);
        $string = str_replace("</li><br />", '</li>', $string);

        return $string;
    }
}
