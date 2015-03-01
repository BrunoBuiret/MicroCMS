<?php
namespace MicroCMS\DAO;

use Doctrine\DBAL\Connection;
use MicroCMS\Domain\Comment;

class CommentDAO extends DAO
{
    /**
     * @var \MicroCMS\DAO\UserDAO
     */
    protected $userDAO;

    /**
     * @var \MicroCMS\DAO\ArticleDAO
     */
    protected $articleDAO;

    public function setArticleDAO(ArticleDAO $articleDAO)
    {
        $this->articleDAO = $articleDAO;
        return $this;
    }

    public function setUserDAO(UserDAO $userDAO)
    {
        $this->userDAO = $userDAO;
        return $this;
    }

    /**
     * Returns a comment matching the supplied id.
     *
     * @param integer $id The comment id
     *
     * @return \MicroCMS\Domain\Comment|throws an exception if no matching comment is found
     */
    public function find($id)
    {
        $row = $this->db->fetchAssoc('SELECT * FROM t_comment WHERE com_id = ?', array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception('No comment matching id '.$id);
    }

    /**
     * Returns a list of all comments, sorted by date (most recent first).
     *
     * @return array A list of all comments.
     */
    public function findAll()
    {
        $result = $this->db->fetchAll('SELECT * FROM t_comment ORDER BY com_id DESC');

        // Convert query result to an array of domain objects
        $entities = array();

        foreach ($result as $row)
            $entities[$row['com_id']] = $this->buildDomainObject($row);

        return $entities;
    }

    /**
     * Return a list of all comments for an article, sorted by date (most recent first).
     *
     * @param integer $articleId The article id.
     * @return array A list of all comments for the article.
     */
    public function findAllByArticle($articleId)
    {
        $article = $this->articleDAO->find($articleId);
        $result = $this->db->fetchAll(
            'SELECT com_id, com_content, u.usr_id '.
            'FROM t_comment c '.
            'INNER JOIN t_user u ON u.usr_id = c.usr_id '.
            'WHERE art_id = ? '.
            'ORDER BY com_id DESC',
            array($articleId)
        );
        $comments = array();

        foreach($result as $row)
        {
            $comment = $this->buildDomainObject($row);
            $comment->setArticle($article);
            $comments[$row['com_id']] = $comment;
        }

        return $comments;
    }

    /**
     * Saves a comment into the database.
     *
     * @param \MicroCMS\Domain\Comment $comment The comment to save
     */
    public function save(Comment $comment)
    {
        $commentData = array(
            'art_id' => $comment->getArticle()->getId(),
            'usr_id' => $comment->getAuthor()->getId(),
            'com_content' => $comment->getContent()
        );

        if ($comment->getId())
        {
            // The comment has already been saved : update it
            $this->db->update('t_comment', $commentData, array('com_id' => $comment->getId()));
        }
        else
        {
            // The comment has never been saved : insert it
            $this->db->insert('t_comment', $commentData);
            // Get the id of the newly created comment and set it on the entity.
            $id = $this->db->lastInsertId();
            $comment->setId($id);
        }
    }

    /**
     * Removes a comment from the database.
     *
     * @param @param integer $id The comment id
     */
    public function delete($id)
    {
        // Delete the comment
        $this->db->delete('t_comment', array('com_id' => $id));
    }

    /**
     * Removes all comments for an article
     *
     * @param $articleId The id of the article
     */
    public function deleteAllByArticle($articleId)
    {
        $this->db->delete('t_comment', array('art_id' => $articleId));
    }

    /**
     * Removes all comments for a user
     *
     * @param integer $userId The id of the user
     */
    public function deleteAllByUser($userId)
    {
        $this->db->delete('t_comment', array('usr_id' => $userId));
    }

    /**
     * Creates an Comment object based on a DB row.
     *
     * @param array $row The DB row containing Comment data.
     * @return \MicroCMS\Domain\Comment
     */
    protected function buildDomainObject($row)
    {
        $comment = new Comment();
        $comment->setId($row['com_id']);
        $comment->setContent($row['com_content']);

        if(array_key_exists('art_id', $row))
            // Find and set the associated article
            $comment->setArticle($this->articleDAO->find($row['art_id']));

        if(array_key_exists('usr_id', $row))
            $comment->setAuthor($this->userDAO->find($row['usr_id']));

        return $comment;
    }
}