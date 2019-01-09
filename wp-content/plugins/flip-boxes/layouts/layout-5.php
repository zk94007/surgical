<?php
$layout_html = '';
$layout_html .= '<div class="'.$cols.' cfb-box-'.$i.'">
<div data-effect="'.$effect.'" data-height="'.$height.'" class="cfb-flip">
<div class="'.$effect.'">';
$layout_html .='
<div class="cfb-face front" style="background:'.$flipbox_color_scheme.'"> 
    <div class="cfb-data">
        <div class="cfb-inner-data">';
        if($flipbox_icon!=''){
            $layout_html .= '<div class="cfb-icon-img" style="font-size:'.$icon_size.'">
                <i class="fa '.$flipbox_icon.'"></i>
            </div>';
        }
        $layout_html .= '
            <div class="cfb-title">'.$flipbox_title.'</div>
            <div class="cfb-front-desc">'.$flipbox_label.'</div>
        </div>
    </div>
</div><!-- END .front -->
		
<div class="cfb-face back" style="background:'.$flipbox_color_scheme.'">
	<div class="cfb-data">
		<div class="cfb-inner-data">
			<div class="cfb-back-desc"><p>'.$flipbox_truncate.'</p></div>';
            if($read_more_link!=''){
$layout_html .= '<div class="cfb-flip_link">
                    <a target="_blank" href="'.esc_url($flipbox_url).'">
                        <div class="cfb-link_text" style="color:'.$flipbox_color_scheme.'">'.$read_more_link.'</div>
                    </a>
                </div>';
            }
 $layout_html .= '</div>
	</div>
</div>';

$layout_html .= '</div></div></div>';
