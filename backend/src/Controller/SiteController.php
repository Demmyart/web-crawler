<?php

namespace App\Controller;

use App\Dto\SiteDto;
use App\Entity\Site;
use App\Repository\SiteRepository;
use App\Service\SiteService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SiteController extends AbstractController
{
    /**
     * @Route("/site/list", name="site_list", methods={"GET"})
     * @param SiteRepository $siteRepository
     * @param SiteService $siteService
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function index(SiteRepository $siteRepository, SiteService $siteService)
    {
        $sites = $siteRepository->findAll();

        $sitesJson = [];

        foreach ($sites as $site) {
            $sitesJson[] = $siteService->convertToDto($site);
        }

        return $this->json($sitesJson);
    }

    /**
     * @Route("/site/create", name="site_create", methods={"POST"})
     * @param Request $request
     * @param ValidatorInterface $validator
     * @param SiteService $siteService
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function create(Request $request, ValidatorInterface $validator, SiteService $siteService)
    {
        $siteDto = new SiteDto();
        $siteDto->url = $request->get('url');
        $siteDto->restrictByUrl = $request->get('url'); //TODO: fix

        $errors = $validator->validate($siteDto);

        if (count($errors) > 0) {
            $errorsString = (string) $errors;

            return $this->json($errorsString, 400);
        }

        $site = new Site();
        $site->setUrl($siteDto->url);
        $site->setRestrictByUrl($siteDto->restrictByUrl);

        $em = $this->getDoctrine()->getManager();

        $em->persist($site);
        $em->flush();

        return $this->json($siteService->convertToDto($site));
    }

    /**
     * @Route("/site/delete/{site}", name="site_delete", methods={"POST", "DELETE"}, requirements={"site"="\d+"}))
     * @param Site $site
     * @return Response
     */
    public function delete(Site $site)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($site);
        $em->flush();

        return new Response();
    }
}
