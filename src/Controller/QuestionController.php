<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class QuestionController extends AbstractController
{
    #[Route('/', name: 'app_home', methods: ['GET'])]
    public function homepage():Response
    {
        return new Response('Hello World!');
    }

    #[Route('/question/{slug}', name: 'app_show', methods: ['GET'])]
    public function show(string $slug): Response
    {
        $answers = [
            'Make sure  your  cat is sitting purrfectcly still',
            'Honestly, I like furry shoes better than MY cat',
            'Maybe... Try saying spell backwards?'
        ];
        return $this->render('question/show.html.twig', [
            'question' => ucwords(str_replace('-', ' ', $slug)),
            'answers' => $answers
        ]);
    }
}
