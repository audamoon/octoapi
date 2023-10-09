<!DOCTYPE html>
<html lang="ru">
<?php $title = "Вебмастер | Добавить домены — Octoapi";
include  "../assets/layouts/head.php"; ?>

<body>
    <div class="result-window"><span></span></div>
    <div class="wrapper">
        <?php include  "../assets/layouts/header.php" ?>
        <div class="menu-modal"></div>
        <main class="content">
            <div class="main-title container">
                <h1 class="main-title__title">Добавить домены в Вебмастер</h1>
                <p class="main-title__subtitile">По предложениям писать <span class="btn_pink"><a  target="_blank"
                        href="https://t.me/audamoon">сюда</a></span></p>
            </div>
            <div class="container">
                <form class="form" id="connection">
                    <input type="hidden" name="page_url" value="<?= $_SERVER['REQUEST_URI'] ?>" />
                    <div class="form__block">
                        <div class="form__block"><label class="form__label" for="input_token" name="token">Токен API
                                Яндекса</label><input type="text" class="form__input-text" id="input_token" name="token"></div>
                    </div>
                    <div class="form__block"><label class="form__label" for="input_domens" name="doments">Домены</label><textarea placeholder="Вставьте домены сюда в виде: https://your-domen.com" type="text" class="form__textarea" id="input_domens" name="domens"></textarea></div>
                    <input class="form__btn" type="submit" value="Начать">
                </form>
            </div>
        </main>
        <?php include  "../assets/layouts/footer.php" ?>
    </div>
</body>
</html>
