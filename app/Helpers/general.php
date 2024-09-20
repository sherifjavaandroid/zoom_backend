<?php

use GeoSot\EnvEditor\Facades\EnvEditor;

function isRTL(): bool
{
    return app()->getLocale() == "ar" || setting('localeCode') == "ar";
}

function inProduction(): bool
{
    return app()->environment('production');
}

function genFileName($file, $length = 5)
{
    //check if file is string data
    if (is_string($file)) {
        $sections = explode(".", $file);
        $ext = end($sections);
    } else {
        $ext  = $file->extension();
    }
    $name = \Str::random($length) . "-" . time() . "." . $ext;
    return $name;
}



function isMediaImage($media)
{
    return in_array($media->mime_type, ['image/jpeg', 'image/png', 'image/jpg', 'image/gif']);
}


function setEnv($key, $value, $group = null)
{
    if (EnvEditor::keyExists($key)) {
        EnvEditor::editKey($key, $value);
    } else {
        EnvEditor::addKey($key, $value);
        return;
        $options = [];
        if ($group != null && is_int($group)) {
            $options['group'] = $group;
        }
        EnvEditor::addKey($key, $value, $options);
    }
}


//create function that will accept two url, and return the url that is not 404
function getValidValue($url1, $url2)
{

    if (empty($url1)) {
        return $url2;
    }

    return $url2;
}


function systemPhoneCountryCode()
{
    return setting('countryCode', "INTERNATIONAL");
}


function appLogo()
{
    return getValidValue(setting('websiteLogo'), asset('images/logo.png'));
}



function isGeminiEnabled()
{
    return setting('preferredAISystem', 'openai') == 'gemini';
}
