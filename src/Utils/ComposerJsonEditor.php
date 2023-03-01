<?php

namespace Innoboxrr\LaravelSetup\Utils;

class ComposerJsonEditor
{

    private $composerJsonFilePath;
    
    private $composerJson;

    public function __construct($composerJsonFilePath)
    {
    
        $this->composerJsonFilePath = $composerJsonFilePath;
    
        $this->composerJson = json_decode(file_get_contents($composerJsonFilePath), true);
    
    }

    public function addParameter($key, $value)
    {
    
        $this->setArrayValue($this->composerJson, $key, $value);
    
        $this->save();
    
    }

    public function updateParameter($key, $value, $createIfNotExists = true)
    {
    
        if (!array_has($this->composerJson, $key)) {
    
            if ($createIfNotExists) {
    
                $this->addParameter($key, $value);
    
            } else {
    
                throw new Exception("The key '{$key}' does not exist in the composer.json file.");
    
            }
    
        } else {
    
            $this->setArrayValue($this->composerJson, $key, $value);
    
            $this->save();
    
        }
    
    }

    public function removeParameter($key)
    {
    
        if (!array_has($this->composerJson, $key)) {
    
            throw new Exception("The key '{$key}' does not exist in the composer.json file.");
    
        }

        array_forget($this->composerJson, $key);
    
        $this->save();
    
    }

    private function setArrayValue(&$array, $key, $value)
    {
    
        $keys = explode('.', $key);

        while (count($keys) > 1) {
    
            $key = array_shift($keys);

            if (!isset($array[$key])) {
    
                $array[$key] = [];
    
            }

            $array = &$array[$key];
    
        }

        $array[array_shift($keys)] = $value;
    
    }

    private function save()
    {
    
        file_put_contents($this->composerJsonFilePath, json_encode($this->composerJson,  JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    
    }
    
}
