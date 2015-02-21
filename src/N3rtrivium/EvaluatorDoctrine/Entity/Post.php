<?php

namespace N3rtrivium\EvaluatorDoctrine\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity 
 * @Table(name="posts")
 **/
class Post
{
    /**
     * @Id
     * @GeneratedValue 
     * @Column(type="integer")
     * @var int
     */
    protected $id;
    
    /**
     * @Column(type="string", length=255)
     * @var string
     */
    protected $title;
    
    /**
     * @Column(type="text")
     * @var string
     */
    protected $content;
    
    /**
     * @ManyToOne(targetEntity="N3rtrivium\EvaluatorDoctrine\Entity\User", inversedBy="posts")
     * @var User
     **/
    protected $author;
    
    /**
     * @ManyToMany(targetEntity="N3rtrivium\EvaluatorDoctrine\Entity\Tag", inversedBy="posts")
     * @var Tag[]
     **/
    protected $tags;
    
    public function __construct()
    {
    	$this->tags = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
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
	
	public function getAuthor()
	{
		return $this->author;
	}
	
	public function setAuthor(\N3rtrivium\EvaluatorDoctrine\Entity\User $author = null)
	{
		if ($author) {
			$author->addPost($this);
		}
		$this->author = $author;
		return $this;
	}
	
	public function addTag(\N3rtrivium\EvaluatorDoctrine\Entity\Tag $tag)
	{
		$this->tags[] = $tag;
		$tag->addPost($this);
		return $this;
	}
	
	public function removeTag(\N3rtrivium\EvaluatorDoctrine\Entity\Tag $tag)
	{
		$this->tags->removeElement($tag);
		$tag->removePost($this);
		return $this;
	}
	
	public function getTags()
	{
		return $this->tags;
	}
}