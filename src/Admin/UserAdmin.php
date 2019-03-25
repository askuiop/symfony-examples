<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\User;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

final class UserAdmin extends AbstractAdmin
{

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('id')
            ->add('username')
            ->add('roles')
            ->add('createdAt')
            ;
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->add('id')
            ->add('username')
            ->add('roles', null, [
                'template' => 'Admin/common/td_array_display.html.twig'
            ])
            ->add('xx', 'url', [
                'url' => 'http://example.com',
                //'route' => [
                //    'name' => 'admin.top',
                //    'absolute' => true,
                //    //'parameters' => ['format' => 'xml'],
                //    //'identifier_parameter_name' => 'id'
                //]

            ])
            ->add('createdAt', null, [

                'header_class' => 'myClass',
                'header_style' => 'text-align: right',
                'row_align' => 'right',
                'label' => false,
                'label_icon' => 'fa fa-clock-o',
                'format' => "y/m/d H:i:s"
            ])
            ->add('updatedAt', null, [
                'format' => "y/m/d H:i:s",
            ])
            ->add('_action', null, [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ],
            ]);
    }

    protected function configureFormFields(FormMapper $formMapper): void
    {
        $formMapper
            //->add('id')
            ->add('username', null, [
                'constraints'     => [
                    new NotBlank(),
                ]
            ])
            //->add('roles')
            ->add('plainPassword', RepeatedType::class, [
                'type'            => PasswordType::class,
                'first_options'   => array('label' => 'New Password'),
                'second_options'  => array('label' => 'Repeat New Password'),
                'invalid_message' => '两次密码输入不一致',
                //'error_bubbling' => true,
                'constraints'     => [
                    new Length([
                        'min'        => 6,
                        'max'        => 16,
                        'minMessage' => '密码不得低于6个字符',
                        'maxMessage' => '密码不得长于16个字符',
                    ])
                ]
            ])
            //->add('createdAt')
            //->add('updatedAt')
            ;

        $formMapper->getFormBuilder()
            ->addEventListener(FormEvents::PRE_SUBMIT, [$this, 'onPreSubmit'])
            ->addEventListener(FormEvents::POST_SUBMIT, [$this, 'onPostSubmit']);
    }


    public function onPreSubmit(FormEvent $event)
    {
        /**
         * @var $event FormEvent
         */
        $data = $event->getData();
        //dump($event);
    }

    public function onPostSubmit(FormEvent $event)
    {
        /**
         * @var $user User
         */
        $user = $event->getData();
        dump($user);

        if ($user->getPlainPassword()) {
            $encoder = $this->getConfigurationPool()->getContainer()->get('security.password_encoder');
            $user->setPassword($encoder->encodePassword($user, $user->getPlainPassword()));
        }

    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->add('id')
            ->add('username')
            ->add('roles')
            ->add('xx', 'url', [
                'url' => 'http://example.com',
                //'route' => [
                //    'name' => 'admin.top',
                //    'absolute' => true,
                //    //'parameters' => ['format' => 'xml'],
                //    //'identifier_parameter_name' => 'id'
                //]

            ])
            ->add('createdAt', null, [
                'format' => "y/m/d H:i:s"
            ])
            ->add('updatedAt', null, [
                'format' => "y/m/d H:i:s"
            ])
            ;
    }
}
