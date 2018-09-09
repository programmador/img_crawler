<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class DomainProcessCommand extends Command
{
    protected static $defaultName = 'domain:process';

    protected function configure()
    {
        $this
            ->setDescription('Parses any site/domain by an URL')
            ->addArgument('url', InputArgument::REQUIRED, 'Site URL')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $url = $input->getArgument('url');

        $io->success("Processed {$url}");
    }
}
