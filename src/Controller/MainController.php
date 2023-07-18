<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\HouseRepository;
use App\Entity\House;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;


class MainController extends AbstractController
{

    /**
     * @Route("/", name="index"),
     */
    public function index()
    {
        return $this->render("index.html.twig");
    }

    /**
     * @Route("/house", name="house"),
     */
    public function house(HouseRepository $houseRepository)
    {

        return $this->render("searchHouse.html.twig", ["houses" => $houseRepository->findAll()]);
    }

    /**
     * @Route("/house/search", name="search"),
     */
    public function serchHouse(Request $request, SerializerInterface $serializer) {
        if (!$request->isMethod('POST')) {
            return $this->redirect("index");
        }
        $entityManager = $this->getDoctrine()->getManager();
        $result = "";
        $houseName = trim($request->request->get('name'));
        $bedrooms = $request->request->get('bedrooms');
        $bathrooms = $request->request->get('bathrooms');
        $garages = $request->request->get('garages');
        $storeys = $request->request->get('storeys');
        $costMin = trim($request->request->get('costMin'));
        $costMax = trim($request->request->get('costMax'));
        $queryBuilder = $entityManager->createQueryBuilder();
        $queryBuilder->select('h')->from(House::class, 'h');
        $parametrs = [];
        if ($houseName) {
            $queryBuilder->andWhere('h.name LIKE :houseName')->setParameters(':houseName', '%'.$houseName.'%');
            $parametrs[':houseName'] = '%'.$houseName.'%';
        }
        if ($costMin) {
            $queryBuilder->andWhere('h.price >= :costMin');
            $parametrs[':costMin'] = (float) $costMin;
        }
        if ($costMax) {
            $queryBuilder->andWhere('h.price <= :costMax');
            $parametrs[':costMax'] = $costMax;
        }
        if ($bedrooms !== '#') {
            $queryBuilder->andWhere('h.bedrooms = :bedrooms');
            $parametrs[':bedrooms'] = $bedrooms;
        }
        if ($bathrooms !== '#') {
            $queryBuilder->andWhere('h.bathrooms = :bathrooms');
            $parametrs[':bathrooms'] = $bathrooms;
        }
        if ($garages !== '#') {
            $queryBuilder->andWhere('h.garages = :garages');
            $parametrs[':garages'] = $garages;
        }
        if ($storeys !== '#') {
            $queryBuilder->andWhere('h.storeys = :storeys');
            $parametrs[':storeys'] = $storeys;
        }
        $houses = $queryBuilder->setParameters($parametrs)->getQuery()->getResult();
        if ($houses) {
            $result = $serializer->serialize($houses, 'json', [AbstractNormalizer::IGNORED_ATTRIBUTES => ['id']]);
        }
        return new Response($result);
    }
}