<?php
function add_item($division_title, $division_content, $img_src, $href, $alt)
{
    echo '<div class="division__item">
    <a class="division__link" href="'. $href .'">
        <div class="division__icon"><img src="' . $img_src . '" alt="' . $alt.'"></div>
        <h3 class="division__title">' . $division_title . '</h3>
        <div class="division__content">
            <p>' . $division_content . '</p>
        </div>
    </a>
</div>';
}
?>

