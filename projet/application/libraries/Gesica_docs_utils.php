<?php 

/* gesica_docs_utils.h - Libraire permettant de faire les imprimés avec GESICA */

require __DIR__.'/fpdf/fpdf.php';

class Gesica_docs_utils
{
	public function __construct( )
	{
		
		$this->CI = &get_instance();
		$this->CI->load->library("gesica_sess_utils");
		$this->gesica_sess_utils = $this->CI->gesica_sess_utils;
		$this->CI->load->library('gesica_config');
		$this->gesica_config= $this->CI->gesica_config;
		$this->page_format = array( 'name'=>'a4', 'w' => 210 , 'h'=> 287  );
		$this->point_size = 7;
		$pcts=array( 
			'a4' => 1,
			'a5' => 0.8,
			'a6' => 0.6,
			'a7' => 0.4,
			'a8' => 0.2
		);

		$this->pcts = $pcts;


	}
	
	private function zoom($size)
	{
		$name = $this->page_format['name'];
		$p=$this->pcts[$name];
		return (int)($p * $size);
	}

	private function init_fpdf()
	{

		
		$width = $this->page_format['w'];
		$height = $this->page_format['h'];

		/* Initialiser FPDF */
		$this->pdf = new FPDF( 'P' , 'mm' , array($width,$height) );
		$this->pdf->SetFont('Arial','B',$this->zoom($this->point_size));
		$this->pdf->SetAutoPageBreak(false);
		$this->char_height=5;  /*auteur fixée à 5*/
		$this->page_margins = 15;
		$this->page_width = $this->pdf->GetPageWidth() - 2*$this->page_margins;
		$this->page_height = $this->pdf->GetPageHeight() - 2*$this->page_margins;	

	}
	/* 
		formater correctement une cellule
	*/
	private function format_cell( $text , $cell_width , $char_height )
	{
		$buffer = "";
		$height = 0 ; 
		$buffer_sav = "" ; 
		$cell['lines'] = array();
		
		/* 
			utiliser un algo semblable à l'écriture télétype pour trouver 
			la bonne taille
		*/	
		for( $index=0;$index!=strlen( $text ) ; ++$index){
			
			$buffer_sav = $buffer ; 
			$buffer = $buffer .= $text[$index];

			if( $this->pdf->GetStringWidth($buffer) > $cell_width ){
				
				$buffer = $buffer_sav;
				if( strlen($buffer) == 0){
					return null ; /* colonne trop petite */
				}
				array_push($cell['lines'] , $buffer);
				$buffer = $text[$index];
				
			}				
		}
		
		if( strlen($buffer) != 0 ) array_push( $cell['lines'] , $buffer );
		$height= count($cell['lines']) * $char_height;
		
		$cell['height'] = $height;
		$cell['width'] = $cell_width;
		
		return $cell ;
	}
	
	/* calcul la hauteur d'une ligne dans le tableau */
	private function compute_matrix_line_height( $line )
	{
		$h = $line['cells'][0]['marg_height'];
		
		$hmax = $h; 
		for( $i=1;$i<count($line['cells']);++$i ) {
			$h = $line['cells'][ $i ]['marg_height'];
			if( $hmax < $h ) $hmax = $h;
		}
		
		return $hmax;
	}
	
	/* calcul les attributs(x,y,largeur,hauteur,marges,etc. de chacune des cellules*/
	private function compute_matrix_cells_attributes( $matrix , $rows, $cols, $margin , $header_percents )
	{
		
		$final_matrix = array();
		$cells = $matrix ; 
		$acc_x = 0 ; 
		$acc_y = 0 ;
		
		for( $j=0;$j<$rows;++$j ){
			$acc_x = 0 ;
			
			$line = array() ; 
			$line['cells'] = array();

			for( $i=0;$i<$cols;++$i ){
				$text = $matrix[$j][$i]; 
				
				$current_cell['text'] = $matrix[$j][$i];
			

				$cell_width = ($header_percents[$i] * $this->page_width)/100;
				
				$cell=$this->format_cell( $text , $cell_width - 2*$margin , $this->char_height);	
				
				if( !is_null($cell) ){
					
					$current_cell['width'] = $cell['width'] ;
					$current_cell['height'] = $cell['height'] ;
					$current_cell['marg_width'] = $cell['width'] + 2*$margin;
					$current_cell['marg_height'] = $cell['height'] + 2*$margin;
					$current_cell['lines'] = $cell['lines'];
					$current_cell['margin']=$margin;
					$current_cell['x'] = $acc_x ; 
					$current_cell['y'] = $acc_y ; 
					
				}
				
				array_push( $line['cells'] , $current_cell );
				$acc_x += $current_cell['marg_width'];
				
			}			
			/*determiner la hauteur de la ligne*/
			$line['height'] = $this->compute_matrix_line_height( $line );
			$final_matrix[$j] = $line;
			
			$acc_y += $line['height'];
		}
		return $final_matrix;
	}
	
	/* subdivise la matrice en pages pages en fonction de la taille de début */
	private function divide_pages( $start_y , $final_matrix , $rows , $cols  )
	{
		$acc_y = $start_y ; 
		$page_list = array() ; 
		$page = array();
		
		$margin = $this->page_margins;
		$page_height = $this->pdf->GetPageHeight();
		
		for( $i=0;$i<$rows;++$i ){
			
			if( $margin + $acc_y + $final_matrix[$i]['height'] > $page_height - $margin ){
				array_push( $page_list , $page );
				$acc_y = 0;
				$page = array();
			}
			
			for( $j=0;$j<$cols;++$j ){
				$final_matrix[$i]['cells'][$j]['y'] = $acc_y;
			}
			array_push( $page , $final_matrix[$i] );
			$acc_y  =$acc_y + $final_matrix[$i]['height'];
		}
		
		if( !empty( $page) )  array_push( $page_list , $page );
		
		return $page_list;
	}
	
	
	
	/* lance le rendu du document */
	public function render_matrix( 	$start_y , /* ordonnée de début */
									$matrix ,  /* matrice de données */
									$rows, $cols,  	/* nombre lignes , nombre colonnes */
									$inner_margin , /* marge interne( à l'intérieur des cellules) */
									$header_percents, /* pourcentage de largeur des titres */
									$header_bg ,	/* fond de l'entête */ 
									$header_fg , 	/* couleur de l'écriture de l'entête */
									$body_bg ,  	/* fond du corps */
									$body_fg)		/* couleur de fond du corps */
	{
		/* calculer des données de chaque cellules */
		$final_matrix = $this->compute_matrix_cells_attributes( $matrix , $rows , $cols , $inner_margin , $header_percents );

		/* diviser la matrice en pages */
		$pages = $this->divide_pages( $start_y , $final_matrix , $rows , $cols );
		
		/* calculer la largeur du tableau (utilité : au cas ou la somme est inférieure à 10
		100*/
		$table_width = 0;
		for( $k=0;$k<count($header_percents);++$k ){
			$table_width += $header_percents[$k];
		}
		$table_width = ($table_width * $this->page_width)/100;

		/* traiter chaque page */
		for( $l=0;$l<count( $pages );++$l ) {
			
			$matrix = $pages[$l];
			if( $l!=0 )
				$this->pdf->AddPage(); 
			
			$this->write_page_foot( "Fait par GESICA - (C) SADII 2018" );
			
			/* Traiter chaque matrice */
			for( $i=0;$i<count( $matrix );++$i ){
				
				if( $l==0 && $i==0 ){
					$this->pdf->SetFillColor( $header_bg[0] ,$header_bg[1] ,$header_bg[2] );
					$this->pdf->SetTextColor( $header_fg[0],$header_fg[1],$header_fg[2] );
					
				}else{
					$this->pdf->SetFillColor( $body_bg[0],$body_bg[1],$body_bg[2] );
					$this->pdf->SetTextColor( $body_fg[0], $body_fg[1] , $body_fg[2] );	
				}

				
				$line_height = $matrix[$i]['height'];
				$current_line = $matrix[$i];
				
				
				
				for( $j=0;$j<count( $current_line['cells'] );++$j ){
						
						$c = $current_line['cells'][$j];
						
						$marg_y =$this->page_margins + $c['y']+$c['margin'] ; 
						$y = $this->page_margins + $c['y'];
						$marg_x = $this->page_margins+$c['x']+$c['margin'];
						$x = $this->page_margins+$c['x'];
						
						//$this->pdf->Cell( 20,20,'(row='.$i.',col='.$j.')' );
						
						$this->pdf->Rect( $x , $y , $c['marg_width'],$line_height  , ($l==0 && $i==0) ? 'DF' : 'F' );
						$this->pdf->Line( $x,$y,$x,$y+$line_height );
						$this->pdf->Line( $x+$c['marg_width'],$y,$x+$c['marg_width'],$y+$line_height );

						$this->pdf->SetXY( $marg_x , $marg_y);
						
						for( $k=0;$k<count( $c['lines'] ) ;++$k){
							$this->pdf->SetXY( $marg_x  , $marg_y + $k*$this->char_height );
							$this->pdf->Cell( $c['width'],$this->char_height,$c['lines'][$k] );
						}		
				}
				
			}
			$y = $this->pdf->GetY();
			$this->pdf->Line( 	$this->page_margins,
								$y+$line_height-$inner_margin,
								$this->page_margins+$table_width,
								$y+$line_height-$inner_margin);
		}

		$this->pdf->SetXY( $this->char_height , $y+$line_height );
	}

	private function write_page_foot( $page_foot_note  )
	{
		$no = '('.$this->pdf->PageNo().')';
		$no_pos_y = $this->pdf->GetPageHeight() - $this->page_margins / 2 ; 
		$no_pos_x = $this->pdf->GetPageWidth() - $this->pdf->GetStringWidth( $no ) - 10-$this->page_margins;
		
		
		/* numéro de page */
		$this->pdf->SetXY( $no_pos_x, $no_pos_y);
		$this->pdf->SetTextColor( 0x70,0x70,0x70 );
		$this->pdf->Cell( 30, $this->char_height, $no );
		
		$note_pos_x = $this->page_margins; 
		$note_pos_y = $no_pos_y;
		$this->pdf->SetXY( $note_pos_x, $note_pos_y);
		$this->pdf->Cell( 30 , $this->char_height , $page_foot_note );
	}

	public function render_bill( $cart , $path = null)
	{
		$this->init_fpdf();

		$matrix = array( 
			array( 
			"Code", 
			"Nom",
			"Quantite",
			"Prix U",
			"Total brut",
			"TVA",
			"Remise",
			"Total")
		);

		$header_pcts = array( 10,26,10,12,12,7,9,14 );

		for( $i=0;$i<count($cart);++$i ){
			$ct=$cart[$i];
			array_push($matrix, array(	$ct['product-code'], 
										$ct['product-name'], 
								(string)$ct['product-amount'], 
								(string)$ct['product-price'], 
								(string)$ct['product-raw-total'],
								(string)$ct['product-tax'].'%',
								(string)$ct['product-discount'].'%',
								(string)$ct['product-total'] ) );
		}

		$this->pdf->AddPage();

		$this->pdf->SetFontSize($this->zoom(16));
		$this->pdf->SetXY( $this->page_margins,$this->page_margins );
		
		$this->pdf->SetFillColor( 0x0,0x0,0x30 );
		$this->pdf->SetTextColor( 0xff,0xff,0xff );

		$x = $this->page_margins ; 
		$y = $this->page_margins ; 
		$this->pdf->Rect( $x, $y, $this->page_width , 10  , 'F');
		
		$x = $this->page_margins ; 
		$y = $this->page_margins + 2.5;
		$this->pdf->SetXY( $x ,$y );

		$this->pdf->Cell(30 , $this->char_height, "Facture" );

		$y += 10 ; 
		$this->pdf->SetXY( $x ,$y);
		$this->pdf->Image( $this->CI->gesica_sess_utils->get_logo_image_path(false) , null , null , 0 , 20 );
		

	
		$y += 25;
		$this->pdf->SetXY( $x,$y );
		$this->pdf->SetFontSize($this->zoom(9));
		
		$this->pdf->SetTextColor( 0,0,0 );
		$this->pdf->Cell($this->pdf->GetPageWidth(), $this->char_height, 
			$this->CI->gesica_sess_utils->get_enterprise_name());

		$y += 2*$this->char_height;
		$this->pdf->SetXY($x,$y);


		$this->pdf->Cell($this->pdf->GetPageWidth() , $this->char_height,strftime("Vente faite le %d/%m/%y a %H:%M") );

		$this->pdf->Ln();



		$this->pdf->SetFontSize($this->zoom(7));
		$this->render_matrix( $this->pdf->GetY(), 
			$matrix , 
			count($cart)+1,8 ,
			0, 
			$header_pcts,
			array( 0x70,0x70,0x70 ),
			array( 0xff , 0xff , 0xff),
			array( 0xff,0xff,0xff ),
			array( 0,0,0 )
		 ); 


		$t1 = "Remise totale : ".$this->CI->gesica_sess_utils->get_global_discount()."%";
		$t2 = "Total : ".$this->CI->gesica_sess_utils->compute_global_total()." FCFA";
		$w1 = $this->pdf->GetStringWidth($t1);
		$w2 = $this->pdf->GetStringWidth($t2);
		$y = $this->pdf->GetY()+2;
		$x= -2*$this->page_margins - max($w1,$w2);

		$this->pdf->SetXY($x,$y);
		$this->pdf->SetTextColor(0,255,0);
		$this->pdf->SetFontSize($this->zoom(10));
		$this->pdf->Cell($this->pdf->GetPageWidth() , $this->char_height ,$t1 );
		$this->pdf->Ln();

		$y += 10;
		$this->pdf->SetXY($x,$y);
		$this->pdf->SetTextColor(255,0,0);
		$this->pdf->Cell($this->pdf->GetPageWidth() , $this->char_height , $t2 );


		$this->pdf->SetAuthor("GESICA / SADII 2018");
		$this->pdf->SetTitle("Facture vente");
		if( $path !== null ){
			$this->pdf->Output('F',$path);
		}else{
			$this->pdf->Output('I');	
		}
		
	}
}
