<?php
declare(strict_types=1);

/**
 * Съдържателни block patterns — готови секции с примерно българско съдържание
 * (отзиви, сертификати, процес, таблица с филтърни класове и др.).
 */
function uspeh_register_content_patterns(): void {
    register_block_pattern_category('uspeh-content', [
        'label' => __('Успех Филтър — Съдържание', 'uspeh-filter'),
    ]);

    register_block_pattern('uspeh/testimonials', [
        'title'       => __('Отзиви от клиенти', 'uspeh-filter'),
        'description' => __('Три цитата от клиенти в колони', 'uspeh-filter'),
        'categories'  => ['uspeh-content'],
        'content'     => '<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"4rem","bottom":"4rem"}}},"backgroundColor":"base-alt","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-base-alt-background-color has-background" style="padding-top:4rem;padding-bottom:4rem"><!-- wp:paragraph {"align":"center","className":"section__label"} -->
<p class="has-text-align-center section__label">РЕФЕРЕНЦИИ</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"textAlign":"center"} -->
<h2 class="wp-block-heading has-text-align-center">Какво казват клиентите ни</h2>
<!-- /wp:heading -->

<!-- wp:spacer {"height":"2rem"} -->
<div style="height:2rem" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->

<!-- wp:columns {"align":"wide"} -->
<div class="wp-block-columns alignwide"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:quote -->
<blockquote class="wp-block-quote"><!-- wp:paragraph -->
<p>Работим с Успех Филтър от години. HEPA филтрите за операционните ни зали пристигат навреме, с протокол от изпитване за всеки брой.</p>
<!-- /wp:paragraph --><cite>Инж. екип, многопрофилна болница — София</cite></blockquote>
<!-- /wp:quote --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:quote -->
<blockquote class="wp-block-quote"><!-- wp:paragraph -->
<p>Изработиха ни джобни филтри по индивидуален размер за старите ни климатични камери — без да сменяме рамките. Спестихме сериозна инвестиция.</p>
<!-- /wp:paragraph --><cite>Главен механик, млекопреработвателно предприятие</cite></blockquote>
<!-- /wp:quote --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:quote -->
<blockquote class="wp-block-quote"><!-- wp:paragraph -->
<p>Като ОВК инсталатор ценя, че мога да получа оферта в рамките на деня и филтри за обект в рамките на седмицата. Български производител с реален склад.</p>
<!-- /wp:paragraph --><cite>Управител, фирма за ОВК инсталации</cite></blockquote>
<!-- /wp:quote --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->',
    ]);

    register_block_pattern('uspeh/logo-strip', [
        'title'       => __('Лента с партньори', 'uspeh-filter'),
        'description' => __('Ред с лога на клиенти/партньори', 'uspeh-filter'),
        'categories'  => ['uspeh-content'],
        'content'     => '<!-- wp:group {"style":{"spacing":{"padding":{"top":"2.5rem","bottom":"2.5rem"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="padding-top:2.5rem;padding-bottom:2.5rem"><!-- wp:paragraph {"align":"center","className":"section__label"} -->
<p class="has-text-align-center section__label">ДОВЕРИЕ ОТ ИНДУСТРИЯТА</p>
<!-- /wp:paragraph -->

<!-- wp:columns {"verticalAlignment":"center","align":"wide","isStackedOnMobile":false} -->
<div class="wp-block-columns alignwide are-vertically-aligned-center is-not-stacked-on-mobile"><!-- wp:column {"verticalAlignment":"center"} -->
<div class="wp-block-column is-vertically-aligned-center"><!-- wp:image {"sizeSlug":"medium"} -->
<figure class="wp-block-image size-medium"><img alt="Лого на партньор"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center"} -->
<div class="wp-block-column is-vertically-aligned-center"><!-- wp:image {"sizeSlug":"medium"} -->
<figure class="wp-block-image size-medium"><img alt="Лого на партньор"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center"} -->
<div class="wp-block-column is-vertically-aligned-center"><!-- wp:image {"sizeSlug":"medium"} -->
<figure class="wp-block-image size-medium"><img alt="Лого на партньор"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center"} -->
<div class="wp-block-column is-vertically-aligned-center"><!-- wp:image {"sizeSlug":"medium"} -->
<figure class="wp-block-image size-medium"><img alt="Лого на партньор"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->',
    ]);

    register_block_pattern('uspeh/process-timeline', [
        'title'       => __('Процес на работа (4 стъпки)', 'uspeh-filter'),
        'description' => __('От запитване до доставка — четири стъпки в колони', 'uspeh-filter'),
        'categories'  => ['uspeh-content'],
        'content'     => '<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"4rem","bottom":"4rem"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="padding-top:4rem;padding-bottom:4rem"><!-- wp:paragraph {"align":"center","className":"section__label"} -->
<p class="has-text-align-center section__label">КАК РАБОТИМ</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"textAlign":"center"} -->
<h2 class="wp-block-heading has-text-align-center">От запитване до доставка</h2>
<!-- /wp:heading -->

<!-- wp:spacer {"height":"2rem"} -->
<div style="height:2rem" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->

<!-- wp:columns {"align":"wide","className":"uspeh-cards"} -->
<div class="wp-block-columns alignwide uspeh-cards"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":3,"style":{"color":{"text":"#E85D2C"}}} -->
<h3 class="wp-block-heading has-text-color" style="color:#E85D2C">01</h3>
<!-- /wp:heading -->

<!-- wp:heading {"level":4} -->
<h4 class="wp-block-heading">Запитване</h4>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Изпращате запитване по телефон, имейл или през формата — със или без точна спецификация.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":3,"style":{"color":{"text":"#E85D2C"}}} -->
<h3 class="wp-block-heading has-text-color" style="color:#E85D2C">02</h3>
<!-- /wp:heading -->

<!-- wp:heading {"level":4} -->
<h4 class="wp-block-heading">Спецификация</h4>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Уточняваме размери, филтърен клас и материали. При нужда правим оглед и замерване на място.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":3,"style":{"color":{"text":"#E85D2C"}}} -->
<h3 class="wp-block-heading has-text-color" style="color:#E85D2C">03</h3>
<!-- /wp:heading -->

<!-- wp:heading {"level":4} -->
<h4 class="wp-block-heading">Производство</h4>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Произвеждаме в собствената ни база в София с контрол на качеството на всеки етап.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":3,"style":{"color":{"text":"#E85D2C"}}} -->
<h3 class="wp-block-heading has-text-color" style="color:#E85D2C">04</h3>
<!-- /wp:heading -->

<!-- wp:heading {"level":4} -->
<h4 class="wp-block-heading">Доставка</h4>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Доставяме до обект в цялата страна. За редовни клиенти поддържаме складови наличности.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->',
    ]);

    register_block_pattern('uspeh/certifications', [
        'title'       => __('Сертификати и стандарти', 'uspeh-filter'),
        'description' => __('Карти със сертификати: ISO 9001, EN 1822, ISO 16890', 'uspeh-filter'),
        'categories'  => ['uspeh-content'],
        'content'     => '<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"4rem","bottom":"4rem"}}},"backgroundColor":"base-alt","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-base-alt-background-color has-background" style="padding-top:4rem;padding-bottom:4rem"><!-- wp:paragraph {"align":"center","className":"section__label"} -->
<p class="has-text-align-center section__label">КАЧЕСТВО</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"textAlign":"center"} -->
<h2 class="wp-block-heading has-text-align-center">Сертификати и стандарти</h2>
<!-- /wp:heading -->

<!-- wp:spacer {"height":"2rem"} -->
<div style="height:2rem" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->

<!-- wp:columns {"align":"wide","className":"uspeh-cards"} -->
<div class="wp-block-columns alignwide uspeh-cards"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">ISO 9001:2015</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Сертифицирана система за управление на качеството, обхващаща целия производствен процес — от входящите материали до крайния контрол.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">EN 1822</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>EPA, HEPA и ULPA филтрите се класифицират и изпитват по EN 1822 — с индивидуален протокол за ефективност на всеки филтър от клас H13 нагоре.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">ISO 16890</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Филтрите за обща вентилация се класифицират по ISO 16890 (ePM1, ePM2.5, ePM10) — актуалният европейски стандарт, заменил EN 779.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->',
    ]);

    register_block_pattern('uspeh/downloads', [
        'title'       => __('Файлове за изтегляне', 'uspeh-filter'),
        'description' => __('Списък с каталози и технически документи', 'uspeh-filter'),
        'categories'  => ['uspeh-content'],
        'content'     => '<!-- wp:group {"style":{"spacing":{"padding":{"top":"3rem","bottom":"3rem"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="padding-top:3rem;padding-bottom:3rem"><!-- wp:paragraph {"className":"section__label"} -->
<p class="section__label">ДОКУМЕНТИ</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Каталози и технически материали</h2>
<!-- /wp:heading -->

<!-- wp:list -->
<ul class="wp-block-list"><!-- wp:list-item -->
<li><a href="#">Продуктов каталог — въздушни филтри (PDF)</a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><a href="#">Каталог HEPA / ULPA филтри с технически данни (PDF)</a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><a href="#">Кръстосана таблица двигателни филтри — OEM номера (PDF)</a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><a href="#">Декларации и сертификати за съответствие (PDF)</a></li>
<!-- /wp:list-item --></ul>
<!-- /wp:list -->

<!-- wp:paragraph {"fontSize":"small"} -->
<p class="has-small-font-size">Заменете връзките с реалните файлове от Медия библиотеката.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->',
    ]);

    register_block_pattern('uspeh/filter-class-table', [
        'title'       => __('Таблица с филтърни класове', 'uspeh-filter'),
        'description' => __('Сравнителна таблица G4–U15 по стандарт, ефективност и приложение', 'uspeh-filter'),
        'categories'  => ['uspeh-content'],
        'content'     => '<!-- wp:group {"style":{"spacing":{"padding":{"top":"3rem","bottom":"3rem"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="padding-top:3rem;padding-bottom:3rem"><!-- wp:heading {"textAlign":"center"} -->
<h2 class="wp-block-heading has-text-align-center">Класове на филтрация</h2>
<!-- /wp:heading -->

<!-- wp:spacer {"height":"1.5rem"} -->
<div style="height:1.5rem" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->

<!-- wp:table -->
<figure class="wp-block-table"><table class="has-fixed-layout"><thead><tr><th>Клас</th><th>Стандарт</th><th>Ефективност</th><th>Типични приложения</th></tr></thead><tbody><tr><td>G4</td><td>ISO Coarse &gt;60%</td><td>Груби прахови частици</td><td>Предфилтрация, битова вентилация</td></tr><tr><td>M5–M6</td><td>ISO ePM10</td><td>50–80% за PM10</td><td>Офиси, търговски сгради</td></tr><tr><td>F7–F9</td><td>ISO ePM1</td><td>50–80% за PM1</td><td>Болници (общи зони), фармация, финална филтрация в HVAC</td></tr><tr><td>E10–E12</td><td>EN 1822</td><td>85–99.5% (MPPS)</td><td>Лаборатории, чисти зони</td></tr><tr><td>H13–H14</td><td>EN 1822</td><td>99.95–99.995% (MPPS)</td><td>Операционни, чисти помещения, изолационни стаи</td></tr><tr><td>U15</td><td>EN 1822</td><td>99.9995% (MPPS)</td><td>Микроелектроника, стерилни производства</td></tr></tbody></table></figure>
<!-- /wp:table --></div>
<!-- /wp:group -->',
    ]);

    register_block_pattern('uspeh/team', [
        'title'       => __('Екип', 'uspeh-filter'),
        'description' => __('Три профилни карти с име и роля', 'uspeh-filter'),
        'categories'  => ['uspeh-content'],
        'content'     => '<!-- wp:group {"style":{"spacing":{"padding":{"top":"4rem","bottom":"4rem"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="padding-top:4rem;padding-bottom:4rem"><!-- wp:paragraph {"align":"center","className":"section__label"} -->
<p class="has-text-align-center section__label">ЕКИП</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"textAlign":"center"} -->
<h2 class="wp-block-heading has-text-align-center">Хората зад производството</h2>
<!-- /wp:heading -->

<!-- wp:spacer {"height":"2rem"} -->
<div style="height:2rem" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->

<!-- wp:columns {"align":"wide","className":"uspeh-cards"} -->
<div class="wp-block-columns alignwide uspeh-cards"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:image {"sizeSlug":"medium"} -->
<figure class="wp-block-image size-medium"><img alt="Портрет"/></figure>
<!-- /wp:image -->

<!-- wp:heading {"level":4} -->
<h4 class="wp-block-heading">Име Фамилия</h4>
<!-- /wp:heading -->

<!-- wp:paragraph {"fontSize":"small"} -->
<p class="has-small-font-size">Управител</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:image {"sizeSlug":"medium"} -->
<figure class="wp-block-image size-medium"><img alt="Портрет"/></figure>
<!-- /wp:image -->

<!-- wp:heading {"level":4} -->
<h4 class="wp-block-heading">Име Фамилия</h4>
<!-- /wp:heading -->

<!-- wp:paragraph {"fontSize":"small"} -->
<p class="has-small-font-size">Ръководител производство</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:image {"sizeSlug":"medium"} -->
<figure class="wp-block-image size-medium"><img alt="Портрет"/></figure>
<!-- /wp:image -->

<!-- wp:heading {"level":4} -->
<h4 class="wp-block-heading">Име Фамилия</h4>
<!-- /wp:heading -->

<!-- wp:paragraph {"fontSize":"small"} -->
<p class="has-small-font-size">Търговски отдел</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->',
    ]);

    register_block_pattern('uspeh/industry-section', [
        'title'       => __('Секция за индустрия', 'uspeh-filter'),
        'description' => __('Преизползваем блок за индустриална страница: проблем, решение, CTA', 'uspeh-filter'),
        'categories'  => ['uspeh-content'],
        'content'     => '<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"4rem","bottom":"4rem"}}},"backgroundColor":"contrast","textColor":"base","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-base-color has-contrast-background-color has-text-color has-background" style="padding-top:4rem;padding-bottom:4rem"><!-- wp:paragraph {"align":"center","className":"section__label"} -->
<p class="has-text-align-center section__label">ЗА ВАШИЯ СЕКТОР</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"textAlign":"center"} -->
<h2 class="wp-block-heading has-text-align-center">Филтрация за болници и чисти помещения</h2>
<!-- /wp:heading -->

<!-- wp:columns {"align":"wide"} -->
<div class="wp-block-columns alignwide"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":4} -->
<h4 class="wp-block-heading">Предизвикателството</h4>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Строги изисквания за клас на чистота, валидиране на въздушния поток и документиране на всяка смяна на филтри — при ограничени прозорци за поддръжка.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":4} -->
<h4 class="wp-block-heading">Нашето решение</h4>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>HEPA филтри H13/H14 с индивидуален протокол по EN 1822, произведени по точния размер на касетите ви, с кратки срокове и доставка до обект.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons"><!-- wp:button {"textColor":"base","backgroundColor":"accent"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-base-color has-accent-background-color has-text-color has-background wp-element-button" href="/poiskaj-oferta/">Поискайте консултация</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->',
    ]);
}
add_action('init', 'uspeh_register_content_patterns');
