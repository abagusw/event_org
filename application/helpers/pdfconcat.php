<?php

require_once("tcpdf/tcpdf.php");
require_once("tcpdf/tcpdi.php");

class concat_pdf extends TCPDI {

    var $files = array();

    function setFiles($files) {
        $this->files = $files;
    }

    function concat() {
        foreach ($this->files AS $file) {
            $pagecount = $this->setSourceFile($file);
            for ($i = 1; $i <= $pagecount; $i++) {
                $tplidx = $this->importPage($i);
                $s = $this->getTemplatesize($tplidx);
                $this->AddPage('P', array($s['w'], $s['h']));
                $this->useTemplate($tplidx);
            }
        }
    }

}

?>
