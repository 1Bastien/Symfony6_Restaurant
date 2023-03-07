<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Form\CustomerInfoFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    #[Route('/account/{id}', name: 'app_account', methods: ['GET', 'POST'])]  
    public function edit(Customer $customer, Request $request, EntityManagerInterface $manager, $id): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
        if ($this->getUser() !== $customer) {
            return $this->redirectToRoute('home');
        }
        
        $form = $this->createForm(CustomerInfoFormType::class, $customer);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
                $customer = $form->getData();
                $manager->persist($customer);
                $manager->flush();

                $this->addFlash(
                    'sucess',
                    'Les informations ont été enregistrées avec succès.'
                );
                return $this->redirectToRoute('home');

        }
        
        return $this->render('account/index.html.twig', [
            'CustomerInfoForm' => $form->createView(),
        ]);
    }
}


