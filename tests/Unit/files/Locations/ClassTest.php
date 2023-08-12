<?php declare(strict_types=1);

class ClassTest {

    public function exec(string $cmd): void {

        exec($cmd);
    }
}