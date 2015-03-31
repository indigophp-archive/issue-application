<?php

defined('ROOTPATH') or define('ROOTPATH', realpath(__DIR__.'/'));

require ROOTPATH.'/vendor/autoload.php';

use Doctrine\ORM\Tools\Console\Command\SchemaTool;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Indigo\Service\Entity\User;

/**
 * This is project's console commands configuration for Robo task runner.
 *
 * @see http://robo.li/
 */
class RoboFile extends \Robo\Tasks
{
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
     * Processes the schema and either create it directly on EntityManager Storage Connection or generate the SQL output
     */
    public function schemaCreate($opt = ['dump-sql' => false])
    {
        $helperSet = $this->getEntityManagerHelperSet();
        $command = new SchemaTool\CreateCommand;
        $command->setHelperSet($helperSet);

        $this->taskSymfonyCommand($command)
            ->opt('dump-sql', $opt['dump-sql'])
            ->run();
    }

    /**
     * Executes (or dumps) the SQL needed to update the database schema to match the current mapping metadata
     */
    public function schemaUpdate($opt = ['dump-sql' => false, 'force' => false, 'complete' => false])
    {
        $helperSet = $this->getEntityManagerHelperSet();
        $command = new SchemaTool\UpdateCommand;
        $command->setHelperSet($helperSet);

        $this->taskSymfonyCommand($command)
            ->opt('dump-sql', $opt['dump-sql'])
            ->opt('force', $opt['force'])
            ->opt('complete', $opt['complete'])
            ->run();
    }

    /**
     * Drop the complete database schema of EntityManager Storage Connection or generate the corresponding SQL output
     */
    public function schemaDrop($opt = ['dump-sql' => false, 'force' => false, 'full-database' => false])
    {
        $helperSet = $this->getEntityManagerHelperSet();
        $command = new SchemaTool\DropCommand;
        $command->setHelperSet($helperSet);

        $this->taskSymfonyCommand($command)
            ->opt('dump-sql', $opt['dump-sql'])
            ->opt('force', $opt['force'])
            ->opt('full-database', $opt['full-database'])
            ->run();
    }

    /**
     * Returns an EntityManager
     */
    protected function getEntityManagerHelperSet()
    {
        $app = require __DIR__.'/app/app.php';

        $em = $app['Doctrine\ORM\EntityManagerInterface'];

        return ConsoleRunner::createHelperSet($em);
    }
}
