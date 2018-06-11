<?php


namespace BeastPHP\Utility;


use Yosymfony\Toml\Toml;

class Lang
{

    /**
     * This method parses the sentence given and grabs the corresponding
     * translated sentence in the locales dictionnary
     *
     * @param $sentence string The dico keyword to translate
     * @return string
     */
    public static function translate($sentence){
        $locale = Toml::parseFile(BASEPATH . SEP . 'app' . SEP . 'Configuration' . SEP . 'beast.toml')['language']['locale'];
        $dictionary = Toml::parseFile(BASEPATH . SEP . 'app' . SEP . 'Dictionary' . SEP . 'dico_'.$locale.'.toml');

        $arr = explode(":", $sentence);
        if(count($arr) != 2){
            throw new \InvalidArgumentException("The specified sentence cannot be translated");
        }

        $category = $arr[0];
        $textId = $arr[1];
        return $dictionary[$category][$textId];
    }



}