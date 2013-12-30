<?php
namespace Model\Citation;

use Model\Article;

require_once dirname(__FILE__) . "/../Article.php";

class Vancouver {
    public function __construct()
    {

    }

    public function getCitation(\Model\Article $article)
    {
        $citationString = "";

        $authors = $article->authors;
        if(!empty($authors)) {
            $citationString .= implode(", ", $authors) . ". ";
        }

        $citationString .= $article->title . " ";

        $journalAbbr = preg_replace("/\./", "", $article->journalAbbr);
        $citationString .= $journalAbbr . ". ";

        if($article->getPublicationStatus() === Article::PUBLISHED) {
            $citationString .= $article->year;
            if(!empty($article->month)) {
                $citationString .= " " . $article->month;
            }

            if(!empty($article->volume)) {
                $citationString .= ";" . $article->volume;
                if(!empty($article->issue)) {
                    $citationString .= sprintf("(%s)", $article->issue);
                }
            }

            if(!empty($article->pages)) {
                $citationString .= ":" . $article->pages;
            }
        } else {
            $citationString .= "Epub ";
            $citationString .= $article->year;
            if(!empty($article->month)) {
                $citationString .= " " . $article->month;
                if(!empty($article->day)) {
                    $citationString .= " " . $article->day;
                }
            }
        }

        return $citationString;
    }



} 