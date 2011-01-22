<?php

namespace Yrch\YrchBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * MaintainScoreCommand
 *
 * @author Christophe Coevoet
 * @copyright (c) 2010, Tolkiendil, Association loi 1901
 * @license GPLv2 (http://www.opensource.org/licenses/gpl-2.0.php)
 */
class MaintainScoreCommand extends Command
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('yrch:maintain:score')
            ->setDescription('Updates the average score of all sites.')
            ->setHelp(<<<EOT
The <info>yrch:maintain:score</info> updates the average score of all sites.

  <info>php app/console yrch:maintain:score</info>
EOT
        );
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->container->get('doctrine.orm.entity_manager');
        $listenerManager = $this->container->get('doctrine_extensions.listener_manager');
        $listenerManager->addAllListeners($em);
        $siteRepo = $em->getRepository('Yrch\YrchBundle\Entity\Site');
        $siteRepo->updateAllAverageNotes();
        $output->write('The scores have been updated');
    }
}
