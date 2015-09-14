<?php
//$header = '';
//require_once APP.'Vendor'. DS .'tcpdf'. DS . 'xtcpdef.php';
//
//$tcpdf = new XTCPDF();
//$textfont = 'freesans';
//
//$tcpdf->SetAuthor("Author");
//$tcpdf->SetAutoPageBreak( false );
//$tcpdf->SetMargins(10, 0, 0, true);
//$tcpdf->xfootertext = 'Zenliving';
//
//$tcpdf->AddPage();
//$html = $header;
//$html .= $this->Element("Detail/Quote/pdf_report_cab_parts");
////$html .= '<h3>HELLO WORLD</h3>';
//$tcpdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
//$tcpdf->writeHTML($html, true, 0, true, true);
//$name = 'TEST';
//$tcpdf->Output($name.'.pdf', 'D');

  $content = "
		<page>
				<h2>Hello World</h2>
		</page>";

    require_once APP.'Vendor'. DS .'html2pdf'. DS . 'html2pdf.class.php';
    $html2pdf = new HTML2PDF('P','A4','en');
    $html2pdf->WriteHTML($content);
    $html2pdf->Output('exemple.pdf');
?>
