<!DOCTYPE html>
<html lang="ru">

<?php
$title = "Вебмастер — Octoapi";
include '../assets/layouts/head.php'; ?>

<body>
    <div class="wrapper">
        <?php include '../assets/layouts/header.php' ?>
        <div class="menu-modal"></div>
        <main class="content">
        <?php include '../assets/layouts/title.php';
            create_title("Все инструменты для Вебмастера","для добавления новых разделов пишите", "сюда")?>
            <div class="division container">
                <?php
                include  '../assets/layouts/item.php';
                add_item("Добавить", "Добавить домены в Вебмастер", "/assets/images/icons/webmaster.svg", "/webmaster/add.php", "Вебмастер");
                add_item("Права", "Запустить проверку прав", "/assets/images/icons/webmaster.svg", "/webmaster/verify.php", "Вебмастер");
                add_item("Удалить", "Удалить домены из Вебмастера", "/assets/images/icons/webmaster.svg", "/webmaster/delete.php", "Вебмастер");
                ?>
            </div>
        </main>
        <?php include '../assets/layouts/footer.php' ?>
    </div>
</body>

</html>