<?php declare(strict_types=1);

class ClassFile {

    public function exec(string $cmd): void {

        exec($cmd);
    }
}