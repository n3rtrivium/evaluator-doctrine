<?php

namespace N3rtrivium\EvaluatorDoctrine\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity @Table(name="users")
 */
class User
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
     * @OneToMany(targetEntity="N3rtrivium\EvaluatorDoctrine\Entity\Post", mappedBy="author")
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
    
    public function getPosts()
    {
    	return $this->posts;
    }
}