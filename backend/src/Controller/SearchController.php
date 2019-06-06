<?php

namespace App\Controller;

use App\Dto\GrabInfoDto;
use App\Dto\GrabResultSetDto;
use App\Entity\GrabInfo;
use App\Message\CrawlTaskNotification;
use App\Repository\SiteRepository;
use App\Service\GrabInfoService;
use App\Service\GrabResultService;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Messenger\MessageBusInterface;


class SearchController extends AbstractController
{
    /**
     * @Route("/search/create", name="search_create", methods={"POST"})
     * @param Request $request
     * @param SiteRepository $siteRepository
     * @param ValidatorInterface $validator
     * @param GrabInfoService $grabInfoService
     * @param MessageBusInterface $bus
     * @return GrabInfoDto|\Symfony\Component\HttpFoundation\JsonResponse
     */
    public function create(
        Request $request,
        SiteRepository $siteRepository,
        ValidatorInterface $validator,
        GrabInfoService $grabInfoService,
        MessageBusInterface $bus
    )
    {
        $grabInfoDto = new GrabInfoDto();

        $grabInfoDto->band = $request->get('band');
        $grabInfoDto->email = $request->get('email');
        $grabInfoDto->username = $request->get('username');
        $grabInfoDto->depth = $request->get('depth');

        $errors = $validator->validate($grabInfoDto);

        if (count($errors) > 0) {
            $errorsString = (string) $errors;

            return $this->json($errorsString, 400);
        }

        $sites = $this->getSites($request->get('sites'), $siteRepository);

        $grabInfo = $grabInfoService->convertToEntityFromDto($grabInfoDto);

        foreach ($sites as $site) {
            $grabInfo->addSite($site);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($grabInfo);
        $em->flush();

        foreach ($grabInfo->getSites() as $site) {
            $bus->dispatch(new CrawlTaskNotification($grabInfo->getId(), $site->getId()));
        }

        return $this->json($grabInfoService->convertToDto($grabInfo));
    }

    /**
     * @Route("/search/{grabInfo}", name="search_results", methods={"GET"}, requirements={"grabInfo"="\d+"})
     * @param GrabInfo $grabInfo
     * @param GrabResultService $grabResultService
     * @param LoggerInterface $logger
     * @return GrabInfoDto|\Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getResults(
        GrabInfo $grabInfo,
        GrabResultService $grabResultService,
        LoggerInterface $logger
    )
    {
        $grabResultSetDto = new GrabResultSetDto();

        $grubResults = $grabInfo->getGrabResults();

        $resultsDtos = [];

        foreach ($grubResults as $grabResult) {
            $resultsDtos[] = $grabResultService->convertToDtoWithoutInfo($grabResult);
        }

        $grabResultSetDto->isFinished = $grabInfo->getFinishedUrlsCounter() >= count($grabInfo->getSites());

        if ($grabInfo->getFinishedUrlsCounter() > count($grabInfo->getSites())) {
            $logger->warning('SearchController:finished_urls_counter_overflow', [
                'urls_counter' => $grabInfo->getFinishedUrlsCounter(),
                'sites_amount' => count($grabInfo->getSites()),
            ]);
        }

        $grabResultSetDto->grabResults = $resultsDtos;

        return $this->json($grabResultSetDto);
    }

    protected function getSites($requestSitesIds, SiteRepository $siteRepository): array
    {
        $sites = [];

        if (
            is_array($requestSitesIds)
            && !empty($requestSitesIds)
        ) {
            $requestSitesIds = array_filter($requestSitesIds, function ($site) {
                return is_numeric($site);
            });
            $sites = $siteRepository->findByIds($requestSitesIds);
        }

        return $sites;
    }
}
