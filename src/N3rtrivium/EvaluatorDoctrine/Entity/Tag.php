<?php

namespace N3rtrivium\EvaluatorDoctrine\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity @Table(name="tags")
 */
class Tag
{
    /**
     * @Id 
     * @GeneratedValue 
     * @Column(type="integer")
     * 
     * @var int
     */
    protected $id;
    
    /**
     * @Column(type="string")
     * @var string
     */
    protected $name;
    
    /**
     * @ManyToMany(targetEntity="N3rtrivium\EvaluatorDoctrine\Entity\Post", mappedBy="tags")
     * @var Post[]
     **/
    protected $posts;
    
    public function __construct()
    {
    	$this->posts = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
    
    public function addPost(\N3rtrivium\EvaluatorDoctrine\Entity\Post $post)
    {
    	$this->posts[] = $post;
    	return $this;
    }
    
    public function removePost(\N3rtrivium\EvaluatorDoctrine\Entity\Post $post)
    {
    	$this->posts->removeElement($post);
    	return $this;
    }
    
    public function getPosts()
    {
    	return $this->posts;
    }
}