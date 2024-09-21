<?php

namespace Innoboxrr\LaravelSetup\Utils;

trait FileManager
{
    public function rrDir($path)
    {
        if(!file_exists($path)) {
            return true;
        }
        if(!is_dir($path)) {
            return unlink($path);
        }
        foreach(glob($path . '/*') as $item) {
            if(is_dir($item)) {
                $this->rrDir($item);
            } else {
                unlink($item);
            }
        }
        return rmdir($path);
    }

    // Crear directorio
    public function mkDir($path)
    {
        if(!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        if(is_dir($path)) {
            chmod($path, 0777);
        }
        return $path;
    }

    // Copiar directorio
    public function cpDir($src, $dst) {
        $dir = opendir($src);
        @mkdir($dst);
        while (($file = readdir($dir)) !== false) {
            if ($file != '.' && $file != '..') {
                if (is_dir($src . '/' . $file)) {
                    $this->cpDir($src . '/' . $file, $dst . '/' . $file);
                } else {
                    copy($src . '/' . $file, $dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    }
}