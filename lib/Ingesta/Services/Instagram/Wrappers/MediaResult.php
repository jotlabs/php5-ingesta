<?php
namespace Ingesta\Services\Instagram\Wrappers;

class MediaResult
{
    protected $document;


    public function __construct($document)
    {
        $this->document = $document;
    }


    public function getGuid()
    {
        return $this->document->id;
    }


    public function getSlug()
    {
        return $this->getGuid();
    }


    public function getTitle()
    {
        // TODO: get a Wrapped caption object
        $caption = '';

        if (isset($this->document->caption->text)) {
            $caption = $this->document->caption->text;
        }

        return $caption;
    }


    public function getLink()
    {
        return $this->document->link;
    }


    public function getPublishedDate()
    {
        return date('c', $this->document->created_time);
    }


    public function getModifiedDate()
    {
        return $this->getPublishedDate();
    }


    public function getContent()
    {
        $image = $this->getStandardImage();
        return "<img src=\"{$image->url}\" width=\"{$image->width}\" height=\"{$image->height}\">";
    }


    public function getAuthor()
    {
        // TODO: wrap this.
        return $this->document->user;
    }


    public function getLikes()
    {
        // TODO: Wrap this.
        return $this->document->likes;
    }


    public function getLikeCount()
    {
        // TODO: Use wrapper from method above.
        return $this->document->likes->count;
    }


    public function getImages()
    {
        return $this->document->images;
    }


    public function getStandardImage()
    {
        return $this->document->images->standard_resolution;
    }


    public function getLowRedImage()
    {
        return $this->document->images->low_resolution;
    }


    public function getThumbnailImage()
    {
        return $this->document->images->thumbnail;
    }


    public function getCategories()
    {
        return array();
    }


    public function getTags()
    {
        return $this->document->tags;
    }


    public function getLocation()
    {
        return $this->document->location;
    }


    public function getComments()
    {
        // TODO: Wrap this
        return $this->document->comments;
    }


    public function getCommentCount()
    {
        // TODO: Use wrapper from previous method
        return $this->document->comments->count;
    }


    public function getFilter()
    {
        return $this->document->filter;
    }
}
