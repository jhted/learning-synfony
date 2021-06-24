<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\BlogPost;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;
use Symfony\Flex\Response;


/**
 * @Route("/blog")
 */
class BlogController extends AbstractController
{
    /**
     * @Route("/", name="blog_list", defaults={"page"=1}, requirements={"page"="\d+"}, methods={"GET"})
     */
    public function list($page = 1): JsonResponse
    {
        $repository = $this->getDoctrine()->getRepository(BlogPost::class);
        $items = $repository->findAll();
        return $this->json(
            [
                'page' => $page,
                'data' => array_map(function (BlogPost $item)
                {
                    return $this->generateUrl('blog_by_slug',['slug'=> $item->getSlug()]);
                } , $items)
            ]
        );
    }
    /**
     * @Route("/post/{id}", name="blog_by_id", requirements={"id"="\d+"}, defaults={"id"= 1}, methods={"GET"})
     */
    public function post($id)
    {
        return $this->json(
            $this->getDoctrine()->getRepository(BlogPost::class)->find($id)
        );
    }
    /**
     * @Route("/post/{slug}", name="blog_by_slug", methods={"GET"})
     */
    public function postBySlug($slug)
    {
        return $this->json(
            $this->getDoctrine()->getRepository(BlogPost::class)->findOneBy(['slug'=>$slug])
        );
    }
    /**
     * @Route("/add", name="blog_add" , methods={"POST"})
     */
    public function add(Request $request): JsonResponse
    {
        /** @var Serializer $serializer */
        $serializer = $this->get('serializer');

        $blogPost = $serializer->deserialize($request->getContent(), BlogPost::class, 'json');

        $em = $this->getDoctrine()->getManager();
        $em->persist($blogPost);
        $em->flush();

        return $this->json($blogPost);
    }
    /**
     * @Route("/post/{id}", name="blog_by_slug", methods={"DELETE"})
     */
    public function delete(BlogPost $post)
    {

        $em = $this->getDoctrine()->getManager();
        $em->remove($post);
        $em->flush();

        return new Request(null, Response::HTTP_NO_CONTENT);
    }
}
