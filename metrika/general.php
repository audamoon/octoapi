<!DOCTYPE html>
<html lang="ru">
<?php 
$title = "Метрика - SEO Scripts";
include '../assets/layouts/head.php' ?>


<body>
    <div class="wrapper">
        <?php include '../assets/layouts/header.php'?>
        <div class="menu-modal"></div>
        <main class="content">
            <?php include '../assets/layouts/title.php';
            create_title("Все инструменты для Метрики","для добавления новых разделов пишите", "сюда")?>
            <div class="division container">
                <?php
                include '../assets/layouts/item.php';
                add_item("Добавить", "Добавить поддомены в счетчик", "/assets/images/icons/metrika.svg", "/metrika/add.php", "Метрика")
                ?>
            </div>
        </main>
        <?php include '../assets/layouts/footer.php'?>
    </div>
</body>

</html>