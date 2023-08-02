<?php declare(strict_types=1);

namespace Angelej\PhpInsider;

use SplFileObject;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;

/**
 * @mixin \SplFileObject
 */
class File {

    /**
     * @var \SplFileObject
     */
    protected SplFileObject $file;

    /**
     * @param  string $path
     */
    public function __construct(string $path){

        $this->file = new SplFileObject($path);
    }

    /**
     * @return string
     */
    public function getContent(): string {

        return $this->fread($this->getSize());
    }


    /**
     * @param  string $location
     * @param  array $extensions
     * @param  array $excludedLocations
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
            $files[] = new File($realPath);
        }
        return $files;
    }

    /**
     * @param  string $name
     * @param  array $arguments
     * @return mixed
     */
    public function __call(string $name, array $arguments): mixed {

        return $this->file->$name(...$arguments);
    }
}