<?php

namespace App\Controller;

use App\Entity\Question;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class QuestionController extends AbstractController
{
    #[Route('/', name: 'app_homepage', methods: ['GET'])]
    public function homepage(EntityManagerInterface $entityManager): Response
    {
        $questions = $entityManager->getRepository(Question::class)->findAll();

        return $this->render('question/homepage.html.twig',[
            'questions' => $questions
        ]);
    }

    /**
     * @throws Exception
     */
    #[Route(path: '/questions/new', name: 'app_question_new', methods: ['GET', 'PATCH'])]
    public function new(EntityManagerInterface $entityManager): Response
    {
        $question = new Question();
        $name = 'Missing Pants';
        $question->setName($name);
        $question->setSlug((implode('-', array_map('mb_strtolower',explode(' ', $name))) . '-' . rand(0, 100)));

        $question->setQuestion(<<<EOF
        ---
        Hi! So... I'm having a *weird* day. Yesterday, I cast a spell\
        to make my dishes wash themselves. But while I was casting it,\
        I slipped a little and I think `I also hit my pants with the spell`

        When i woke up this morning, I caught a quick glimpse of my panths\
        opening the front door and walking out! I've been out all afternoon\
        (with no pants mind you) searching of them.

        Does anyone have a spell to call your pants back?
        EOF
        );

        if (rand(1, 10) > 2) {
            $question->setAskedAt(new DateTimeImmutable(sprintf('-%d days', rand(1, 100))));
        }

        $entityManager->persist($question);
        $entityManager->flush();

        return new JsonResponse(
            data: [
                'id' => $question->getId(),
                'name' => $question->getName(),
                'slug' => $question->getSlug(),
                'asked_at' => $question->getAskedAt()?->format('Y-m-d H:i:s'),
            ]
        );
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


}
