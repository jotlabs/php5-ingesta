<?php
namespace Ingesta\Processors\Formatters;

use Ingesta\Processors\Processor;

class SimpleBlogFormatter implements Processor
{
    public function process($input)
    {
        //echo __CLASS__ . ":\n";
        //print_r($input);

        $blog = array(
            'guid'      => $input->getGuid(),
            'title'     => $input->getTitle(),
            'link'      => $input->getLink(),
            'slug'      => $input->getSlug(),
            'published' => $input->getPublishedDate(),
            'updated'   => $input->getModifiedDate(),
            'content'   => $input->getContent(),

            'categories' => $this->processTerms($input->getCategories()),
            'tags'       => $this->processTerms($input->getTags()),
        );

        $meta = $this->getYoastData($input);

        if (is_array($meta)) {
            $blog = array_merge($blog, $meta);
        }

        return (object) $blog;
    }


    protected function processTerms($termList)
    {
        $terms = array();

        if ($termList) {
            foreach ($termList as $termItem) {
                $term = array(
                    'termId' => $termItem->getTermId(),
                    'name' => $termItem->getName(),
                    'slug' => $termItem->getSlug(),
                    'description' => $termItem->getDescription(),
                    'taxonomy'    => $termItem->getTaxonomy(),
                    'total' => $termItem->getTotal()
                );

                $terms[] = $term;
            }
        }

        return $terms;
    }


    protected function getYoastData($input)
    {
        $meta = null;


        return $meta;
    }
}
