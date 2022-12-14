<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInitbe3f87fb0e69a078649493a35fa3572e
{
  private static $loader;

  public static function loadClassLoader($class)
  {
    if ('Composer\Autoload\ClassLoader' === $class) {
      require __DIR__ . '/ClassLoader.php';
    }
  }

  /**
   * @return \Composer\Autoload\ClassLoader
   */
  public static function getLoader()
  {
    if (null !== self::$loader) {
      return self::$loader;
    }

    spl_autoload_register(['ComposerAutoloaderInitbe3f87fb0e69a078649493a35fa3572e', 'loadClassLoader'], true, true);
    self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
    spl_autoload_unregister(['ComposerAutoloaderInitbe3f87fb0e69a078649493a35fa3572e', 'loadClassLoader']);

    require __DIR__ . '/autoload_static.php';
    call_user_func(\Composer\Autoload\ComposerStaticInitbe3f87fb0e69a078649493a35fa3572e::getInitializer($loader));

    $loader->register(true);

    return $loader;
  }
}
