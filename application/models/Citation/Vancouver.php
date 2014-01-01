<?php
namespace Model\Citation;

use Model\Article;

require_once dirname(__FILE__) . "/../Article.php";
require_once "Style.php";

/**
 * Vancouver Style Reference Generator
 *
 * @package Model\Citation
 * @category RefGen
 * @author Vikram
 * @version 1.0.1
 */
class Vancouver implements Style {
    /**
     * @param Article $article
     * @return string citation in vancouver format
     */
    public function getCitation(\Model\Article $article)
    {
        $citationString = "";

        $authors = $article->authors;
        if(!empty($authors)) {
            if(count($authors) > 6) {
                $authors = array_slice($authors, 0, 6);
                $authors[] = "et al";
            }
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

            if(!empty($article->volume) || !empty($article->issue)) {
                $citationString .= ";";
            }
            if(!empty($article->volume)) {
                $citationString .= $article->volume;
            }
            if(!empty($article->issue)) {
                $citationString .= sprintf("(%s)", $article->issue);
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