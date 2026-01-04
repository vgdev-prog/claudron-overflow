<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Answer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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
}
