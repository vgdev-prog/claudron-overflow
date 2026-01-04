<?php

declare(strict_types=1);

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CommentController extends AbstractController
{
    #[Route(path:'/comments/{id}/vote/{direction<up|down>}', name: 'app_comment_vote', methods: ['POST'])]
    public function commentVote(int $id, string $direction, LoggerInterface $logger): JsonResponse
    {
        // todo use id to query database
        $logger->info("Comment vote started");
        //use real logic here to save this to the database
        if ($direction === 'up') {
            $currentVoteCount = rand(7,100);
        } else {
            $currentVoteCount = rand(0,5);
        }

        return new JsonResponse([
            'votes' => $currentVoteCount,
        ]);

    }

    #[Route(path: '/comments')]
    public function index(): Response
    {
        return $this->render('comment/index.html.twig');
    }

    #[Route(path: '/comments')]
    public function new()
    {

    }
}
