<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Kushal\Test\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Kushal\Test\Model\Duplicate;

class CopyProduct extends Command
{

    public function __construct(
        Duplicate $duplicate
    ) {
        $this->duplicate = $duplicate;
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ) {
        $output->writeln("Searching for products ...");
        $count = $this->duplicate->ProductCollectionCopy();
        $output->writeln($count." No of products has been created");
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName("kushal:copy");
        $this->setDescription("To copy New product ");
        parent::configure();
    }
}

