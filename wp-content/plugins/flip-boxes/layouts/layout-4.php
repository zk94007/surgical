<?php
$layout_html = '';
$layout_html .= '<div class="'.$cols.' cfb-box-'.$i.'">
<div data-effect="'.$effect.'"  data-height="'.$height.'" class="cfb-flip">
<div class="'.$effect.'">';


$layout_html .= '
<div class="cfb-face front" style="border: 2px solid '.$flipbox_color_scheme.'">
    <div class="cfb-data" style="background:'.$flipbox_color_scheme.'">
      <div class="cfb-inner-data">
        <div class="cfb-image">'; 
            if(!empty($flipbox_image)){
                $layout_html .= '<img  class="img-responsive cfb-img-thumbnail" src="'.$flipbox_image.'">';
            }
            else 
            {
                $layout_html .= '<img class="img-responsive cfb-img-thumbnail" src="'.CFB_URL . 'assets/images'.'/layout-4.png">';
            }
          if($flipbox_icon!='')
           {
            $layout_html .= '
            <div class="cfb-icon-img" style="font-size:'.$icon_size.'; color:'.$flipbox_color_scheme.';border: 1px solid'.$flipbox_color_scheme.';">
                <i class="fa '.$flipbox_icon.'"></i>
            </div>';
           }

    $layout_html .='</div>
          
        
        <div class="cfb-title">
            <div class="cfb-front-title" style="color:rgb(255, 255, 255);">
                <strong>'.$flipbox_title.'</strong>
            </div>
        </div>
        </div>
    </div>
</div>';


$layout_html .= '<div class="cfb-face back" style="color: rgb(255, 255, 255); border: 2px solid '.$flipbox_color_scheme.';"> 
				<div class="cfb-data" style="background:'.$flipbox_color_scheme.'">
                    <div class="cfb-inner-data"  >
					   
					    <div class="cfb-desc"><p>'.$flipbox_truncate.'</p></div>';
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
		