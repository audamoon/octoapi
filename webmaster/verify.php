<!DOCTYPE html>
<html lang="ru">

<?php $title = "Вебмастер | Проверка прав — Octoapi";
include  "../assets/layouts/head.php"; ?>

<body>
    <div class="result-window"><span></span></div>
    <div class="wrapper">
        <?php include  "../assets/layouts/header.php" ?>
        <div class="menu-modal"></div>
        <main class="content">
            <?php include '../assets/layouts/title.php';
            create_title("Запустить проверку прав", "По предложениям писать", "сюда");?>
            <div class="container">
                <form class="form" id="connection">
                    <input type="hidden" name="page_url" value="<?= $_SERVER['REQUEST_URI'] ?>" />
                    <div class="form__block">
                        <div class="form__block"><label class="form__label" for="input_token" name="token">Токен API
                                Яндекса</label><input type="text" class="form__input-text" id="input_token" name="token"></div>
                    </div>
                    <input class="form__btn" type="submit" value="Начать">
                    
                </form>
            </div>
        </main>
        <?php include  "../assets/layouts/footer.php" ?>
    </div>

</body>

</html>
