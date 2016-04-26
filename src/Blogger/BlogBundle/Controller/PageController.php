<?php
// src/Blogger/BlogBundle/Controller/PageController.php

namespace Blogger\BlogBundle\Controller;

use stdClass;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Blogger\BlogBundle\Entity\Enquiry;
use Blogger\BlogBundle\Form\EnquiryType;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;



class PageController extends Controller
{

    public function indexAction()
    {
        $em = $this->getDoctrine()
            ->getEntityManager();

        $blogs = $em->getRepository('BloggerBlogBundle:Blog')
            ->getLatestBlogs();

        return $this->render('BloggerBlogBundle:Page:index.html.twig', array(
            'blogs' => $blogs
        ));
    }



    public function aboutAction()
    {
        return $this->render('BloggerBlogBundle:Page:about.html.twig');

    }


    public function contactAction()
    {
       return $this->render('BloggerBlogBundle:Page:contact.html.twig');

    }

    public function emailSendAction(Request $request)
    {
        $em=$request->getContent();
        $json=json_decode($em);

        $enquiry = new Enquiry();
        $form = $this->createForm(new EnquiryType(), $enquiry);

        $result = new stdClass();
        $result->result=false;

        if ($request->getMethod() == 'POST') {
            $form->bind($request);
            $message = \Swift_Message::newInstance()
                ->setSubject($request->request->get('content'))
                ->setFrom($request->request->get('senderEmail'))
                ->setTo($this->container->getParameter('blogger_blog.emails.contact_email'))
                ->setBody($this->renderView('BloggerBlogBundle:Page:contactEmail.txt.twig', array('enquiry' => $enquiry)));
            $result->result=true;
        }

   //     $result->requestData=$json;
        $form->requestData=$json;
        $json->content;
        return new JsonResponse($form);
    }


    public function sidebarAction()
    {
        $em = $this->getDoctrine()
            ->getEntityManager();

        $tags = $em->getRepository('BloggerBlogBundle:Blog')
            ->getTags();

        $tagWeights = $em->getRepository('BloggerBlogBundle:Blog')
            ->getTagWeights($tags);

        $commentLimit   = $this->container
            ->getParameter('blogger_blog.comments.latest_comment_limit');
        $latestComments = $em->getRepository('BloggerBlogBundle:Comment')
            ->getLatestComments($commentLimit);

        return $this->render('BloggerBlogBundle:Page:sidebar.html.twig', array(
            'latestComments'    => $latestComments,
            'tags'              => $tagWeights
        ));
    }

}