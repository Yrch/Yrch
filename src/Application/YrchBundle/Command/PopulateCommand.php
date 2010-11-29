<?php

namespace Application\YrchBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\Output;
use Application\YrchBundle\Entity\User;
use Application\YrchBundle\Entity\Category;

/**
 * GenerateGroupsCommand.
 */
class PopulateCommand extends Command
{
    protected $permissions = array ();

    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('yrch:populate')
            ->setDescription('Generate the groups and permissions, the special user and the root category.')
            ->setHelp(<<<EOT
The <info>yrch:populate</info> command creates the groups, the permissions,
the special user and the root category needed by Yrch!:

  <info>php app/console yrch:populate</info>

The root category will have the name <comment>Yrch!</comment> but you can then
change it by editing the category in the admin part of the site.
EOT
        );
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Generating permissions
        $output->writeln('Generating permissions');
        $permissions = $this->container->get('doctrine_user.repository.permission')->findAll();
        foreach ($permissions as $permission){
            $this->permissions[$permission->getName()] = $permission;
        }
        $this->addPermission('admin', 'admin access', $output);
        $this->addPermission('moderator', 'moderator access', $output);
        // Generating groups
        $output->writeln('Generating groups');
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
        $adminGroup->addPermission($this->permissions['admin']);
        $adminGroup->addPermission($this->permissions['moderator']);
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
        $moderatorGroup->addPermission($this->permissions['moderator']);
        $groupRepo->getObjectManager()->persist($moderatorGroup);
        // Special user
        $output->writeln('Generating special user');
        $userRepo = $this->container->get('doctrine_user.repository.user');
        if (null === $userRepo->findOneByUsername($this->container->getParameter('yrch.special_user.username'))){
            $specialUser = new User();
            $specialUser->setUsername($this->container->getParameter('yrch.special_user.username'));
            $specialUser->setNick($this->container->getParameter('yrch.special_user.nick'));
            $specialUser->setEmail($this->container->getParameter('yrch.special_user.email'));
            $specialUser->setPreferedLocale($this->container->getParameter('session.default_locale'));
            $specialUser->setPassword(md5(uniqid() . rand(100000, 999999)));
            $specialUser->lock();
            $specialUser->setIsActive(true);
            $userRepo->getObjectManager()->persist($specialUser);
            if ($output->getVerbosity() == Output::VERBOSITY_VERBOSE){
                $output->writeln(sprintf('Created user <comment>%s</comment>', $specialUser->getNick()));
            }
        }
        // Generating root category
        $output->writeln('Generating the root category');
        $categoryRepo = $this->container->get('doctrine.orm.entity_manager')
                ->getRepository('Application\\YrchBundle\\Entity\\Category');
        $rootnodes = $categoryRepo->children(null, true);
        if (!$rootnodes){
            $category = new Category();
            $category->setName('Yrch!');
            $category->setDescription('');
            $this->container->get('doctrine.orm.entity_manager')->persist($category);
            if ($output->getVerbosity() == Output::VERBOSITY_VERBOSE){
                $output->writeln(sprintf('Created category <comment>%s</comment>', $category->getName()));
            }
        }
        $groupRepo->getObjectManager()->flush();
    }

    protected function addPermission($name, $description, OutputInterface $output)
    {
        if (!isset($this->permissions[$name])){
            $permissionRepo = $this->container->get('doctrine_user.repository.permission');
            $permissionClass = $permissionRepo->getObjectClass();
            $permission = new $permissionClass();
            $permission->setName($name);
            $permission->setDescription($description);
            $permissionRepo->getObjectManager()->persist($permission);
            $this->permissions[$name] = $permission;
            if ($output->getVerbosity() == Output::VERBOSITY_VERBOSE){
                $output->writeln(sprintf('Created permission <comment>%s</comment>', $permission->getName()));
            }
        }
    }
}
