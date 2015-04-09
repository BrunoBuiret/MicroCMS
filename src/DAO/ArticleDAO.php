<?php
namespace MicroCMS\DAO;

use MicroCMS\Domain\Article;

class ArticleDAO extends DAO
{
    /**
     * Returns an article matching the supplied id.
     *
     * @param integer $id
     * @return \MicroCMS\Domain\Article|throws an exception if no matching article is found
     */
    public function find($id)
    {
        if($row = $this->db->fetchAssoc('SELECT * FROM t_article WHERE art_id = ?', array($id)))
            return $this->buildDomainObject($row);
        else
            throw new \Exception('No article matching id '.$id);
    }

    /**
     * Return a list of all articles, sorted by date (most recent first).
     *
     * @return array A list of all articles.
     */
    public function findAll()
    {
        $result = $this->db->fetchAll('SELECT * FROM t_article ORDER BY art_id DESC');
        $articles = array();

        foreach($result as $row)
            $articles[$row['art_id']] = $this->buildDomainObject($row);

        return $articles;
    }

        /**
     * Saves an article into the database.
     *
     * @param \MicroCMS\Domain\Article $article The article to save
     */
    public function save(Article $article)
    {
        $articleData = array(
            'art_title' => $article->getTitle(),
            'art_content' => $article->getContent(),
        );

        if ($article->getId())
            // The article has already been saved : update it
            $this->db->update('t_article', $articleData, array('art_id' => $article->getId()));
        else
        {
            // The article has never been saved : insert it
            $this->db->insert('t_article', $articleData);
            // Get the id of the newly created article and set it on the entity.
            $id = $this->db->lastInsertId();
            $article->setId($id);
        }
    }

    /**
     * Removes an article from the database.
     *
     * @param integer $id The article id.
     */
    public function delete($id)
    {
        // Delete the article
        $this->db->delete('t_article', array('art_id' => $id));
    }

    protected function buildDomainObject($row)
    {
        $article = new Article();
        $article->setId($row['art_id'])
                ->setTitle($row['art_title'])
                ->setContent($row['art_content']);
        return $article;
    }
}
