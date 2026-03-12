<?php $page_title="Главная страница"; $page_script="sliderScript.js"; include 'header.php'?>
<div class="mainPage">
    <div id="slider" class="slider">
        <button class="prev" id="prevButton"><</button>
        <button class="next" id="nextButton">></button>
        <div class="imageContainer" id="imageContainer">
            <img src="/media/image06.jpg" alt="class" data-index="1" draggable="false">
            <img src="/media/image07.jpg" alt="class" data-index="2" draggable="false">
            <img src="/media/image08.webp" alt="class" data-index="3" draggable="false">
            <img src="/media/image09.webp" alt="class" data-index="4" draggable="false">
        </div>
    </div>
    <div class="popular">
        <h1>Популярные курсы</h1>
        <div class="containerPopular">
            <article>
                <h2>Основы алгоритмизации и программирования</h2>
                <p>Современные технологии разработки сайтов.</p>
            </article>
            <article>
                <h2>Основы веб-дизайна</h2>
                <p>Проектирование интерфейсов.</p>
            </article>
            <article>
                <h2>Основы проектирования баз данных</h2>
                <p>Аналитика и работа с данными.</p>
            </article>
        </div>
    </div>
</div>
<?php include 'footer.php'?>
