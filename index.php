<?php

class Autoloader
{
    private $baseDir;

    public function __construct($baseDir)
    {
        $this->baseDir = rtrim($baseDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        spl_autoload_register([$this, 'loadClass']);
    }

    public function loadClass($className): void
    {
        $filePath = str_replace('\\', DIRECTORY_SEPARATOR, $className);
        $filePath = str_replace('_', DIRECTORY_SEPARATOR, $filePath);
        $filePath .= '.php';
        
        $fullPath = $this->baseDir . $filePath;

        if (file_exists($fullPath)) {
            require_once $fullPath;
        }
    }
}

$autoloader = new Autoloader('src');
$autoloader->loadClass('User');

$user = new User();
$user->firstName = 'Bob';
echo $user->firstName;
echo "\n";

require_once './vendor/autoload.php';
use Itrvb\Lab3\Post;

$post = new Post();
$post->title = 'Заголовок поста';
echo $post->title;
