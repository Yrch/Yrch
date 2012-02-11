<?php

namespace Yrch\YrchBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\Output;
use Yrch\YrchBundle\Entity\Category;

/**
 * PopulateCommand
 *
 * @author Christophe Coevoet
 * @copyright (c) 2010, Tolkiendil, Association loi 1901
 * @license GPLv2 (http://www.opensource.org/licenses/gpl-2.0.php)
 */
class PopulateCommand extends ContainerAwareCommand
{
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
        // Special user
        $output->writeln('Generating special user');
        $userManager = $this->getContainer()->get('fos_user.user_manager');
        if (null === $userManager->findUserByUsername($this->getContainer()->getParameter('yrch.special_user.username'))){
            $specialUser = $userManager->createUser();
            $specialUser->setUsername($this->getContainer()->getParameter('yrch.special_user.username'));
            $specialUser->setNick($this->getContainer()->getParameter('yrch.special_user.nick'));
            $specialUser->setEmail($this->getContainer()->getParameter('yrch.special_user.email'));
            $specialUser->setPreferedLocale($this->getContainer()->getParameter('stof_doctrine_extensions.default_locale'));
            $specialUser->setPassword(md5(uniqid().rand(100000, 999999)));
            $specialUser->setEnabled(true);
            $specialUser->setLocked(true);
            $userManager->updateUser($specialUser);
            if ($output->getVerbosity() == Output::VERBOSITY_VERBOSE){
                $output->writeln(sprintf('Created user <comment>%s</comment>', $specialUser->getNick()));
            }
        }
        // Generating root category
        $output->writeln('Generating the root category');
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $categoryRepo = $em->getRepository('Yrch\\YrchBundle\\Entity\\Category');
        $rootnodes = $categoryRepo->children(null, true);
        if (!$rootnodes){
            $category = new Category();
            $category->setName('Yrch!');
            $category->setDescription('');
            $em->persist($category);
            $em->flush();
            if ($output->getVerbosity() == Output::VERBOSITY_VERBOSE){
                $output->writeln(sprintf('Created category <comment>%s</comment>', $category->getName()));
            }
        }
    }
}
