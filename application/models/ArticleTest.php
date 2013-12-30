<?php
namespace Model;

require_once "Article.php";

class ArticleTest extends \PHPUnit_Framework_TestCase {
    protected $_data;

    public function setUp()
    {
        $this->_data = array(
            "pmid"          => "16388212",
            "volume"        => "1",
            "issue"         => "2",
            "year"          => "2003",
            "month"         => "Apr",
            "pages"         => "124-7",
            "issn"          => "1812-2027",
            "journal"       => "Kathmandu University medical journal (KUMJ)",
            "journalabbrev" => "Kathmandu Univ Med J",
            "title"         => "Hysterectomy: an analysis of perioperative and post operative complication.",
            "abstract"      =>  array(
                "OBJECTIVE" => "To document peri operative and post operative complication observed after hysterectomy, regardless of route on the operator.",
                "MATERIAL AND METHODS" => "A hospital based prospective study was carried out in department of obstetrics and gynaecology, KMCTH Sinamangal for six months. The study was carried out in patients undergoing hysterectomy who were followed from the time of admission to the time of discharge and two weeks thereafter. And followings were noted--Indication; route of hysterectomy, intraoperative and postoperative morbidities during hospital stay and after two weeks of discharge was noted.",
                "RESULT" => "Total number of hysterectomy carried out was 50. 31 (62%) were Total abdominal hysterectomy, and 19 (38%) were vaginal hysterectomy. Indication for total abdominal hysterectomy were fibroid uterus 12 (24%), DUB 8 (16%), CIN 4 (8%), chronic cervicitis 1 (2%). II U-V prolapse with previous LSCS 1 (2%), endometriosis 1 (2%). Prophylactic for Ca breast 1 (2%), Postmenopausal bleeding 1 (2%). All cases of vaginal hysterectomy were performed for 2nd degree U-V prolapse. Intra operative complication during surgery were two cases of haemorrhage (4%) each in both total abdominal hysterectomy and vaginal hysterectomy. There was one case of bladder injury during abdominal hysterectomy. Postoperative complication noted were febrile morbidity 1 (2%) in abdominal hysterectomy. Urinary tract infection remains the single most common febrile morbidity. There was one case of secondary haemorrhage in both type of hysterectomy. One was managed conservatively and other required laparotomy. There were three (6%) cases of wound infection in abdominal hysterectomy of two which were sanguineous discharge and one was frank pus which required secondary suture."
            ),
            "affiliation"   => "Department of Obstetrics and Gynaecology, KMCTH, Sinamangal.",
            "authors"       =>  array(
                "Saha R",
                "Sharma M",
                "Padhye S",
                "Karki U",
                "Pandey S",
                "Thapa J"
            ),
            "articleid"     => "16388212",
            "keywords"      =>  array(),
            "pubstatus"     => "ppublish"
        );
    }

    public function testPublicationStatusPPublish()
    {
        $article = new Article($this->_data);
        $this->assertEquals(Article::PUBLISHED, $article->getPublicationStatus());
    }
    public function testPublicationStatusEPublish()
    {
        $this->_data["pubstatus"] = "epublish";
        $article = new Article($this->_data);
        $this->assertEquals(Article::PUBLISHED, $article->getPublicationStatus());
    }
    public function testPublicationStatusAheadOfPrint()
    {
        $this->_data["pubstatus"] = "aheadofprint";
        $article = new Article($this->_data);
        $this->assertEquals(Article::AHEAD_OF_PRINT, $article->getPublicationStatus());
    }
}
 