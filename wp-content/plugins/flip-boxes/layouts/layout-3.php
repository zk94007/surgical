<?php
$layout_html = '';

$layout_html .= '<div class="'.$cols.' cfb-box-'.$i.'">
<div data-effect="'.$effect.'" data-height="'.$height.'" class="flip">
<div class="'.$effect.'">';

$layout_html .= '<div class="face front" style="color: rgb(51, 51, 51); background:white; border-style: solid; border-width: 1px; border-color:'.$flipbox_color_scheme.';"> 
		   <div class="ifb-flip-box-section cfb-section">
			  <div class="flip-box-icon">
			  <div class="ult-just-icon-wrapper">
			  <div class="align-icon" style="text-align:center;">
			  <div class="aio-icon none " style="color:'.$flipbox_color_scheme.';display:inline-block;">
				<i class="fa '.$flipbox_icon.'" style="font-size:'.$icon_size.'!important;">
				</i>
			  </div>
			  </div>
			  </div>
			  </div>
			  
			  <div class="flip-title" style="color:'.$flipbox_color_scheme.'"><strong>'. $flipbox_title.'</strong></div>
			  <div class="flip-desc" style="color:'.$flipbox_color_scheme.'">'.$flipbox_label.'</div>
			</div>
		</div> <!-- END .front -->
		
		<div class="face back" style="border-style: solid; border-width: 1px; border-color:'.$flipbox_color_scheme.'"> 
		    <div class="ifb-flip-box-section cfb-section">
			<div class="ifb-desc-back">
			<div class="ifb-flip-box-section-content ult-responsive">
			  <div class="with-icon-desc"><p style="color:'.$flipbox_color_scheme.'">'.$flipbox_truncate.'</p></div>
			  <div class="flip_link">
				<p><a target="_blank"  style="color:'.$flipbox_color_scheme.'" href="'.esc_url($flipbox_url).'"><strong>'.$read_more_link.'</strong></a></p>
			   </div>
			</div>
			</div>
		    </div>
        </div>';
$layout_html .= '</div></div></div>';