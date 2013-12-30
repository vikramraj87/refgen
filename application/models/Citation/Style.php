<?php
namespace Model\Citation;

require_once dirname(__FILE__) . "/../Article.php";
interface Style {
    public function getCitation(\Model\Article $article);
} 