<?php

namespace App\Controller;

use App\Service\SiteService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Psr\Log\LoggerInterface as Logger;

class StatsController extends AbstractController
{
    private $siteService;
    private $logger;

    public function __construct(SiteService $siteService, Logger $logger)
    {
        $this->siteService = $siteService;
        $this->logger = $logger;
    }

    /**
     * @Route("/", name="stats")
     */
    public function index()
    {
        $hosts = [];
        foreach($this->siteService->getHosts() as $host) {
            $hosts[$host] = $this->siteService->getImageStats($host);
        }
        return $this->render('stats/index.html.twig', compact('hosts'));
    }
}
