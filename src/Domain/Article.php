<?php
namespace MicroCMS\Domain;

class Article
{
    /**
     * Article id.
     *
     * @var integer
     */
    protected $id;

    /**
     * Article title.
     *
     * @var string
     */
    protected $title;

    /**
     * Article content.
     *
     * @var string
     */
    protected $content;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
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
}
