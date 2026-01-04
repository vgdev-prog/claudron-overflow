<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Answer;
use App\Repository\AnswerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\QueryException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AnswerController extends AbstractController
{
    /**
     */
    #[Route(path:'/answers/{answer}/vote/{direction<up|down>}', name: 'app_answers_vote', methods: ['POST'])]
    public function answerVote(Answer $answer, string $direction, Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        if ($direction === Answer::VOTE_UP) {
            $answer->setVotes($answer->getVotes() + 1);
        } else if ($direction === Answer::VOTE_DOWN) {
            $answer->setVotes($answer->getVotes() - 1);
        }

        $entityManager->flush();

        return new JsonResponse([
            'votes' => $answer->getVotes(),
        ]);

    }

    /**
     * @throws QueryException
     */
    #[Route('/answers/popular', name: 'app_answers_popular', methods: ['GET'])]
    public function popularAnswers(AnswerRepository $answerRepository, Request $request): Response
    {
        $query = $request->query->get('q');

        $answers = $answerRepository->findMostPopular($query);
        return $this->render('answer/popular.html.twig', [
            'answers' => $answers,
        ]);
    }
}
