<?php
/**
 * Created by PhpStorm.
 * User: vikramraj
 * Date: 30/12/13
 * Time: 2:20 PM
 */

namespace Model\Citation;

require_once dirname(__FILE__) . "/../Article.php";
require_once "Vancouver.php";

class VancouverTest extends \PHPUnit_Framework_TestCase {
    protected $_data;
    public function setUp()
    {
        $this->_data = array(
            "pmid"          => "16388212",
            "volume"        => "1",
            "issue"         => "2",
            "year"          => "2003",
            "month"         => "Apr",
            "day"           => "1",
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

    public function testVancouverStyleForPublished()
    {

        $article = new \Model\Article($this->_data);
        $citation = new Vancouver();

        $expectedString = "Saha R, Sharma M, Padhye S, Karki U, Pandey S, Thapa J. ";
        $expectedString .= "Hysterectomy: an analysis of perioperative and post operative complication. ";
        $expectedString .= "Kathmandu Univ Med J. ";
        $expectedString .= "2003 Apr;1(2):124-7";
        $this->assertEquals($expectedString, $citation->getCitation($article));
    }

    public function testVancouverStyleForPublishedNoAuthors()
    {
        $data = $this->_data;
        $data["authors"] = array();
        $article = new \Model\Article($data);
        $citation = new Vancouver();

        $expectedString = "";
        $expectedString .= "Hysterectomy: an analysis of perioperative and post operative complication. ";
        $expectedString .= "Kathmandu Univ Med J. ";
        $expectedString .= "2003 Apr;1(2):124-7";
        $this->assertEquals($expectedString, $citation->getCitation($article));
    }

    public function testVancouverStyleForPublishedMoreThanSixAuthors()
    {
        $data = $this->_data;
        array_unshift($data["authors"], "Gopinathan N");
        array_unshift($data["authors"], "Gopinathan V");

        $article = new \Model\Article($data);
        $citation = new Vancouver();

        $expectedString = "Gopinathan V, Gopinathan N, Saha R, Sharma M, Padhye S, Karki U, et al. ";
        $expectedString .= "Hysterectomy: an analysis of perioperative and post operative complication. ";
        $expectedString .= "Kathmandu Univ Med J. ";
        $expectedString .= "2003 Apr;1(2):124-7";
        $this->assertEquals($expectedString, $citation->getCitation($article));
    }

    public function testVancouverStyleForPublishedNoIssue()
    {
        $data = $this->_data;
        $data["issue"] = "";
        $article = new \Model\Article($data);
        $citation = new Vancouver();

        $expectedString = "Saha R, Sharma M, Padhye S, Karki U, Pandey S, Thapa J. ";
        $expectedString .= "Hysterectomy: an analysis of perioperative and post operative complication. ";
        $expectedString .= "Kathmandu Univ Med J. ";
        $expectedString .= "2003 Apr;1:124-7";
        $this->assertEquals($expectedString, $citation->getCitation($article));
    }

    public function testVancouverStyleForPublishedNoVolume()
    {
        $data = $this->_data;
        $data["volume"] = "";
        $article = new \Model\Article($data);
        $citation = new Vancouver();

        $expectedString = "Saha R, Sharma M, Padhye S, Karki U, Pandey S, Thapa J. ";
        $expectedString .= "Hysterectomy: an analysis of perioperative and post operative complication. ";
        $expectedString .= "Kathmandu Univ Med J. ";
        $expectedString .= "2003 Apr;(2):124-7";
        $this->assertEquals($expectedString, $citation->getCitation($article));
    }

    public function testVancouverStyleForPublishedNoVolumeAndIssue()
    {
        $data = $this->_data;
        $data["volume"] = "";
        $data["issue"]  = "";
        $article = new \Model\Article($data);
        $citation = new Vancouver();

        $expectedString = "Saha R, Sharma M, Padhye S, Karki U, Pandey S, Thapa J. ";
        $expectedString .= "Hysterectomy: an analysis of perioperative and post operative complication. ";
        $expectedString .= "Kathmandu Univ Med J. ";
        $expectedString .= "2003 Apr:124-7";
        $this->assertEquals($expectedString, $citation->getCitation($article));
    }

    public function testVancouverStyleForPublishedNoMonth()
    {
        $data = $this->_data;
        $data["month"] = "";
        $article = new \Model\Article($data);
        $citation = new Vancouver();

        $expectedString = "Saha R, Sharma M, Padhye S, Karki U, Pandey S, Thapa J. ";
        $expectedString .= "Hysterectomy: an analysis of perioperative and post operative complication. ";
        $expectedString .= "Kathmandu Univ Med J. ";
        $expectedString .= "2003;1(2):124-7";
        $this->assertEquals($expectedString, $citation->getCitation($article));
    }

    public function testVancouverStyleForPublishedNoIssueAndMonth()
    {
        $data = $this->_data;
        $data["issue"] = "";
        $data["month"] = "";
        $article = new \Model\Article($data);
        $citation = new Vancouver();

        $expectedString = "Saha R, Sharma M, Padhye S, Karki U, Pandey S, Thapa J. ";
        $expectedString .= "Hysterectomy: an analysis of perioperative and post operative complication. ";
        $expectedString .= "Kathmandu Univ Med J. ";
        $expectedString .= "2003;1:124-7";
        $this->assertEquals($expectedString, $citation->getCitation($article));
    }

    public function testVancouverStyleForEpub()
    {
        $data = $this->_data;
        $data["pubstatus"] = "aheadofprint";
        $data["issue"]     = "";
        $data["volume"]    = "";
        $data["pages"]     = "";
        $article = new \Model\Article($data);
        $citation = new Vancouver();

        $expectedString = "Saha R, Sharma M, Padhye S, Karki U, Pandey S, Thapa J. ";
        $expectedString .= "Hysterectomy: an analysis of perioperative and post operative complication. ";
        $expectedString .= "Kathmandu Univ Med J. ";
        $expectedString .= "Epub 2003 Apr 1";

        $this->assertEquals($expectedString, $citation->getCitation($article));
    }

    public function testVancouverStyleForEpubNoDay()
    {
        $data = $this->_data;
        $data["pubstatus"] = "aheadofprint";
        $data["issue"]     = "";
        $data["volume"]    = "";
        $data["pages"]     = "";
        $data["day"]       = "";
        $article = new \Model\Article($data);
        $citation = new Vancouver();

        $expectedString = "Saha R, Sharma M, Padhye S, Karki U, Pandey S, Thapa J. ";
        $expectedString .= "Hysterectomy: an analysis of perioperative and post operative complication. ";
        $expectedString .= "Kathmandu Univ Med J. ";
        $expectedString .= "Epub 2003 Apr";

        $this->assertEquals($expectedString, $citation->getCitation($article));
    }

    public function testVancouverStyleForEpubNoMonth()
    {
        $data = $this->_data;
        $data["pubstatus"] = "aheadofprint";
        $data["issue"]     = "";
        $data["volume"]    = "";
        $data["pages"]     = "";
        $data["month"]     = "";
        $article = new \Model\Article($data);
        $citation = new Vancouver();

        $expectedString = "Saha R, Sharma M, Padhye S, Karki U, Pandey S, Thapa J. ";
        $expectedString .= "Hysterectomy: an analysis of perioperative and post operative complication. ";
        $expectedString .= "Kathmandu Univ Med J. ";
        $expectedString .= "Epub 2003";

        $this->assertEquals($expectedString, $citation->getCitation($article));
    }
}
 