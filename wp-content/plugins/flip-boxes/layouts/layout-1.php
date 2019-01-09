<?php
$layout_html = '';

	$layout_html .= '<div class="'.$cols.' cfb-box-'.$i.'">
	<div data-effect="'.$effect.'" data-height="'.$height.'" class="flip">
	<div class="'.$effect.'">';
$layout_html .='<div class="face front" style="background: rgb(255, 255, 255); border-style: dashed; border-width: 4px; border-color:'.$flipbox_color_scheme.';"> 

		    <div class="ifb-flip-box-section cfb-section">
            <div class="flip-box-icon_default">
		    <div class="ult-just-icon-wrapper">
		    <div class="align-icon">

			<div class="aio-icon-img " style="font-size:'.$icon_size.'!important; color:'.$flipbox_color_scheme.';display:inline-block;">
			<i class="fa '.$flipbox_icon.'"></i>
			</div>
			</div>
		    </div>
			</div>
			<div class="flip-title" style="color:'.$flipbox_color_scheme.';"><strong>'.$flipbox_title.'</strong></div>
			<div class="flip-label" style="color:'.$flipbox_color_scheme.';">'.$flipbox_label.'</div>
		    </div>
		</div><!-- END .front -->
		
		<div class="face back" style="background:'.$flipbox_color_scheme.';?>; border-style: dashed; border-width: 4px; border-color:'.$flipbox_color_scheme.';">
			<div class="ifb-flip-box-section cfb-section">
			<div class="ifb-desc-back">
			<div class="ifb-flip-box-section-content">
			<div class="default-desc"><p>'.$flipbox_truncate.'</p></div>
				<div class="flip_link">
			  <p><a target="_blank" href="'.esc_url($flipbox_url).'"><strong>'.$read_more_link.'</strong></a></p>
			</div>
			</div>
			</div>
			</div>
		</div>';
		$layout_html .= '</div></div></div>';
		
