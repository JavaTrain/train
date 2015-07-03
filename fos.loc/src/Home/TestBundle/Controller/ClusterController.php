<?php

namespace Home\TestBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Home\TestBundle\Entity\Cluster;
use Home\TestBundle\Form\ClusterType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


/**
 * Cluster controller.
 *
 * @Route("/cluster")
 */
class ClusterController extends Controller
{

    /**
     * Finds and displays a user payments in the Group entity.
     *
     * @Route("/user/{uid}/group/{gid}", name="payments_show")
     * @Method("GET")
     * @Template("HomeTestBundle:Cluster:payments.html.twig")
     */
    public function paymentsAction($uid, $gid)
    {

        if($this->getUser()->getId() != $uid){
            if(!in_array('ROLE_ADMIN', $this->getUser()->getRoles())){
                throw $this->createAccessDeniedException();
            }
        }

        $repository = $this->getDoctrine()->getRepository('HomeTestBundle:Cluster');

        $entities = $repository->findPayments($uid,$gid);

        if (!$entities) {
            throw $this->createNotFoundException('Unable to find Group entity.');
        }

        return array(
            'entities' => $entities[0],
            'loan' => $entities[1],
        );
    }

    /**
     * Lists all Cluster entities.
     *
     * @Route("/", name="cluster")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            throw $this->createAccessDeniedException();
        }

        $repository = $this->getDoctrine()->getRepository('HomeTestBundle:Cluster');


        if (in_array('ROLE_ADMIN', $this->getUser()->getRoles())) {
            $entities = $repository->findByCourseRoleId();
        }else{


            $id = $this->getUser()->getId();

            $entities = $repository->findByCourseRoleId(null, null, $id, null);
        }

//        if (!$entities) {
//            throw $this->createNotFoundException('Unable to find Group entity.');
//        }
//
//        if (!$entities) {
//            $entities = null;
//        }

        return array(
            'entities' => $entities
        );

    }
    /**
     * Creates a new Cluster entity.
     *
     * @Route("/", name="cluster_create")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("POST")
     * @Template("HomeTestBundle:Cluster:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Cluster();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('cluster_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Cluster entity.
     *
     * @param Cluster $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Cluster $entity)
    {
        $form = $this->createForm(new ClusterType(), $entity, array(
            'action' => $this->generateUrl('cluster_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Cluster entity.
     *
     * @Route("/new", name="cluster_new")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Cluster();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Cluster entity.
     *
     * @Route("/{id}", name="cluster_show")
     * @Method("GET")
     * @Security("has_role('ROLE_USER')")
     * @Template()
     */
    public function showAction($id)
    {
        $repository = $this->getDoctrine()->getRepository('HomeTestBundle:Cluster');

        if (in_array('ROLE_ADMIN', $this->getUser()->getRoles())){
            $entity = $repository->findByCourseRoleId(null, null, null, $id);
        }else{

        $arr = array();

        foreach ($this->getUser()->getClusters() as $val)
        $arr[] = $val->getId();

        if (!in_array($id, $arr))
        throw $this->createAccessDeniedException();
            //var_dump($arr);die();

        $entity = $repository->findByCourseRoleId(null, null, null, $id);
        }

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Group entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'self' => $this->getUser(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Cluster entity.
     *
     * @Route("/{id}/edit", name="cluster_edit")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HomeTestBundle:Cluster')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Cluster entity.');
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
    * Creates a form to edit a Cluster entity.
    *
    * @param Cluster $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Cluster $entity)
    {
        $form = $this->createForm(new ClusterType(), $entity, array(
            'action' => $this->generateUrl('cluster_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Cluster entity.
     *
     * @Route("/{id}", name="cluster_update")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("PUT")
     * @Template("HomeTestBundle:Cluster:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HomeTestBundle:Cluster')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Cluster entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('cluster_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Cluster entity.
     *
     * @Route("/{id}", name="cluster_delete")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('HomeTestBundle:Cluster')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Cluster entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('cluster'));
    }

    /**
     * Creates a form to delete a Cluster entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cluster_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
