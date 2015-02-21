<?php

namespace N3rtrivium\EvaluatorDoctrine;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use N3rtrivium\EvaluatorDoctrine\Entity\Post;
use N3rtrivium\EvaluatorDoctrine\Entity\User;
use N3rtrivium\EvaluatorDoctrine\Entity\Tag;

class App
{
	/**
	 * @var boolean
	 */
	private $debug = false;
	
	/**
	 * @var EntityManagerInterface
	 */
	private $em;
	
	public function __construct(EntityManagerInterface $em, $debug = false)
	{
		$this->em = $em;
		$this->debug = $debug;
	}
	
	public function handle()
	{
		$request = Request::createFromGlobals();
		$response = null;
		
		$path = $request->getPathInfo();
		if ($path == '/') {
			$response = $this->index($request);
		}
		
		if ($path == '/gen') {
			$response = $this->generateDemoData($request);
		}
		
		if (!$response) {
			$response = $this->notFound($request);
		}
		
		$response->prepare($request);
		
		$response->send();
	}
	
	public function index(Request $req)
	{
		$posts = $this->em->getRepository('N3rtrivium\EvaluatorDoctrine\Entity\Post')->findBy(array(), array('title' => 'DESC'));
		
		$content = '<div>';
		foreach ($posts as $post) {
			$content .= '<hr><div>';
			$content .= '<h2>'.$post->getTitle().'</h2>';
			$content .= '<p>'.$post->getContent().'<p>';
			$content .= '<p>'.$post->getAuthor()->getName().'</p>';
			$content .= '<p>';
			foreach ($post->getTags() as $tag) {
				$content .= $tag->getName().', ';
			}
			$content .= '</p>';
			$content .= '</div>';
		}
		
		return new Response('<h1>Posts</h1>'.$content);
	}
	
	public function generateDemoData(Request $req)
	{
		$post = new Post();
		$post->setTitle($this->generateRandomString(16));
		$post->setContent($this->generateRandomString(300));
		
		$users = $this->em->getRepository('N3rtrivium\EvaluatorDoctrine\Entity\User')->findAll();
		
		$post->setAuthor($this->selectRandom($users));
		
		$tags = $this->em->getRepository('N3rtrivium\EvaluatorDoctrine\Entity\Tag')->findAll();
		
		$firstTag = $this->selectRandom($tags);
		do {
			$secondTag = $this->selectRandom($tags);
		} while ($firstTag->getId() == $secondTag->getId());
		$post->addTag($firstTag);
		$post->addTag($secondTag);
		
		$this->em->persist($post);
		$this->em->flush();
		
		return new Response('Post '.$post->getId().' added');
	}
	
	public function notFound(Request $req)
	{
		return new Response('file not found', 404);
	}
	
	private function selectRandom(array $list)
	{
		return $list[rand(0, count($list) - 1)];
	}
	
	private function generateRandomString($length = 10) {
		$characters = '0123456789    abcdefghijkl   mnopqrstuvwxyz    ABCDEFGHIJKLMN   OPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
}