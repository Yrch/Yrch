<?php

namespace Application\YrchBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\Output;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\StringInput;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Application\YrchBundle\Entity\User;
use Application\YrchBundle\Entity\Site;
use Application\YrchBundle\Entity\Review;
use Application\YrchBundle\Entity\Category;
use Application\YrchBundle\Entity\SiteTemp;

/**
 * MigrateCommand.
 */
class LoadFixturesCommand extends Command
{
    /**
     * This array contains key/value couples as <old user_id> => User
     *
     * @var array
     */
    protected $users = array ();

    /**
     * This array contains key/value couples as <old site_id> => Site
     *
     * @var array
     */
    protected $sites = array ();

    /**
     * This array contains key/value couples as <old cat_id> => Category
     *
     * @var array
     */
    protected $categories = array ();

    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('yrch:load_fixtures')
            ->setDescription('Load the fixtures')
            ->setHelp(<<<EOT
The <info>yrch:load_fixtures</info> loads the fixtures for Yrch!:

  <info>php app/console yrch:load_fixtures</info>

Use this command instead of <info>doctrine:data:load</info> as
<info>yrch:populate</yrch> must be used before inserting the fixtures.
EOT
        );
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $purger = new ORMPurger($this->container->get('doctrine.orm.entity_manager'));
        $purger->purge();
        $string_input = new StringInput('yrch:populate');
        $application = new Application($this->application->getKernel());
        $application->setAutoExit(false);
        $application->run($string_input, $output);

        $string_input = new StringInput('doctrine:data:load --append=true');
        $application->run($string_input, $output);
    }
}
