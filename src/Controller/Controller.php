<?php

namespace App\Controller;

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Extension\CoreExtension;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

abstract class Controller
{
    private static ?Environment $twigInstance = null;
    private static ?FilesystemLoader $twigLoader = null;

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function render(...$params): void
    {
        try {
            echo self::getTwig()->render(...$params);
        }
        catch (LoaderError $e) {
            echo self::getTwig()->render('error/404.html.twig');
        }
        catch (RuntimeError|SyntaxError $e) {
            echo self::getTwig()->render('error/500.html.twig');
        }
    }

    /**
     * Return Twig instance
     * @return Environment
     */
    public function getTwig(): Environment
    {
        if (null === self::$twigInstance) {
            if (null === self::$twigLoader) {
                self::$twigLoader = new FilesystemLoader('../templates');
            }
            self::$twigInstance = new Environment(self::$twigLoader, [
                'debug' => true,
                'strict_variables' => true,
                'cache' => '../var/cache',
            ]);

            self::$twigInstance->addExtension(new DebugExtension());
            self::$twigInstance->getExtension(CoreExtension::class)->setNumberFormat(2, ',', ' ');
            self::$twigInstance->getExtension(CoreExtension::class)->setDateFormat('m/d/Y', '%d days');
        }

        return self::$twigInstance;
    }

    /**
     * Return the current twig loader
     */
    public function getTwigLoader(): ?FilesystemLoader
    {
        return self::$twigLoader;
    }
}
