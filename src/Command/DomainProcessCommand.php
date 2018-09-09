<?php

namespace App\Command;

use App\Service\SiteService;
use InvalidArgumentException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class DomainProcessCommand extends Command
{
    protected static $defaultName = 'domain:process';
    private $siteService;
    private $defaultDepth = 3;

    public function __construct(SiteService $siteService)
    {
        $this->siteService = $siteService;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Parses any site/domain by an URL')
            ->addArgument('url', InputArgument::REQUIRED, 'Site URL')
            ->addArgument('depth', InputArgument::OPTIONAL, 'Page depth')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $url = $input->getArgument('url');
        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            throw new InvalidArgumentException("Expecting a valid URL in command line");
        }

        $inputDepth = (int)$input->getArgument('depth');
        $depth = $inputDepth ? $inputDepth : $this->defaultDepth;

        $this->siteService->buildFromUrl($url, $depth);

        $io->success("Processed {$url} with depth {$depth}");
    }
}
