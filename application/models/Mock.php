<?php
namespace Model;
class Mock
{
	protected $_data = array();
	/**
	 * Making the class singleton
	 */
	protected static $_instance = null;
	
	protected function __construct()
	{
		//Mock entry 1
		$this->_data["24262268"] = array(
			"pmid" => "24262268",
			"journalabbrev" => "Sex Health",
			"title" => "48. Cidofovir treatment prevents invasion of invasive HPV-16-positive anal keratinocytes.",
			"year" => "2013",
			"month" => "Nov",
			"pages" => "593",
			"issue" => "6",
			"volume" => "10",
			"authors" => array(
				"Wechsler EI", "Tugizov S", "Palefsky J"
			),
			"abstract" => array(
				"Background The nucleotide analogue cidofovir has been shown to be effective in treating precancerous HPV-associated lesions located in the respiratory tract, cervix, vulva and anus. Cidofovir has been shown to have a 51% efficacy in the short-term treatment of high-grade perianal squamous intraepithelial lesions in HIV-infected persons. Less is known about the effect of cidofovir in treating more advanced stages of HPV-associated disease such as invasive cancer. Methods: We established an immortalised anal keratinocyte cell line (AKC2) following transfection of the HPV-16 genome into primary anal keratinocytes and long-term culture. AKC2 cells were invasive using in vitro collagen invasion assays. To determine the effect of cidofovir on invasion, AKC2 cells were treated for up to 7 days with different concentrations of cidofovir (10, 25 and 50 µg mL(-1)) and studied using the collagen invasion assays. Untreated cells served as a control. Results: We detected a decrease in invasion of AKC2 cells (50%, 70% and 90% decrease) with 10, 25 and 50 µg mL(-1) cidofovir, respectively. Cellular toxicity was not detected in any of the cidofovir-treated samples. Preliminary data suggest that cidofovir directly or indirectly impairs the formation of actin filaments and cellular filopodia, which are known to play a role in cellular invasion. Conclusions: Cidofovir inhibits invasion of HPV-16-transformed anal keratinocytes potentially through affecting pathways that are involved in actin filament formation. Cidofovir could potentially be useful as an adjuvant treatment for invasive anal cancers, and its mechanism of action in inhibiting cellular invasion requires further study."
			),
			"journal" => "Sexual health"
		);
		// Mock entry 2
		$this->_data["24240707"] = array(
			"pmid" => "24240707",
			"journalabbrev" => "Acta Biochim. Biophys. Sin. (Shanghai)",
			"title" => "Planta medica.",
			"year" => "2013",
			"month" => "Nov",
			"pages" => "593",
			"issue" => "6",
			"volume" => "10",
			"authors" => array(
				"Chen S", "Liao C", "Lai Y", "Fan Y", "Lu G", "Wang H", "Zhang X", "Lin MC", "Leng S", "Kung HF"
			),
			"abstract" => array(
				"In order to develop more effective therapeutic vaccines against cancers with high-risk human papillomavirus (HPV) infection, it is crucial to enhance the immunogenicity, eliminate the oncogenicity of oncoproteins, and take a combination of E7- and E6-containing vaccines. It has been shown recently that PE(ΔIII)-E7-KDEL3 (E7), a fusion protein containing the HPV16 oncoprotein E7 and the translocation domain of Pseudomonas aeruginosa exotoxin A, is effective against TC-1 tumor cells inoculated in mice, therefore, we engineered PE(ΔIII)-E6-CRL-KDEL3 (E6), the de-oncogenic versions of the E7 and E6 fusion proteins [i.e. PE(ΔIII)-E7(d)-KDEL3, E7(d), and PE(ΔIII)-E6(d)-CRL-KDEL3, E6(d)] and tested the immunoefficacies of these fusion proteins as mono- and bivalent vaccines. Results indicated that the E7(d) get higher immunogenicity than its wild type and the E6 fusion proteins augmented the immunogenicity and antitumor effects of their E7 counterparts. Furthermore, the bivalent vaccine system E7(d) plus E6(d), in the presence of cisplatin, showed the best tumoristatic and tumoricidal effects against established tumors in vivo. Therefore, it can be concluded that this novel therapeutic vaccine system, upon further optimization, may shed new light on clinical management of HPV-related carcinomas."
			),
			"journal" => "Acta biochemica et biophysica Sinica"
		);
		// Mock entry 3
		$this->_data["24210110"] = array(
			"pmid" => "24210110",
			"journalabbrev" => "Virology",
			"journal" => "Virology",
			"title" => "Gene expression profile regulated by the HPV16 E7 oncoprotein and estradiol in cervical tissue.",
			"year" => "2013",
			"month" => "Dec",
			"pages" => "155-65",
			"issue" => "1-2",
			"volume" => "447",
			"authors" => array(
				"Cortes-Malagon EM",
				"Bonilla-Delgado J",
				"Diaz-Chavez J",
				"Hidalgo-Miranda A",
				"Romero-Cordoba S",
				"Uren A",
				"Celik H"
			),
			"abstract" => array(
				"The HPV16 E7 oncoprotein and 17β-estradiol are important factors for the induction of premalignant lesions and cervical cancer. The study of these factors is crucial for a better understanding of cervical tumorigenesis. Here, we assessed the global gene expression profiles induced by the HPV16 E7 oncoprotein and/or 17β-estradiol in cervical tissue of FvB and K14E7 transgenic mice. We found that the most dramatic changes in gene expression occurred in K14E7 and FvB groups treated with 17β-estradiol. A large number of differentially expressed genes involved in the immune response were observed in 17β-estradiol treated groups. The E7 oncoprotein mainly affected the expression of genes involved in cellular metabolism. Our microarray data also identified differentially expressed genes that have not previously been reported in cervical cancer. The identification of genes regulated by E7 and 17β-estradiol, provides the basis for further studies on their role in cervical carcinogenesis."
			)
		);
		// Mock entry 4
		$this->_data["24155678"] = array(
			"pmid" => "24155678",
			"journalabbrev" => "Cancer Res Treat",
			"journal" => "Cancer research and treatment : official journal of Korean Cancer Association",
			"title" => "Impact of Chemoradiation on Prognosis in Stage IVB Cervical Cancer with Distant Lymphatic Metastasis.",
			"year" => "2013",
			"month" => "Sep",
			"pages" => "193-201",
			"issue" => "3",
			"volume" => "45",
			"authors" => array(
				"Kim HS",
				"Kim T",
				"Lee ES",
				"Kim HJ",
				"Chung HH",
				"Kim JW"
			),
			"abstract" => array(
				"PURPOSE" => "The purpose of this study was to determine whether chemoradiation (CCR) is efficient for improving prognosis, compared with systemic chemotherapy (SC), in patients with stage IVB cervical cancer who have distant lymphatic metastasis.",
				"MATERIALS AND METHODS" => "Among 2,322 patients with cervical cancer between January 2000 and March 2010, 43 patients (1.9%) had stage IVB disease. After exclusion of 19 patients due to insufficient data and hematogenous metastasis, 24 patients (1%) who received CCR (n=10) or SC (n=14) were enrolled. We compared tumor response, progression-free survival (PFS) and overall survival (OS), and disease recurrence between CCR and SC.",
				"RESULTS" => "Complete response rates were 60% and 0% after CCR and SC (p<0.01). Grade 3 or 4 leukopenia was more common in patients treated with CCR (24.4% vs. 9.1%, p=0.03), whereas grade 3 or 4 neuropenia was more frequent in those treated with SC (28.4% vs. 11.1%, p=0.03). Development of grade 3 proctitis occurred as a late radiotherapy (RT)-related toxicity in only one patient (10%) treated with CCR. In addition, squamous cell carcinoma and CCR were favorable prognostic factors for improvement of PFS (adjusted hazard ratios [HRs], 0.17 and 0.12; 95% confidence intervals [CIs], 0.04 to 0.80 and 0.03 to 0.61), and only CCR was significant for improvement of OS (adjusted HR, 0.15; 95% CI, 0.02 to 0.90). However, no differences in the rate and pattern of disease recurrence were observed between CCR and SC.",
				"CONCLUSIONS" => "CCR may be more effective than SC for improving survival, and can be regarded as a feasible method with some caution regarding late RT-related toxicity for treatment of stage IVB cervical cancer with distant lymphatic metastasis."
			)
		);
		// Mock entry 5
		$this->_data["24135780"] = array(
			"pmid" => "24135780",
			"journalabbrev" => "J. Acquir. Immune Defic. Syndr.",
			"journal" => "Journal of acquired immune deficiency syndromes (1999)",
			"title" => "Is the level of proof of the North American multicohort collaboration prospective study sufficient to conclude that incidence of invasive cervical cancer is higher in HIV-infected women?",
			"year" => "2013",
			"month" => "Aug",
			"pages" => "e163-4",
			"issue" => "5",
			"volume" => "63",
			"authors" => array(
				"Nazac A",
				"Fridmann S",
				"Boufassa F"
			),
			"abstract" => array()
		);
		// Mock entry 6
		$this->_data["24135779"] = array(
			"pmid" => "24135779",
			"journalabbrev" => "J. Acquir. Immune Defic. Syndr.",
			"journal" => "Journal of acquired immune deficiency syndromes (1999)",
			"title" => "Invasive cervical cancer risk among HIV-infected women is a function of CD4 count and screening.",
			"year" => "2013",
			"month" => "Aug",
			"pages" => "e163",
			"issue" => "5",
			"volume" => "63",
			"authors" => array(
				"Abraham AG",
				"Strickler HD",
				"D' Souza G"
			),
			"abstract" => array()
		);
		// Mock entry 7
		$this->_data["24131176"] = array(
			"pmid" => "24131176",
			"journalabbrev" => "N. Engl. J. Med.",
			"journal" => "The New England journal of medicine",
			"title" => "The thousand-dollar Pap smear.",
			"year" => "2013",
			"month" => "Oct",
			"pages" => "1486-7",
			"issue" => "16",
			"volume" => "369",
			"authors" => array(
				"Bettigole C"
			),
			"abstract" => array()
		);
		// Mock entry 8
		$this->_data["24083006"] = array(
			"pmid" => "24083006",
			"journalabbrev" => "Iran Red Crescent Med J",
			"journal" => "Iranian Red Crescent medical journal",
			"title" => "Quality of life and its related factors among Iranian cervical cancer survivors.",
			"year" => "2013",
			"month" => "Apr",
			"pages" => "320-3",
			"issue" => "4",
			"volume" => "15",
			"authors" => array(
				"Torkzahrani S",
				"Rastegari L",
				"Khodakarami N",
				"Akbarzadeh-Baghian A",
				"Alizadeh K"
			),
			"abstract" => array(
				"BACKGROUND" => "Cervical cancer is the main cause of malignancy-related death among women living in developing countries.",
				"OBJECTIVE" => "The aim of this study is to evaluate the quality of life (QOL) among Iranian cervical cancer survivors and its relationships with demographic and disease related factors.",
				"METHODS" => "A descriptive correlational study was carried out on 65 consecutive cervical cancer survivors in three different oncology centers related to Shahid Beheshti University of Medical Sciences, Tehran. The QOL was evaluated using three different standard questionnaires: 1) EORTC QLQ-C30 for patients with malignant tumors; 2) EORTC QLQ-CX24 for cervical cancer patients; and 3) SSQ for assessing the social support. The data was obtained by telephone interviews. The test-retest reliability and internal consistency of the scales were examined. Cronbach's alpha was calculated to assess internal consistency among items. Content validity was assessed to review the scales.",
				"RESULTS" => "Cervical cancer survivors stated a good QOL. However, its score was negatively associated with symptoms including short breathing, lack of appetite, nausea and vomiting, sleep disorders, peripheral neuropathy, and menopausal symptoms. Also, there was a positive association between QOL and economic conditions as well as QOL and social functioning.",
				"CONCLUSIONS" => "Although, the QOL in cervical cancer survivors was good, treatment of related symptoms can influence the QOL and improve the care of these patients."
			)
		);
		// Mock entry 9
		$this->_data["24082558"] = array(
			"pmid" => "24082558",
			"journalabbrev" => "J Obstet Gynaecol India",
			"journal" => "Journal of obstetrics and gynaecology of India",
			"title" => "Immunohistochemical Expression of Cell Proliferating Nuclear Antigen (PCNA) and p53 Protein in Cervical Cancer.",
			"year" => "2012",
			"month" => "Oct",
			"pages" => "557-61",
			"issue" => "5",
			"volume" => "62",
			"authors" => array(
				"Madhumati G",
				"Kavita S",
				"Anju M",
				"Uma S",
				"Raj M"
			),
			"abstract" => array(
				"OBJECTIVE" => "This study was designed to evaluate the immunohistochemical expression of proliferating cell nuclear antigen (PCNA) and p53 protein expression in preneoplastic and neoplastic lesions in uterine cervix.",
				"METHODS" => "A total of 36 cervical biopsies were subjected for immunostaining and the results were correlated with different prognostic parameters. Bivariate and multivariate statistical analyses were done using \"STATA\" software.",
				"RESULTS" => "PCNA labeling index and p53 expression increased with increasing severity of CIN lesions. PCNA labeling index was maximum (46.0) carcinoma cervix with intense positive staining. In bivariate statistical analysis, p53 and PCNALI were found to be insignificant (0.4184 and 0.4328, respectively). Menopausal stage was significantly associated with CA and CIN groups (P < 0.166 and P < 0.049), respectively.",
				"CONCLUSIONS" => "These markers may be of greater importance in low-grade CIN lesions showing high proliferative index. This will place the low-grade lesions in higher grade indicating the utility of proliferative markers in decision making for intervention. This method is simple and cost effective and may be useful in developing countries where HPVDNA testing is still out of reach because of high cost."
			)
		);
	}
	
	public static function getInstance()
	{
		if(is_null(self::$_instance)) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
	public function searchById($id)
	{
		if(isset($this->_data[$id])) {
			return new \Model\Article($this->_data[$id]);
		}
		return null;
	}
	
	public function searchByTerm($dummy = "")
	{
		return new \Model\Articles($this->_data);
	}
}