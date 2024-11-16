<?php
namespace App\Form;

use App\Entity\Actualitevideo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

class ActualitevideoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class, [
                'label' => 'Title',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('description', TextType::class, [
                'label' => 'Description',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('videoFile', FileType::class, [
                'label' => 'Video',
                'attr' => ['class' => 'form-control'],
                'mapped' => false,  // Not mapped to the entity field (this will be handled manually)
                'required' => true,
                'constraints' => [
                    new Assert\File([
                        'mimeTypes' => ['video/*'],
                        'mimeTypesMessage' => 'Please upload a valid video file',
                    ])
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Actualitevideo::class,
        ]);
    }
}