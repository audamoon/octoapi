<!DOCTYPE html>
<html lang="ru">

<?php $title = "Метрика | Добавить поддомены — Octoapi";
include "../assets/layouts/head.php"; ?>

<body>
    <div class="result-window"><span></span></div>
    <div class="wrapper">
        <?php include "../assets/layouts/header.php" ?>
        <div class="menu-modal"></div>
        <main class="content">
            <?php
            include "../assets/layouts/title.php";
            create_title("Подключить", "Вопросы, баги и предложения", "сюда") ?>
            <div class="tutorial container">
                <h2 class="tutorial__title">Инструкция</h2>
                <ol class="tutorial__list beauty-list">
                    <li class="beauty-list__item">Перейдите по <span class="btn_pink"><a target="_blank"
                                href="https://oauth.yandex.ru/authorize?response_type=token&client_id=c4f13ce878b04a5d80036fbd053e82ad">ссылке</a></span>
                        и скопируйте токен
                    </li>
                    <li class="beauty-list__item">Вставьте токен</li>
                    <li class="beauty-list__item">Вставьте номер счетчика</li>
                    <li class="beauty-list__item">Вставьте домены, которые нужно добавить</li>
                    <li class="beauty-list__item">Нажмите начать</li>
                </ol>
            </div>
            <div class="container">
                <form class="form" id="connection">
                <input type="hidden" name="page_url" value="<?= $_SERVER['REQUEST_URI'] ?>" />
                    <div class="form__double">
                        <div class="form__block"><label class="form__label" for="input_token" name="token">Токен API
                                Яндекса</label><input type="text" class="form__input-text" id="input_token"
                                name="token"></div>
                        <div class="form__block"> <label class="form__label" for="input_counter_number"
                                name="counter">Номер
                                счетчика</label><input type="text" class="form__input-text" id="input_counter_number"
                                name="counter">
                        </div>
                    </div>
                    <div class="form__block"><label class="form__label" for="input_domens"
                            name="doments">Домены</label><textarea
                            placeholder="Вставьте домены сюда в виде: https://your-domen.com" type="text" class="form__textarea"
                            id="input_domens" name="domens"></textarea></div>
                    <input class="form__btn" type="submit" value="Начать">
                </form>
            </div>
        </main>
        <?php include "../assets/layouts/footer.php" ?>
    </div>

</body>

</html>