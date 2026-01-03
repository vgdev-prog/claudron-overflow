<?php

namespace App\Controller;

use App\Entity\Question;
use App\Repository\QuestionRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

class QuestionController extends AbstractController
{
    #[Route('/', name: 'app_homepage', methods: ['GET'])]
    public function homepage(QuestionRepository $repository): Response
    {

        return $this->render('question/homepage.html.twig', [
            'questions' => $repository->findAllAskedOrderByNewestAndNotNull()
        ]);
    }

    /**
     * @throws Exception
     */
    #[Route(path: '/questions/new', name: 'app_question_new', methods: ['GET', 'PATCH'])]
    public function new(EntityManagerInterface $entityManager, TagAwareCacheInterface $cache): Response
    {
        return new Response('This will be migrated to fixtures');
    }

    #[Route('/questions/{slug}', name: 'app_question_show', methods: ['GET'])]
    public function show(string $slug, EntityManagerInterface $entityManager): Response
    {
        $repository = $entityManager->getRepository(Question::class);
        $question = $repository->findOneBy(['slug' => $slug]);

        if (!$question) {
            throw $this->createNotFoundException('Question not found');
        }

        $answers = [
            'Make sure  your  cat is sitting purrfectcly still',
            'Honestly, I like furry shoes better than MY cat',
            'Maybe... Try saying spell backwards?'
        ];

        return $this->render('question/show.html.twig', [
            'question' => $question,
            'answers' => $answers
        ]);
    }

    #[Route(path: '/questions/{slug}/vote', name: 'app_question_vote', methods: ['POST'])]
    public function questionVote(
        #[MapEntity(mapping: ['slug' => 'slug'])]
        Question               $question,
        Request                $request,
        EntityManagerInterface $entityManager,
    ): Response
    {
        $direction = $request->request->get('direction');
        if ($direction === 'up') {
            $question->upVotes();
        } else if ($direction === 'down') {
            $question->downVotes();
        }

        $entityManager->flush();

        return $this->redirectToRoute('app_homepage');
    }
}
