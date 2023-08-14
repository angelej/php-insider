<?php declare(strict_types=1);

namespace Angelej\PhpInsider;

use SplFileInfo;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;

/**
 * @mixin \SplFileInfo
 */
class File {

    /**
     * @var \SplFileInfo
     */
    protected SplFileInfo $file;

    /**
     * @param  string $path
     */
    public function __construct(string $path){

        $this->file = new SplFileInfo($path);
    }

    /**
     * @return string
     */
    public function getContent(): string {

        $content = '';

        if($this->file->getSize() > 0){
            $fp = @fopen('file://' . $this->file->getRealPath(), 'r');

            if($fp){

                $content = fread($fp, $this->file->getSize());
                fclose($fp);
            }
        }
        return $content;
    }


    /**
     * @param  string $location
     * @param  string[] $extensions
     * @param  string[] $excludedLocations
     * @return array|\Angelej\PhpInsider\File[]
     */
    public static function glob(string $location, array $extensions = ['php'], array $excludedLocations = []): array {

        $files = [];
        $excludedPaths = [];
        array_map(function($excludedPath) use (&$excludedPaths){

            if(is_array($paths = glob($excludedPath))){

                foreach($paths as $path){
                    $excludedPaths[] = realpath($path);
                }
            }
        }, $excludedLocations);

        $dirIterator = new RecursiveDirectoryIterator($location);

        foreach(new RecursiveIteratorIterator($dirIterator) as $file){

            // filter directories and symlinks
            if($file->isDir() || $file->isLink()) continue;

            // filter file extensions
            if(!in_array(strtolower($file->getExtension()), $extensions)) continue;

            $realPath = $file->getRealPath();

            // filter excluded paths
            foreach($excludedPaths as $excludedPath){

                if(str_starts_with($realPath, $excludedPath)) continue 2;
            }
            $files[] = new File($file->getPathname());
        }
        return $files;
    }

    /**
     * @param  string $name
     * @param  mixed[] $arguments
     * @return mixed
     */
    public function __call(string $name, array $arguments): mixed {

        return $this->file->$name(...$arguments);
    }
}