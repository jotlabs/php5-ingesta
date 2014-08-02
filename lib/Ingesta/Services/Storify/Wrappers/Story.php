<?php
namespace Ingesta\Services\Storify\Wrappers;

use Ingesta\Services\Storify\Utils\Content;

class Story
{
    const STATUS_PUBLISHED = 'published';

    protected $story;
    protected $content;
    protected $tags;


    public function __construct($story)
    {
        $this->story = (object) $story;
    }


    public function getStoryId()
    {
        return $this->story->sid;
    }


    public function getGuid()
    {
        return $this->getStoryId();
    }


    public function getTitle()
    {
        return $this->story->title;
    }


    public function getSlug()
    {
        return $this->story->slug;
    }


    public function getStatus()
    {
        return $this->story->status;
    }


    public function isPublished()
    {
        return ($this->story->status === self::STATUS_PUBLISHED);
    }


    public function getLink()
    {
        return $this->story->permalink;
    }


    public function getDescription()
    {
        return $this->story->description;
    }


    public function getThumbnail()
    {
        return $this->story->thumbnail;
    }


    public function getCreatedDate()
    {
        return $this->story->date->created;
    }


    public function getModifiedDate()
    {
        return $this->story->date->modified;
    }


    public function getPublishedDate()
    {
        return $this->story->date->published;
    }


    public function getTags()
    {
        if (empty($this->tags)) {
            $this->processTags();
        }
        return $this->tags;
    }


    public function getAuthor()
    {
        $author = (object) array(
            'slug'     => $this->story->author->username,
            'name'     => $this->story->author->name,
            'bio'      => $this->story->author->bio,
            'image'    => $this->story->author->avatar,
            'location' => $this->story->author->location,
        );

        return $author;
    }


    public function getApiUrl()
    {
        return $this->story->self;
    }


    public function getContent()
    {
        if (!$this->content) {
            $this->content = Content::cleanStoryContent($this->story->content);
        }
        return $this->content;
    }


    protected function processTags()
    {
        $tags = array();

        foreach ($this->story->meta->hashtags as $tag) {
            $tag = substr($tag, 1);
            $tags[] = $tag;
        }

        $this->tags = $tags;
    }
}
