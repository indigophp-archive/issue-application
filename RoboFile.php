<?php

defined('APP_ROOT') or define('APP_ROOT', realpath(__DIR__.'/'));
putenv('APP_ROOT='.APP_ROOT);

defined('APP_ENV') or define('APP_ENV', getenv('APP_ENV') ?: 'development');

require APP_ROOT.'/vendor/autoload.php';

/**
 * Loading environment
 *
 * This should be done right before the application is loaded, since the application relies on the environment
 */
$dotenv = dotenv();

// To avoid the overhead caused by file loading, this is optional in production
if (APP_ENV == 'development') {
    $dotenv->load(APP_ROOT);
}

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Indigo\Service\Entity\User;

/**
 * This is project's console commands configuration for Robo task runner.
 *
 * @see http://robo.li/
 */
class RoboFile extends \Robo\Tasks
{
    use Indigo\Robo\Task\Doctrine\loadOrmTasks;

    /**
     * Runs a php server
     */
    public function server($opt = ['port' => 8000])
    {
        $this->taskServer($opt['port'])
            ->dir('public/ phpserver.php')
            ->run();
    }

    /**
     * Creates a new user
     *
     * @param string $username Username
     * @param string $email    Email
     * @param string $password Password
     */
    public function userCreate($username, $email, $password)
    {
        $app = require __DIR__.'/app/app.php';

        $em = $app['Doctrine\ORM\EntityManagerInterface'];
        $hasher = $app['hasher'];

        $user = new User($username, $email, $hasher->hash($password));

        $em->persist($user);
        $em->flush();
    }

    /**
     * Dumps assets to the public directory
     */
    public function assetsDump(
        array $opt = [
            'bootstrap-dir' => 'vendor/twbs/bootstrap/dist',
            'jquery-dir'    => 'vendor/components/jquery'
        ]
    ) {
        $opt['bootstrap-dir'] = realpath($opt['bootstrap-dir']);
        $opt['jquery-dir'] = realpath($opt['jquery-dir']);

        $this->taskDeleteDir('public/assets/')->run();

        $this->taskFileSystemStack()
            ->mkdir('public/assets/css')
            ->mkdir('public/assets/js')
            ->mkdir('public/assets/fonts')
            ->mkdir('public/assets/img')
            ->copy($opt['bootstrap-dir'].'/css/bootstrap.min.css', 'public/assets/css/bootstrap.min.css')
            ->copy($opt['bootstrap-dir'].'/js/bootstrap.min.js', 'public/assets/js/bootstrap.min.js')
            ->mirror($opt['bootstrap-dir'].'/fonts/', 'public/assets/fonts/')
            ->copy($opt['jquery-dir'].'/jquery.min.js', 'public/assets/js/jquery.min.js')
            ->run();
    }

    /**
     * {@inheritdoc}
     */
    protected function getEntityManagerHelperSet()
    {
        $app = require __DIR__.'/app/app.php';

        $em = $app['Doctrine\ORM\EntityManagerInterface'];

        return ConsoleRunner::createHelperSet($em);
    }
}
