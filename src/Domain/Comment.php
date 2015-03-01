<?php
namespace MicroCMS\Domain;

class Comment
{
    /**
     * Comment id.
     *
     * @var integer
     */
    protected $id;

    /**
     * Comment content.
     *
     * @var string
     */
    protected $content;

    /**
     * Comment author.
     *
     * @var \MicroCMS\Domain\User
     */
    protected $author;

    /**
     * Associated article
     *
     * @var \MicroCMS\Domain\Article
     */
    protected $article;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function setAuthor(User $author)
    {
        $this->author = $author;
        return $this;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    public function getArticle()
    {
        return $this->article;
    }

    public function setArticle(Article $article)
    {
        $this->article = $article;
        return $this;
    }
}