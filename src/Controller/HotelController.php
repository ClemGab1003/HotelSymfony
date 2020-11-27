<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Chambre;
use App\Entity\Employee;
use Symfony\Component\HttpFoundation\Request;

class HotelController extends AbstractController
{
    /**
     * @Route("/hotel", name="home")
     */
    public function index(): Response
    {
        $repo = $this->getDoctrine()->getRepository(Chambre::class);

        $chambres = $repo->findAll();

        return $this->render('hotel/index.html.twig', [
            'controller_name' => 'HotelController',
            'chambres' => $chambres
        ]);
    }

    /**
     * @Route("/createroom", name="createroom")
     */
     public function createroom() {
        return $this->render('hotel/createroom.html.twig');
    }

    /**
     *@Route("/manager", name="manager")
     */
    public function manager() {
        $repo = $this->getDoctrine()->getRepository(Chambre::class);

                $chambres = $repo->findAll();

                return $this->render('hotel/manager.html.twig', [
                    'controller_name' => 'HotelController',
                    'chambres' => $chambres
                ]);

    }

     /**
      *@Route("/reserve/{id}", name="reserve")
      */
        public function reserver (Request $request, $id) {
                                         $entityManager = $this->getDoctrine()->getManager();
                                         $chambre = $entityManager->getRepository(Chambre::class)->find($id);

                    $chambre = $chambre->setStatus("Occupe");
                    $entityManager->flush();

                    return $this->redirectToRoute('manager');

        }

        /**
         *@Route("/libre/{id}", name="libre")
         */
          public function libre (Request $request, $id) {
                                            $entityManager = $this->getDoctrine()->getManager();
                                            $chambre = $entityManager->getRepository(Chambre::class)->find($id);

                            $chambre = $chambre->setStatus("Libre");
                            $entityManager->flush();

                            return $this->redirectToRoute('manager');

          }

          /**
           *@Route("/netoyage/{id}", name="netoyage")
           */
             public function netoyage (Request $request, $id) {
                                            $entityManager = $this->getDoctrine()->getManager();
                                            $chambre = $entityManager->getRepository(Chambre::class)->find($id);

                             $chambre = $chambre->setStatus("A nettoyer");
                             $entityManager->flush();

                             return $this->redirectToRoute('manager');

             }

        /**
        *@Route("/api/get/employees", name="getEmploye")
        */
        public function () {
          $employe = $this->getDoctrine()->getRepository(Employee::class)->findAll();

          $employetab = array();
          foreach ($employe as $employee){

              $employetab[] = [
                  'username' => $employee->getUsername(),
                  'password' => $employee->getPassword()
              ];
          }


          $response = new JsonResponse($employetab);
          return $response;
        }
}
