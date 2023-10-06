<?php 
function create_title($main_title, $message, $target){
    echo '<div class="main-title container">
    <h1 class="main-title__title">'.$main_title.'</h1>
    <p class="main-title__subtitile">'. $message .' <span class="btn_pink"><a target="_blank"
                href="https://t.me/audamoon">'.$target.'</a></span></p>
    </div>';
}
?>

