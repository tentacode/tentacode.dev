<?php declare(strict_types=1);

namespace App\Contact;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('senderEmail', EmailType::class, [
                'label' => 'Your Email',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Your Email'
                ],
            ])
            ->add('senderName', TextType::class, [
                'label' => 'Your Name',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Your Name'
                ],
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Your Message',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Your Message'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ContactMessage::class,
        ]);
    }
}
