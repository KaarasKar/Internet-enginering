<?php
// src/Blogger/BlogBundle/Form/CommentType.php



namespace Blogger\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterFace $builder, array $options)
    {
        $builder->add('user','text');
        $builder->add('comment','textarea');
    }

    public function getName()
    {
        return 'blogger_blogbundle_commenttype';
    }
}
