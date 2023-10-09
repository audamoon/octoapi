<!DOCTYPE html>
<html lang="ru">
<?php $title = "Octoapi — помощник для API 😎";
include_once 'assets/layouts/head.php'; ?>

<body>
    <div class="wrapper">
        <?php include_once 'assets/layouts/header.php' ?>

        <div class="menu-modal"></div>

        <main class="content">
            <?php include_once 'assets/layouts/title.php';
            create_title("Все разделы","для добавления новых разделов пишите", "сюда")?>
            <div class="division container">
                <?php
                include_once 'assets/layouts/item.php';
                add_item("Вебмастер", "Все инструменты для управления Вебмастером", "/assets/images/icons/webmaster.svg", "webmaster/general.php", "Вебмастер");
                add_item("Метрика", "Все инструменты для управления Яндекс Метрикой", "/assets/images/icons/metrika.svg", "metrika/general.php", "Метрика");
                ?>
            </div>
        </main>

        <?php include_once 'assets/layouts/footer.php' ?>
    </div>
</body>

</html>