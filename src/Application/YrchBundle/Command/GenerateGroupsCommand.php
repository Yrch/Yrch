<?php

namespace Application\YrchBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\Output;

/**
 * GenerateGroupsCommand.
 */
class GenerateGroupsCommand extends Command
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('yrch:generate:groups')
            ->setDescription('Generate the groups.')
            ->setHelp(<<<EOT
The <info>yrch:generate:groups</info> command creates the groups needed by Ych!:

  <info>php app/console yrch:generate:groups</info>

EOT
        );
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Generating permissions and groups');
        $groupRepo = $this->container->get('doctrine_user.repository.group');
        $groupClass = $groupRepo->getObjectClass();
        // Admin
        $adminGroup = $groupRepo->findOneByName('Admin');
        if ($adminGroup === null){
            $adminGroup = new $groupClass();
            $adminGroup->setName('Admin');
            $adminGroup->setDescription('Administrator');
            if ($output->getVerbosity() == Output::VERBOSITY_VERBOSE){
                $output->writeln(sprintf('Created group <comment>%s</comment>', $adminGroup->getName()));
            }
        }
        $adminGroup->addPermission($this->addPermission('admin', 'admin access', $output));
        $adminGroup->addPermission($this->addPermission('moderator', 'moderator access', $output));
        $groupRepo->getObjectManager()->persist($adminGroup);
        // Moderator
        $moderatorGroup = $groupRepo->findOneByName('Moderator');
        if ($moderatorGroup === null){
            $moderatorGroup = new $groupClass();
            $moderatorGroup->setName('Moderator');
            $moderatorGroup->setDescription('Moderator');
            if ($output->getVerbosity() == Output::VERBOSITY_VERBOSE){
                $output->writeln(sprintf('Created group <comment>%s</comment>', $moderatorGroup->getName()));
            }
        }
        $moderatorGroup->addPermission($this->addPermission('moderator', 'moderator access', $output));
        $groupRepo->getObjectManager()->persist($moderatorGroup);
        $groupRepo->getObjectManager()->flush();
    }

    protected function addPermission($name, $description, OutputInterface $output)
    {
        $permissionRepo = $this->container->get('doctrine_user.repository.permission');
        $permissionClass = $permissionRepo->getObjectClass();
        $permission = $permissionRepo->findOneByName($name);
        if ($permission === null){
            $permission = new $permissionClass();
            $permission->setName($name);
            $permission->setDescription($description);
            $permissionRepo->getObjectManager()->persist($permission);
            $permissionRepo->getObjectManager()->flush();
            if ($output->getVerbosity() == Output::VERBOSITY_VERBOSE){
                $output->writeln(sprintf('Created permission <comment>%s</comment>', $permission->getName()));
            }
        }
        return $permission;
    }
}
