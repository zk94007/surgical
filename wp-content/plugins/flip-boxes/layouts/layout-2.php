<?php
$layout_html = '';

$layout_html .= '<div class="'.$cols.' cfb-box-'.$i.'">
<div data-effect="'.$effect.'" data-height="'.$height.'" class="flip">
<div class="'.$effect.'">';


$layout_html .= '<div class="face front">
				<div class="ifb-flip-box-section-with-image cfb-section">
					<div class="inner-with-image">'; 
					
					if(!empty($flipbox_image)){
                        $layout_html .= '<img class="img-thumbnail" src="'.$flipbox_image.'">';
					}
					else 
					{
                        $layout_html .= '<img class="img-thumbnail" src="'.CFB_URL . 'assets/images/black-background.jpg">';
					}
					
					$layout_html .= '</div>
				</div>
			</div> 
			<div class="face back" style="background:'.$flipbox_color_scheme.';"> 
				<div class="ifb-flip-box-section-with-image cfb-section">
					<div class="inner text-center"> 
					<div class="image-title"><p><strong>'.$flipbox_title.'</strong></p></div>
					<div class="image-label"><p>'.$flipbox_label.'</p></div>
					<div class="image-desc"><p>'.$flipbox_truncate.'</p></div>
					<div class="flip_link">
					<p><a target="_blank" href="'.esc_url($flipbox_url).'"><strong>'.$read_more_link.'</strong></a></p>
					</div>
					</div>
				</div>
			</div>';


$layout_html .= '</div></div></div>';
		