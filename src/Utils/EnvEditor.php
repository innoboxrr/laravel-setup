<?php

namespace Innoboxrr\LaravelSetup\Utils;

class EnvEditor
{
    private $envFilePath;
    private $exampleFilePath;
    private $envContent;
    private $exampleContent;

    public function __construct($envFilePath, $exampleFilePath)
    {
        $this->envFilePath = $envFilePath;
        $this->exampleFilePath = $exampleFilePath;
        $this->envContent = file_get_contents($envFilePath);
        $this->exampleContent = file_get_contents($exampleFilePath);
    }

    public function getParameter($key)
    {
        $pattern = "/^{$key}=(.*)$/m";
        if (preg_match($pattern, $this->envContent, $matches)) {
            return trim($matches[1]);
        }
        return null;
    }

    public function addOrUpdateParameter($key, $value)
    {
        $this->updateEnvContent($key, $value, true);
        $this->updateExampleContent($key);
        $this->save();
    }

    public function removeParameter($key)
    {
        $this->updateEnvContent($key, null, false);
        $this->updateExampleContent($key, false);
        $this->save();
    }

    private function updateEnvContent($key, $value, $addIfNotExists = true)
    {
        $pattern = "/^{$key}=.*$/m";

        if (preg_match($pattern, $this->envContent)) {
            $this->envContent = preg_replace($pattern, "{$key}={$value}", $this->envContent);
        } elseif ($addIfNotExists) {
            $this->envContent .= PHP_EOL . "{$key}={$value}";
        }
    }

    private function updateExampleContent($key, $addIfNotExists = true)
    {
        $pattern = "/^{$key}=.*$/m";

        if (preg_match($pattern, $this->exampleContent)) {
            $this->exampleContent = preg_replace($pattern, "{$key}=", $this->exampleContent);
        } elseif ($addIfNotExists) {
            $this->exampleContent .= PHP_EOL . "{$key}=";
        }
    }

    private function save()
    {
        file_put_contents($this->envFilePath, $this->envContent);
        file_put_contents($this->exampleFilePath, $this->exampleContent);
    }
}
