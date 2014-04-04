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

            'categories' => $input->getCategories(),
            'tags'       => $input->getTags(),
        );

        $meta = $this->getYoastData($input);

        if (is_array($meta)) {
            $blog = array_merge($blog, $meta);
        }

        return (object) $blog;
    }


    protected function getYoastData($input)
    {
        $meta = null;


        return $meta;
    }
}
