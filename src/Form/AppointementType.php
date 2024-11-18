<?php
namespace App\Form;

use App\Entity\Appointement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class AppointementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom complet',
                'constraints' => [
                new NotBlank(['message' => 'Le nom est obligatoire.']),
                new Regex([
                    'pattern' => '/^[A-Za-zÀ-ÿ\s]+$/u',
                    'message' => 'Seules les lettres sont autorisées dans le nom.',
                ]),
            ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Adresse email',
            ])
            ->add('subject', TextType::class, [
                'label' => 'Sujet',
                'constraints' => [
                new NotBlank(['message' => 'Le sujet est obligatoire.']),
                new Regex([
                    'pattern' => '/^[A-Za-zÀ-ÿ\s]+$/u',
                    'message' => 'Seules les lettres sont autorisées dans le sujet.',
                ]),
            ],
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Message',
                'constraints' => [
                new NotBlank(['message' => 'Le sujet est obligatoire.']),
                new Regex([
                    'pattern' => '/^[A-Za-zÀ-ÿ\s]+$/u',
                    'message' => 'Seules les lettres sont autorisées dans le sujet.',
                ]),
            ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Appointement::class,
        ]);
    }
}
