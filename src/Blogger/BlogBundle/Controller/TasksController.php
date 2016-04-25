<?php

namespace Blogger\BlogBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Blogger\BlogBundle\Entity\Tasks;
use Blogger\BlogBundle\Form\TasksType;

/**
 * Tasks controller.
 *
 * @Route("/tasks")
 */
class TasksController extends Controller
{

    /**
     * Lists all Tasks entities.
     *
     * @Route("/tasks", name="tasks")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $entity = new Tasks();
        $entity->setUser($this->getUser());
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BloggerBlogBundle:Tasks')->findByUser($this->getUser());

   //     if ($this->getUser() !=   $entities ){
     //       throw  $this->createAccessDeniedException("Nie masz uprawnien do edycji nie swoich zadan.");}

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Tasks entity.
     *
     * @Route("/", name="tasks_create")
     * @Method("POST")
     * @Template("BloggerBlogBundle:Tasks:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Tasks();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $entity->setUser($this->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('tasks_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Tasks entity.
     *
     * @param Tasks $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Tasks $entity)
    {
        $form = $this->createForm(new TasksType(), $entity, array(
            'action' => $this->generateUrl('tasks_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Tasks entity.
     *
     * @Route("/new", name="tasks_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Tasks();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Tasks entity.
     *
     * @Route("/{id}", name="tasks_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BloggerBlogBundle:Tasks')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tasks entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Tasks entity.
     *
     * @Route("/{id}/edit", name="tasks_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BloggerBlogBundle:Tasks')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tasks entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Tasks entity.
    *
    * @param Tasks $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Tasks $entity)
    {
        $form = $this->createForm(new TasksType(), $entity, array(
            'action' => $this->generateUrl('tasks_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Tasks entity.
     *
     * @Route("/{id}", name="tasks_update")
     * @Method("PUT")
     * @Template("BloggerBlogBundle:Tasks:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BloggerBlogBundle:Tasks')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tasks entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('tasks_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Tasks entity.
     *
     * @Route("/{id}", name="tasks_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BloggerBlogBundle:Tasks')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Tasks entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('tasks'));
    }

    /**
     * Creates a form to delete a Tasks entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tasks_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
