<?php
$layout_html = '';
$layout_html .= '<div class="cfb-box-'.$i.'" style="padding-left:0;padding-right:0">
<div data-effect="'.$effect.'"  data-height="'.$height.'" class="cfb-flip">
<div class="'.$effect.'">';


$layout_html .= '<div class="cfb-face back"> 
				<div class="cfb-data">
                    <div class="cfb-inner-data"  >
					   
                        <div class="cfb-desc" style="border-bottom:5px solid '.$flipbox_color_scheme.'">';
                        if($flipbox_icon!='')
                        {
                        $layout_html .= '
                        <div class="cfb-icon-img" style="font-size:'.$icon_size.'; background-color:'.$flipbox_color_scheme.'; color: #fff; border-radius: 100%;">
                            <i class="fa '.$flipbox_icon.'"></i>
                        </div>';
                        }
                        $layout_html .= '<h4 class="cfb-back-title" style="color:'.$flipbox_color_scheme.'">'.substr($flipbox_desc, 0, strpos($flipbox_desc, "\n") - 1).'</h4><p class="cfb-back-content">'.substr($flipbox_desc, strpos($flipbox_desc, "\n") + 1).'</p>';
                        //if($read_more_link!=''){
                            $layout_html .= '<div class="cfb-flip_link">
                                                <a target="_blank" href="'.esc_url($flipbox_url).'">
                                                    <div class="cfb-link_text" style="color:#0076a8">LEARN MORE</div>
                                                </a>
                                            </div>';
                          //              }
                             $layout_html .= '</div></div>
				</div>
			</div>';


$layout_html .= '
<div class="cfb-face front">
    <div class="cfb-data">
      <div class="cfb-inner-data">
        <div class="cfb-image">'; 
            if(!empty($flipbox_image)){
                $layout_html .= '<img  class="img-responsive cfb-img-thumbnail" src="'.$flipbox_image.'">';
            }
            else 
            {
                $layout_html .= '<img class="img-responsive cfb-img-thumbnail" src="'.CFB_URL . 'assets/images'.'/layout-4.png">';
            }
            $layout_html .= '<div class="cover-layer" style="background-color:'.$flipbox_color_scheme.'"></div>';

    $layout_html .='</div>
          
        
        <div class="cfb-title">';
            if($flipbox_icon!='')
            {
            $layout_html .= '
            <div class="cfb-icon-img" style="font-size:'.$icon_size.'; color:rgb(255, 255, 255);">
                <i class="fa '.$flipbox_icon.'"></i>
            </div>';
            }
            $layout_html .= '
            <div class="cfb-front-title" style="color:rgb(255, 255, 255);">
                <strong>'.$flipbox_title.'</strong>
            </div>
        </div>
        </div>
    </div>
</div></div></div></div>';

		