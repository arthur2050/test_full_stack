<?php


namespace App\Controller;

use App\Entity\User;
use App\Services\CommentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CommentController
 * @package App\Controller
 * @Route("/comment")
 */
class CommentController extends AbstractController
{
    private $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    /**
     * @Route("/add/{id}")
     * @param User $user
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse|HttpException
     */
    public function add(User $user, Request $request)
    {
        $textComment = $request->request->get('text');
        if ($textComment == null || $textComment == '' || $textComment == 'null') return new HttpException(400, 'Text field can\'t be null');
        $success = $this->commentService->add($user, $textComment);
        $answer = [
            'success' => $success
        ];
        return $this->json($answer);
    }

    /**
     * @Route("/edit/{id}/{commentId}")
     * @param User $user
     * @param int $commentId
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse|HttpException
     */
    public function edit(User $user, int $commentId, Request $request)
    {
        $textComment = $request->request->get('text');
        if ($textComment == null || $textComment == '' || $textComment == 'null') return new HttpException(400, 'Text field can\'t be null');
        $success = $this->commentService->edit($user, $commentId, $textComment);
        $answer = [
            'success' => $success,
            'commentId' => $commentId
        ];
        return $this->json($answer);
    }

    /**
     * @Route("/delete/{id}/{commentId}")
     * @param User $user
     * @param int $commentId
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function delete(User $user, int $commentId)
    {
        $success = $this->commentService->delete($user, $commentId);
        $answer = [
            'success' => $success,
            'commentId' => $commentId
        ];
        return $this->json($answer);
    }

    /**
     * @Route("/show/{id}")
     * @param User $user
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function show(User $user)
    {
        $comments = $this->commentService->show($user);
        $success = false;
        if (!empty($comments)) {
            $success = true;
        }
        $answer = [
            'success' => $success,
            'comments' => $comments
        ];
        return $this->json($answer);
    }
}