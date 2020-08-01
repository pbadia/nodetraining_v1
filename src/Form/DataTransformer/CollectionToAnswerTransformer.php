<?php


namespace App\Form\DataTransformer;


use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class CollectionToAnswerTransformer implements DataTransformerInterface
{
    /**
     * @param mixed $collection
     * @return mixed|string
     */
    public function transform($collection)
    {
        if (null === $collection){
            return '';
        }
        else
        {
            foreach ($collection as $answer){
                return $answer;
            }
        }

    }

    /**
     * @param mixed $answer
     * @return ArrayCollection|mixed
     */
    public function reverseTransform($answer)
    {
        /*$collection = new ArrayCollection();
        $collection->add($answer);
        return $collection;*/
    }
}