<?php
namespace Ingesta\Services\Wordpress\Wrappers;


class Post
{
    const STATUS_PUBLISHED = 'published';

    protected $post;
    protected $categories;
    protected $tags;
    protected $customFields;


    public function __construct($post)
    {
        $this->post = (object) $post;
    }


    public function getPostId()
    {
        return $this->post->post_id;
    }


    public function getTitle()
    {
        return $this->post->post_title;
    }


    public function getPublishedDate()
    {
        return $this->post->post_date;
    }


    public function getModifiedDate()
    {
        return $this->post->post_modified;
    }


    public function getSlug()
    {
        return $this->post->post_name;
    }


    public function getExcerpt()
    {
        return $this->post->post_excerpt;
    }


    public function getContent()
    {
        return $this->post->post_content;
    }


    public function setContent($content)
    {
        $this->post->post_content = $content;
    }


    public function getLink()
    {
        return $this->post->link;
    }


    public function getGuid()
    {
        return $this->post->guid;
    }


    public function getStatus()
    {
        return $this->post->post_status;
    }


    public function isPublished()
    {
        return ($this->post->post_status === self::STATUS_PUBLISHED);
    }


    public function getType()
    {
        return $this->post->post_type;
    }


    public function getFormat()
    {
        return $this->post->post_format;
    }


    public function getCategories()
    {
        if (!$this->categories) {
            $this->processTerms();
        }

        return $this->categories;
    }


    public function getTags()
    {
        if (!$this->tags) {
            $this->processTerms();
        }

        return $this->tags;
    }


    public function getCustomFields()
    {
        if (empty($this->customFields)) {
            $this->customFields = array();
            foreach ($this->post->custom_fields as $customField) {
                $this->customFields[$customField['key']] = $customField['value'];
            }
        }

        return $this->customFields;
    }


    protected function processTerms()
    {
        foreach ($this->post->terms as $term) {
            switch ($term['taxonomy']) {
                case 'category':
                    $this->categories[] = new Term($term);
                    break;
                case 'post_tag':
                    $this->tags[] = new Term($term);
                    break;
            }
        }

    }
}
