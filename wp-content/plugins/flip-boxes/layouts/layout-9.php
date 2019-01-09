<?php
$layout_html = '';

$layout_html .= '<div class="'.$cols.' cfb-box-'.$i.'">
<div data-effect="'.$effect.'" data-height="'.$height.'" class="cfb-flip">
<div class="'.$effect.'">';

$layout_html .='
<div class="cfb-face front" style="background:'.$flipbox_color_scheme.'"> 
    <div class="cfb-data">
        <div class="cfb-inner-data">
        <div class="cfb-icon-img" style="font-size:'.$icon_size.'">';
        if($flipbox_icon!=''){
            $layout_html .= '<i class="fa '.$flipbox_icon.'"></i>';
        }
        $layout_html .= '</div></div>
    </div>
</div><!-- END .front -->';
		
$layout_html .='<div class="cfb-face back" style="color:'.$flipbox_color_scheme.'">
	<div class="cfb-data">
        <div class="cfb-inner-data">
        <a target="_blank" href="'.esc_url($flipbox_url).'">
        <div class="cfb-icon-img"  style="font-size:'.$icon_size.';color:'.$flipbox_color_scheme.'">';
        if($flipbox_icon!=''){
            $layout_html .= ' <i class="fa '.$flipbox_icon.'"></i>';
        }
        $layout_html .= '</div></a>
        </div>
	</div>
</div>';


$layout_html .= '</div></div></div>';
