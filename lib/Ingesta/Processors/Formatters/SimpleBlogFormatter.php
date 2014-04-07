<?php
namespace Ingesta\Processors\Formatters;

use Ingesta\Processors\Processor;

class SimpleBlogFormatter implements Processor
{
    protected static $customFieldMapping = array(
        '_yoast_wpseo_metadesc' => 'excerpt'
    );

    public function process($input)
    {
        //echo __CLASS__ . ":\n";
        //print_r($input);

        $thumbnail = '';
        $content   = $input->getContent();
        if (preg_match("/src=\"([^\"]+)\"/", $content, $matches)) {
            $thumbnail = $matches[1];
        }

        $blog = array(
            'guid'      => $input->getGuid(),
            'title'     => $input->getTitle(),
            'link'      => $input->getLink(),
            'slug'      => $input->getSlug(),
            'published' => $input->getPublishedDate(),
            'updated'   => $input->getModifiedDate(),
            'content'   => $input->getContent(),
            'thumbnail' => $thumbnail,

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
        $customFields = $input->getCustomFields();
        //print_r($customFields);
        $meta = array();

        foreach (self::$customFieldMapping as $customKey => $metaKey) {
            if (array_key_exists($customKey, $customFields)) {
                $meta[$metaKey] = $customFields[$customKey];
            }
        }

        return $meta;
    }
}
