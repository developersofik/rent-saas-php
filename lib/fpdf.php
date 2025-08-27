<?php
// Minimal FPDF-like implementation for text PDFs
class FPDF {
  private array $lines = [];
  public function AddPage(){ $this->lines = []; }
  public function SetFont($family,$style='',$size=12){}
  public function Cell($w,$h=0,$txt='',$border=0,$ln=0,$align='',$fill=false,$link=''){ $this->lines[] = $txt; if($ln>0) $this->lines[] = ''; }
  public function Ln($h=0){ $this->lines[] = ''; }
  private function escape(string $s): string { return str_replace(['\\','(',')'],['\\\\','\(','\)'],$s); }
  public function Output(){
    $content="BT /F1 12 Tf\n";
    $y = 800;
    foreach($this->lines as $line){
      if($line===''){ $y-=14; continue; }
      $content .= sprintf("1 0 0 1 40 %.2f Tm (%s) Tj\n", $y, $this->escape($line));
      $y -= 14;
    }
    $content .= "ET";
    $objs = [];
    $objs[] = '1 0 obj<</Type/Catalog/Pages 2 0 R>>endobj';
    $objs[] = '2 0 obj<</Type/Pages/Kids[3 0 R]/Count 1>>endobj';
    $objs[] = '3 0 obj<</Type/Page/Parent 2 0 R/MediaBox[0 0 595 842]/Contents 4 0 R/Resources<</Font<</F1 5 0 R>>>>>>endobj';
    $objs[] = '4 0 obj<</Length '.strlen($content).'>>stream\n'.$content.'\nendstream\nendobj';
    $objs[] = '5 0 obj<</Type/Font/Subtype/Type1/BaseFont/Helvetica>>endobj';
    $pdf = "%PDF-1.3\n"; $offsets=[0];
    foreach($objs as $o){ $offsets[] = strlen($pdf); $pdf .= $o."\n"; }
    $xref = strlen($pdf);
    $pdf .= 'xref\n0 '.(count($offsets))."\n";
    foreach($offsets as $i=>$off){ $pdf .= sprintf('%010d 00000 %s \n',$off,$i==0?'f':'n'); }
    $pdf .= 'trailer<</Size '.count($offsets).'/Root 1 0 R>>\nstartxref\n'.$xref.'\n%%EOF';
    header('Content-Type: application/pdf');
    echo $pdf;
  }
}
