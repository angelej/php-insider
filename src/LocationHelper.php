<?php declare(strict_types=1);

namespace Angelej\PhpInsider;

class LocationHelper {

    /**
     * @param  \Angelej\PhpInsider\Location $location
     * @return string
     */
    public static function printBreadcrumb(Location $location): string {

        $crumbs = [
            $location->getPathname()
        ];

        if($classNode = $location->getClassNode()){
            $crumbs[] = '&#9400; ' . $classNode->name;
        }

        if($methodNode = $location->getMethodNode()){
            $crumbs[] = '&#9436; ' . $methodNode->name;
        }

        if($functionNode = $location->getFunctionNode()){
            $crumbs[] = '&#9429; ' . $functionNode->name;
        }
        return implode(' &#8250; ', $crumbs);
    }
}