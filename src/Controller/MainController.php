<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\HouseRepository;

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
     * @Route("/search", name="serchHouse"),
     */
    public function serchHouse(HouseRepository $houseRepository)
    {

        return $this->render("searchHouse.html.twig", ["House" => $houseRepository->findAll()]);
    }
}