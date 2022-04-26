<?php


namespace App\Services;


use App\Entity\Comment;
use App\Entity\User;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class CommentService
 * @package App\Services
 */
class CommentService
{
    private $commentRepository;
    private $entityManager;

    /**
     * CommentService constructor.
     * @param EntityManagerInterface $entityManager
     * @param CommentRepository $commentRepository
     */
    public function __construct(EntityManagerInterface $entityManager, CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @param User $user
     * @param string $text
     * @return bool
     */
    public function add(User $user, string $text)
    {
        $comment = new Comment();
        $comment->setUser($user);
        $comment->setText($text);
        $this->entityManager->persist($comment);
        $this->entityManager->flush();
        return true;
    }

    /**
     * @param User $user
     * @param int $commentId
     * @param string $text
     * @return bool
     */
    public function edit(User $user, int $commentId, string $text)
    {
        $comment = $this->commentRepository->findOneBy(['user' => $user, 'id' => $commentId]);
        $comment->setText($text);
        $this->entityManager->persist($comment);
        $this->entityManager->flush();
        return true;
    }

    /**
     * @param User $user
     * @param int $commentId
     * @return bool
     */
    public function delete(User $user, int $commentId)
    {
        $comment = $this->commentRepository->findOneBy(['user' => $user, 'id' => $commentId]);
        $this->entityManager->remove($comment);
        $this->entityManager->flush();
        return true;
    }

    /**
     * @param User $user
     * @return array
     */
    public function show(User $user)
    {
        $comments = $this->commentRepository->findBy(['user' => $user], ['updatedAt' => 'DESC']);
        $result = [];
        foreach ($comments as $keyComment => $comment) {
            /*** @var Comment ** */
            $result[$keyComment]['id'] = $comment->getId();
            $result[$keyComment]['text'] = $comment->getText();
            $result[$keyComment]['updatedAt'] = $comment->getUpdatedAt()->format('Y.m.d');
        }
        return $result;
    }
}