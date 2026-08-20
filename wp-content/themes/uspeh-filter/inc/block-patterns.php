<?php
declare(strict_types=1);

/**
 * Gutenberg block patterns — reusable sections + full-page starters.
 */
function uspeh_register_block_patterns(): void {
    register_block_pattern_category('uspeh-pages', [
        'label' => __('Успех Филтър — Страници', 'uspeh-filter'),
    ]);

    register_block_pattern_category('uspeh-starters', [
        'label' => __('Успех Филтър — Стартови страници', 'uspeh-filter'),
    ]);

    uspeh_register_section_patterns();
    uspeh_register_page_starter_patterns();
}
add_action('init', 'uspeh_register_block_patterns');

/**
 * Reusable section patterns.
 */
function uspeh_register_section_patterns(): void {
    register_block_pattern('uspeh/hero-section', [
        'title'       => __('Hero секция', 'uspeh-filter'),
        'description' => __('Пълноширинна hero секция с фон, заглавие и CTA бутони', 'uspeh-filter'),
        'categories'  => ['uspeh-pages'],
        'content'     => '<!-- wp:cover {"dimRatio":50,"minHeight":420,"align":"full","style":{"color":{"duotone":"unset"}}} -->
<div class="wp-block-cover alignfull" style="min-height:420px"><span aria-hidden="true" class="wp-block-cover__background has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:heading {"textAlign":"center","level":1} -->
<h1 class="wp-block-heading has-text-align-center">Заглавие на секцията</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">Описание на секцията. Редактирайте този текст.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons"><!-- wp:button {"textColor":"base","backgroundColor":"accent"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-base-color has-accent-background-color has-text-color has-background wp-element-button" href="/poiskaj-oferta/">Поискай оферта</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div></div>
<!-- /wp:cover -->',
    ]);

    register_block_pattern('uspeh/two-columns-text-image', [
        'title'       => __('Две колони — текст и изображение', 'uspeh-filter'),
        'description' => __('Секция с текст в лявата колона и изображение в дясната', 'uspeh-filter'),
        'categories'  => ['uspeh-pages'],
        'content'     => '<!-- wp:columns {"align":"wide"} -->
<div class="wp-block-columns alignwide"><!-- wp:column {"width":"50%"} -->
<div class="wp-block-column" style="flex-basis:50%"><!-- wp:paragraph {"className":"section__label"} -->
<p class="section__label">ЕТИКЕТ</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Заглавие</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Описание на секцията. Редактирайте този текст според нуждите на страницата.</p>
<!-- /wp:paragraph -->

<!-- wp:list -->
<ul class="wp-block-list"><li>Точка 1</li><li>Точка 2</li><li>Точка 3</li></ul>
<!-- /wp:list -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="/poiskaj-oferta/">Поискай оферта</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"50%"} -->
<div class="wp-block-column" style="flex-basis:50%"><!-- wp:image {"sizeSlug":"large"} -->
<figure class="wp-block-image size-large"><img alt="Описание на изображението"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->',
    ]);

    register_block_pattern('uspeh/three-cards', [
        'title'       => __('Три карти', 'uspeh-filter'),
        'description' => __('Три карти в ред с заглавие и описание', 'uspeh-filter'),
        'categories'  => ['uspeh-pages'],
        'content'     => '<!-- wp:columns {"align":"wide"} -->
<div class="wp-block-columns alignwide"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"style":{"spacing":{"padding":{"top":"1.5rem","right":"1.5rem","bottom":"1.5rem","left":"1.5rem"}},"border":{"width":"1px"}},"borderColor":"hairline","layout":{"type":"constrained"}} -->
<div class="wp-block-group has-border-color has-hairline-border-color" style="border-width:1px;padding-top:1.5rem;padding-right:1.5rem;padding-bottom:1.5rem;padding-left:1.5rem"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Карта 1</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Описание на първата карта.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"style":{"spacing":{"padding":{"top":"1.5rem","right":"1.5rem","bottom":"1.5rem","left":"1.5rem"}},"border":{"width":"1px"}},"borderColor":"hairline","layout":{"type":"constrained"}} -->
<div class="wp-block-group has-border-color has-hairline-border-color" style="border-width:1px;padding-top:1.5rem;padding-right:1.5rem;padding-bottom:1.5rem;padding-left:1.5rem"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Карта 2</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Описание на втората карта.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"style":{"spacing":{"padding":{"top":"1.5rem","right":"1.5rem","bottom":"1.5rem","left":"1.5rem"}},"border":{"width":"1px"}},"borderColor":"hairline","layout":{"type":"constrained"}} -->
<div class="wp-block-group has-border-color has-hairline-border-color" style="border-width:1px;padding-top:1.5rem;padding-right:1.5rem;padding-bottom:1.5rem;padding-left:1.5rem"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Карта 3</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Описание на третата карта.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->',
    ]);

    register_block_pattern('uspeh/cta-banner', [
        'title'       => __('CTA банер', 'uspeh-filter'),
        'description' => __('Пълноширинен банер с призив за действие', 'uspeh-filter'),
        'categories'  => ['uspeh-pages'],
        'content'     => '<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"4rem","bottom":"4rem"}}},"backgroundColor":"contrast","textColor":"base","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-base-color has-contrast-background-color has-text-color has-background" style="padding-top:4rem;padding-bottom:4rem"><!-- wp:heading {"textAlign":"center"} -->
<h2 class="wp-block-heading has-text-align-center">Търсите конкретен филтър или решение по задание?</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">Изпратете размери, снимка или спецификация — търговският ни екип ще предложи подходящо решение.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons"><!-- wp:button {"textColor":"base","backgroundColor":"accent"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-base-color has-accent-background-color has-text-color has-background wp-element-button" href="/poiskaj-oferta/">Изпрати запитване</a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="tel:+35929268833">+359 2 926 88 33</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->',
    ]);

    register_block_pattern('uspeh/faq-section', [
        'title'       => __('FAQ секция', 'uspeh-filter'),
        'description' => __('Секция с често задавани въпроси', 'uspeh-filter'),
        'categories'  => ['uspeh-pages'],
        'content'     => '<!-- wp:heading {"textAlign":"center"} -->
<h2 class="wp-block-heading has-text-align-center">Често задавани въпроси</h2>
<!-- /wp:heading -->

<!-- wp:details -->
<details class="wp-block-details"><summary>Как да поръчам филтър по нестандартен размер?</summary><!-- wp:paragraph -->
<p>Изпратете размери, снимка или чертеж през формата за оферта. Ще изготвим решение според техническото задание.</p>
<!-- /wp:paragraph --></details>
<!-- /wp:details -->

<!-- wp:details -->
<details class="wp-block-details"><summary>Какви класове HEPA предлагате?</summary><!-- wp:paragraph -->
<p>Произвеждаме EPA E10–E12, HEPA H13–H14 и ULPA U15–U17 по EN 1822, с индивидуален сертификат.</p>
<!-- /wp:paragraph --></details>
<!-- /wp:details -->

<!-- wp:details -->
<details class="wp-block-details"><summary>Колко време отнема производството?</summary><!-- wp:paragraph -->
<p>Срокът зависи от типа, количеството и наличността на материали. При запитване ще получите конкретна оферта със срок.</p>
<!-- /wp:paragraph --></details>
<!-- /wp:details -->',
    ]);

    register_block_pattern('uspeh/stats-row', [
        'title'       => __('Статистика / доверие', 'uspeh-filter'),
        'description' => __('Три ключови показателя в ред', 'uspeh-filter'),
        'categories'  => ['uspeh-pages'],
        'content'     => '<!-- wp:columns {"align":"wide"} -->
<div class="wp-block-columns alignwide"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"textAlign":"center","level":3} -->
<h3 class="wp-block-heading has-text-align-center">40+</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">години опит</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"textAlign":"center","level":3} -->
<h3 class="wp-block-heading has-text-align-center">София</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">собствено производство</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"textAlign":"center","level":3} -->
<h3 class="wp-block-heading has-text-align-center">ISO 9001</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">сертифицирано качество</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->',
    ]);
}

/**
 * Full-page starter patterns (1:1 with theme page templates).
 */
function uspeh_register_page_starter_patterns(): void {
    register_block_pattern('uspeh/page-about', [
        'title'       => __('Страница: За нас', 'uspeh-filter'),
        'description' => __('Стартово съдържание за страница „За нас“', 'uspeh-filter'),
        'categories'  => ['uspeh-starters'],
        'keywords'    => ['about', 'за нас', 'компания'],
        'content'     => '<!-- wp:columns {"align":"wide"} -->
<div class="wp-block-columns alignwide"><!-- wp:column {"width":"55%"} -->
<div class="wp-block-column" style="flex-basis:55%"><!-- wp:paragraph -->
<p><strong>ЗА НАС</strong></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1} -->
<h1 class="wp-block-heading">Над 40 години опит във филтрацията</h1>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Успех Филтър ССБ е български производител на професионални филтри за вентилация, климатизация, HEPA приложения, двигатели и индустриални системи. Компанията съчетава дългогодишен опит с модерни технологии.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"45%"} -->
<div class="wp-block-column" style="flex-basis:45%"><!-- wp:image {"sizeSlug":"large"} -->
<figure class="wp-block-image size-large"><img alt="Производство Успех Филтър"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:spacer {"height":"40px"} -->
<div style="height:40px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->

<!-- wp:heading {"textAlign":"center"} -->
<h2 class="wp-block-heading has-text-align-center">История</h2>
<!-- /wp:heading -->

<!-- wp:columns {"align":"wide"} -->
<div class="wp-block-columns alignwide"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center"><strong>1982</strong><br>Основаване на компанията</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center"><strong>2000</strong><br>Въвеждане на HEPA производство</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center"><strong>2015</strong><br>Сертификация ISO 9001:2015</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center"><strong>2020</strong><br>Нови производствени линии</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:spacer {"height":"24px"} -->
<div style="height:24px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->

<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"3rem","bottom":"3rem"}}},"backgroundColor":"contrast","textColor":"base","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-base-color has-contrast-background-color has-text-color has-background" style="padding-top:3rem;padding-bottom:3rem"><!-- wp:heading {"textAlign":"center"} -->
<h2 class="wp-block-heading has-text-align-center">Търсите конкретен филтър?</h2>
<!-- /wp:heading -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons"><!-- wp:button {"textColor":"base","backgroundColor":"accent"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-base-color has-accent-background-color has-text-color has-background wp-element-button" href="/poiskaj-oferta/">Изпрати запитване</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->',
    ]);

    register_block_pattern('uspeh/page-hepa', [
        'title'       => __('Страница: HEPA филтри', 'uspeh-filter'),
        'description' => __('Стартово съдържание за HEPA hub страницата', 'uspeh-filter'),
        'categories'  => ['uspeh-starters'],
        'keywords'    => ['hepa', 'epa', 'ulpa'],
        'content'     => '<!-- wp:heading {"level":1} -->
<h1 class="wp-block-heading">HEPA филтри за крайно очистване на въздуха</h1>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Проектирани за болници, фармацевтична индустрия, лаборатории, чисти помещения, електроника и други приложения с високи изисквания към чистотата на въздуха.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"textColor":"base","backgroundColor":"accent"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-base-color has-accent-background-color has-text-color has-background wp-element-button" href="/poiskaj-oferta/">Поискайте цена</a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="/kontakti/">Свържете се с нас</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->

<!-- wp:spacer {"height":"32px"} -->
<div style="height:32px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Абсолютни филтри от производителя</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Основните HEPA изпълнения, класове и типични приложения — събрани на едно място за бърз избор и запитване за оферта.</p>
<!-- /wp:paragraph -->

<!-- wp:columns {"align":"wide"} -->
<div class="wp-block-columns alignwide"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Изпитване</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Всеки HEPA филтър преминава контрол преди доставка.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Сертификат</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Индивидуален сертификат към високоефективните филтри.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Стандарти</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>EN 1822 • E10–E12 • H13–H14 • U15–U17</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:columns {"align":"wide"} -->
<div class="wp-block-columns alignwide"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Типични приложения</h3>
<!-- /wp:heading -->

<!-- wp:list -->
<ul class="wp-block-list"><li>Операционни блокове и болнични зони</li><li>Фармацевтични и лабораторни помещения</li><li>Чисти помещения и електроника</li></ul>
<!-- /wp:list --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Основни изпълнения</h3>
<!-- /wp:heading -->

<!-- wp:list -->
<ul class="wp-block-list"><li>HEPA H14 сепараторни</li><li>HEPA H14 mini-pleat</li><li>HEPA високодебитни H14</li></ul>
<!-- /wp:list --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"textColor":"base","backgroundColor":"accent"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-base-color has-accent-background-color has-text-color has-background wp-element-button" href="/poiskaj-oferta/">Поискайте оферта</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->',
    ]);

    register_block_pattern('uspeh/page-quality', [
        'title'       => __('Страница: Качество', 'uspeh-filter'),
        'description' => __('Стартово съдържание за качество и сертификати', 'uspeh-filter'),
        'categories'  => ['uspeh-starters'],
        'keywords'    => ['качество', 'iso', 'сертификат'],
        'content'     => '<!-- wp:paragraph -->
<p><strong>КАЧЕСТВО</strong></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1} -->
<h1 class="wp-block-heading">Качество, което може да бъде документирано</h1>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Системата за управление на качеството на Успех Филтър ССБ е сертифицирана по ISO 9001:2015.</p>
<!-- /wp:paragraph -->

<!-- wp:columns {"align":"wide"} -->
<div class="wp-block-columns alignwide"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">ISO 9001:2015</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Система за управление на качеството. Сертификатът е наличен при запитване.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Контрол на производството</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Проверка на всеки етап от производствения процес.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">HEPA изпитване</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>100% контрол на високоефективните филтри.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"textColor":"base","backgroundColor":"accent"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-base-color has-accent-background-color has-text-color has-background wp-element-button" href="/poiskaj-oferta/">Поискайте оферта</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->',
    ]);

    register_block_pattern('uspeh/page-production', [
        'title'       => __('Страница: Производство', 'uspeh-filter'),
        'description' => __('Стартово съдържание за производствената страница', 'uspeh-filter'),
        'categories'  => ['uspeh-starters'],
        'keywords'    => ['производство', 'фабрика'],
        'content'     => '<!-- wp:paragraph -->
<p><strong>СОБСТВЕНО ПРОИЗВОДСТВО</strong></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1} -->
<h1 class="wp-block-heading">От материала до готовия филтър</h1>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Модерно оборудване, контролирани процеси и дългогодишен опит в София.</p>
<!-- /wp:paragraph -->

<!-- wp:columns {"align":"wide"} -->
<div class="wp-block-columns alignwide"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"textAlign":"center","level":3} -->
<h3 class="wp-block-heading has-text-align-center">40+</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">години опит</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"textAlign":"center","level":3} -->
<h3 class="wp-block-heading has-text-align-center">София</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">собствено производство</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"textAlign":"center","level":3} -->
<h3 class="wp-block-heading has-text-align-center">ISO 9001</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">сертифицирано качество</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Как произвеждаме</h2>
<!-- /wp:heading -->

<!-- wp:list {"ordered":true} -->
<ol class="wp-block-list"><li>Подбор на филтърна материя според класа и приложението</li><li>Плисиране и сглобяване в собствена база</li><li>Контрол на размери, уплътнения и конструкция</li><li>Изпитване и документиране преди доставка</li></ol>
<!-- /wp:list -->

<!-- wp:paragraph -->
<p>Разполагаме с оборудване за плисиране, сглобяване, тестване и контрол на въздушни, HEPA, двигателни и индустриални филтри.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"textColor":"base","backgroundColor":"accent"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-base-color has-accent-background-color has-text-color has-background wp-element-button" href="/poiskaj-oferta/">Изпрати запитване</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->',
    ]);

    register_block_pattern('uspeh/page-custom-production', [
        'title'       => __('Страница: Индивидуално производство', 'uspeh-filter'),
        'description' => __('Стартово съдържание за производство по поръчка', 'uspeh-filter'),
        'categories'  => ['uspeh-starters'],
        'keywords'    => ['индивидуално', 'по поръчка', 'custom'],
        'content'     => '<!-- wp:paragraph -->
<p><strong>ИНДИВИДУАЛНО ПРОИЗВОДСТВО</strong></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1} -->
<h1 class="wp-block-heading">Произвеждаме филтри по вашите изисквания</h1>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>По размер, мостра или предоставена техническа документация. Над 40 години производствен опит.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Какво можем да изработим</h2>
<!-- /wp:heading -->

<!-- wp:list -->
<ul class="wp-block-list"><li>Нестандартни размери и рамки</li><li>Специфични класове на филтрация</li><li>Изпълнения по мостра или чертеж</li><li>Малки и средни серии за обекти и машини</li></ul>
<!-- /wp:list -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Изпратете вашите изисквания</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Попълнете формата за оферта с размери, тип и количество. При нужда качете снимка, чертеж или спецификация.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"textColor":"base","backgroundColor":"accent"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-base-color has-accent-background-color has-text-color has-background wp-element-button" href="/poiskaj-oferta/">Изпрати запитване</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->',
    ]);

    register_block_pattern('uspeh/page-applications', [
        'title'       => __('Страница: Приложения', 'uspeh-filter'),
        'description' => __('Стартово съдържание за приложения / отрасли', 'uspeh-filter'),
        'categories'  => ['uspeh-starters'],
        'keywords'    => ['приложения', 'отрасли', 'applications'],
        'content'     => '<!-- wp:paragraph -->
<p><strong>ПРИЛОЖЕНИЯ</strong></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1} -->
<h1 class="wp-block-heading">Къде се използват нашите филтри</h1>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Решения за различни индустрии и приложения, съобразени с конкретните изисквания за чистота на въздуха.</p>
<!-- /wp:paragraph -->

<!-- wp:columns {"align":"wide"} -->
<div class="wp-block-columns alignwide"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading"><a href="/prilozhenia/bolnici/">Болници</a></h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Филтрация за операционни, интензивни и общи болнични зони.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading"><a href="/prilozhenia/farmacia/">Фармация</a></h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Решения за производствени и лабораторни помещения.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading"><a href="/prilozhenia/chisti-pomeshtenia/">Чисти помещения</a></h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>EPA, HEPA и ULPA за контролирана чистота на въздуха.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:columns {"align":"wide"} -->
<div class="wp-block-columns alignwide"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading"><a href="/prilozhenia/industria/">Индустрия</a></h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Филтри за производствени линии и технологични процеси.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading"><a href="/prilozhenia/hoteli/">Хотели</a></h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Комфорт и въздушно качество в обществени и хотелски зони.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading"><a href="/prilozhenia/ofis-sgradi/">Офис сгради</a></h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>HVAC филтрация за офисни и търговски сгради.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"textColor":"base","backgroundColor":"accent"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-base-color has-accent-background-color has-text-color has-background wp-element-button" href="/poiskaj-oferta/">Поискайте оферта</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->',
    ]);

    register_block_pattern('uspeh/page-contact', [
        'title'       => __('Страница: Контакти', 'uspeh-filter'),
        'description' => __('Стартово съдържание за контактна страница', 'uspeh-filter'),
        'categories'  => ['uspeh-starters'],
        'keywords'    => ['контакти', 'contact'],
        'content'     => '<!-- wp:heading {"level":1} -->
<h1 class="wp-block-heading">Контакти</h1>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Свържете се директно с производителя за въздушни, HEPA, двигателни и нестандартни филтри.</p>
<!-- /wp:paragraph -->

<!-- wp:columns {"align":"wide"} -->
<div class="wp-block-columns alignwide"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":2} -->
<h2 class="wp-block-heading">Успех Филтър ССБ</h2>
<!-- /wp:heading -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Търговски отдел</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><a href="tel:+35929268833">+359 2 926 88 33</a><br><a href="tel:+359877899285">+359 877 899 285</a></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Email</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><a href="mailto:info@uspehfilter.com">info@uspehfilter.com</a></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Адрес</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>гр. София, бул. Европа 138, ПК 1360</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Изпратете ни съобщение</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>За бърза оферта използвайте формата за запитване.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"textColor":"base","backgroundColor":"accent"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-base-color has-accent-background-color has-text-color has-background wp-element-button" href="/poiskaj-oferta/">Към формата за оферта</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->',
    ]);

    register_block_pattern('uspeh/page-quote', [
        'title'       => __('Страница: Поискай оферта', 'uspeh-filter'),
        'description' => __('Стартово съдържание за страницата за оферта', 'uspeh-filter'),
        'categories'  => ['uspeh-starters'],
        'keywords'    => ['оферта', 'запитване', 'quote'],
        'content'     => '<!-- wp:paragraph -->
<p><strong>ЗАПИТВАНЕ</strong></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1} -->
<h1 class="wp-block-heading">Поискайте оферта директно от производителя</h1>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Попълнете формата и изпратете размери, снимка, каталожен номер или техническа спецификация. Наш представител ще се свърже с Вас с решение за Вашия обект или машина.</p>
<!-- /wp:paragraph -->

<!-- wp:columns {"align":"wide"} -->
<div class="wp-block-columns alignwide"><!-- wp:column {"width":"60%"} -->
<div class="wp-block-column" style="flex-basis:60%"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Какво да изпратите</h3>
<!-- /wp:heading -->

<!-- wp:list -->
<ul class="wp-block-list"><li>Размери (A × B × H)</li><li>Клас на филтрация</li><li>Снимка на стар филтър или мостра</li><li>Каталожен / OEM номер</li></ul>
<!-- /wp:list -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"textColor":"base","backgroundColor":"accent"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-base-color has-accent-background-color has-text-color has-background wp-element-button" href="/poiskaj-oferta/">Отвори формата</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"40%"} -->
<div class="wp-block-column" style="flex-basis:40%"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Или се свържете директно</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><strong>Търговски отдел</strong><br><a href="tel:+35929268833">+359 2 926 88 33</a><br><a href="tel:+359877899285">+359 877 899 285</a></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><strong>Email</strong><br><a href="mailto:info@uspehfilter.com">info@uspehfilter.com</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->',
    ]);

    register_block_pattern('uspeh/page-faq', [
        'title'       => __('Страница: FAQ', 'uspeh-filter'),
        'description' => __('Стартово FAQ съдържание', 'uspeh-filter'),
        'categories'  => ['uspeh-starters'],
        'keywords'    => ['faq', 'въпроси'],
        'content'     => '<!-- wp:heading {"textAlign":"center","level":1} -->
<h1 class="wp-block-heading has-text-align-center">Често задавани въпроси</h1>
<!-- /wp:heading -->

<!-- wp:details -->
<details class="wp-block-details"><summary>Как да поръчам филтър по нестандартен размер?</summary><!-- wp:paragraph -->
<p>Изпратете размери, снимка или чертеж през формата за оферта.</p>
<!-- /wp:paragraph --></details>
<!-- /wp:details -->

<!-- wp:details -->
<details class="wp-block-details"><summary>Какви класове HEPA предлагате?</summary><!-- wp:paragraph -->
<p>EPA E10–E12, HEPA H13–H14 и ULPA U15–U17 по EN 1822.</p>
<!-- /wp:paragraph --></details>
<!-- /wp:details -->

<!-- wp:details -->
<details class="wp-block-details"><summary>Колко време отнема производството?</summary><!-- wp:paragraph -->
<p>Срокът зависи от типа и количеството — при запитване получавате конкретна оферта.</p>
<!-- /wp:paragraph --></details>
<!-- /wp:details -->

<!-- wp:details -->
<details class="wp-block-details"><summary>Как да разбера какъв клас филтър ми трябва?</summary><!-- wp:paragraph -->
<p>Ако не знаете класа, опишете приложението — болнична зона, офис вентилация, боядисъчна камера — и ние ще предложим подходящия клас по ISO 16890 или EN 1822.</p>
<!-- /wp:paragraph --></details>
<!-- /wp:details -->

<!-- wp:details -->
<details class="wp-block-details"><summary>На колко време се сменя филтърът?</summary><!-- wp:paragraph -->
<p>Правилният критерий е достигнатото крайно съпротивление, измерено с манометър, а не календарът. Ориентировъчно: предфилтри на 3–6 месеца, фини филтри на 6–12 месеца, в зависимост от запрашеността.</p>
<!-- /wp:paragraph --></details>
<!-- /wp:details -->

<!-- wp:details -->
<details class="wp-block-details"><summary>Издавате ли протокол за изпитване?</summary><!-- wp:paragraph -->
<p>Да. За филтри клас H13 и нагоре всеки отделен филтър се изпитва индивидуално и се доставя с протокол по EN 1822.</p>
<!-- /wp:paragraph --></details>
<!-- /wp:details -->

<!-- wp:details -->
<details class="wp-block-details"><summary>Имам стар филтър без каталожен номер — можете ли да го изработите?</summary><!-- wp:paragraph -->
<p>Да. Достатъчни са трите външни размера и снимка на стария филтър. При по-сложни случаи организираме оглед и замерване на място.</p>
<!-- /wp:paragraph --></details>
<!-- /wp:details -->

<!-- wp:details -->
<details class="wp-block-details"><summary>Доставяте ли в цялата страна?</summary><!-- wp:paragraph -->
<p>Да, доставяме до обект в цялата страна. За клиенти с редовни поръчки поддържаме складови наличности и планирани графици за подмяна.</p>
<!-- /wp:paragraph --></details>
<!-- /wp:details -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons"><!-- wp:button {"textColor":"base","backgroundColor":"accent"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-base-color has-accent-background-color has-text-color has-background wp-element-button" href="/poiskaj-oferta/">Изпрати запитване</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->',
    ]);

    register_block_pattern('uspeh/page-thank-you', [
        'title'       => __('Страница: Благодарим', 'uspeh-filter'),
        'description' => __('Стартово съдържание след изпратено запитване', 'uspeh-filter'),
        'categories'  => ['uspeh-starters'],
        'keywords'    => ['благодарност', 'thank you'],
        'content'     => '<!-- wp:heading {"textAlign":"center","level":1} -->
<h1 class="wp-block-heading has-text-align-center">Благодарим за запитването!</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">Получихме информацията. Представител на Успех Филтър ССБ ще се свърже с Вас.</p>
<!-- /wp:paragraph -->

<!-- wp:group {"layout":{"type":"constrained","contentSize":"480px"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center"><strong>За спешно запитване:</strong><br><a href="tel:+35929268833">+359 2 926 88 33</a><br><a href="mailto:info@uspehfilter.com">info@uspehfilter.com</a></p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons"><!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="/">Към началната страница</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->',
    ]);

    register_block_pattern('uspeh/page-landing', [
        'title'       => __('Страница: Landing (Ads)', 'uspeh-filter'),
        'description' => __('Стартово съдържание за Google Ads landing page', 'uspeh-filter'),
        'categories'  => ['uspeh-starters'],
        'keywords'    => ['landing', 'ads', 'кампания'],
        'content'     => '<!-- wp:heading {"level":1} -->
<h1 class="wp-block-heading">Производител на филтри — оферта за 24 часа</h1>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Въздушни, HEPA и нестандартни филтри от собствено производство в София. Изпратете размери или снимка за конкретна оферта.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"textColor":"base","backgroundColor":"accent"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-base-color has-accent-background-color has-text-color has-background wp-element-button" href="#lp-form">Получи оферта от производител</a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="tel:+35929268833">+359 2 926 88 33</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->

<!-- wp:columns {"align":"wide"} -->
<div class="wp-block-columns alignwide"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"textAlign":"center","level":3} -->
<h3 class="wp-block-heading has-text-align-center">40+</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">години опит</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"textAlign":"center","level":3} -->
<h3 class="wp-block-heading has-text-align-center">София</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">собствено производство</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"textAlign":"center","level":3} -->
<h3 class="wp-block-heading has-text-align-center">ISO 9001</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">сертифицирано качество</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Защо Успех Филтър</h2>
<!-- /wp:heading -->

<!-- wp:list -->
<ul class="wp-block-list"><li>Собствено производство — без посредници</li><li>Стандартни и индивидуални размери</li><li>HEPA с индивидуален сертификат</li><li>Бърза оферта по снимка или спецификация</li></ul>
<!-- /wp:list -->

<!-- wp:heading {"anchor":"lp-form"} -->
<h2 class="wp-block-heading" id="lp-form">Поискайте оферта</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Използвайте формата на страницата или се обадете директно на търговския отдел.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"textColor":"base","backgroundColor":"accent"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-base-color has-accent-background-color has-text-color has-background wp-element-button" href="/poiskaj-oferta/">Към формата</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->',
    ]);

    register_block_pattern('uspeh/page-home', [
        'title'       => __('Страница: Начало (Gutenberg)', 'uspeh-filter'),
        'description' => __('Пълна начална страница в блокове — hero, продуктови групи, приложения, производство, HEPA и CTA', 'uspeh-filter'),
        'categories'  => ['uspeh-starters'],
        'keywords'    => ['начало', 'home', 'homepage'],
        'content'     => '<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"3.5rem","bottom":"4rem"}}},"backgroundColor":"base-alt","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-base-alt-background-color has-background" style="padding-top:3.5rem;padding-bottom:4rem"><!-- wp:columns {"verticalAlignment":"center","align":"wide"} -->
<div class="wp-block-columns alignwide are-vertically-aligned-center"><!-- wp:column {"verticalAlignment":"center"} -->
<div class="wp-block-column is-vertically-aligned-center"><!-- wp:paragraph {"className":"section__label"} -->
<p class="section__label">ВИСОКОЕФЕКТИВНИ ПРОДУКТИ</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1} -->
<h1 class="wp-block-heading">Продуктов каталог</h1>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Професионални филтри за вентилация, климатизация, чисти помещения и индустрия — собствено производство в София от над 40 години.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"textColor":"base","backgroundColor":"accent"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-base-color has-accent-background-color has-text-color has-background wp-element-button" href="/vazdushni-filtri/">Разгледайте каталога</a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="/poiskaj-oferta/">Поискай оферта</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center"} -->
<div class="wp-block-column is-vertically-aligned-center"><!-- wp:image {"sizeSlug":"large","align":"center"} -->
<figure class="wp-block-image aligncenter size-large"><img alt="Филтри на Успех Филтър ССБ"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->

<!-- wp:group {"style":{"spacing":{"padding":{"top":"4rem","bottom":"2rem"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="padding-top:4rem;padding-bottom:2rem"><!-- wp:paragraph {"align":"center","className":"section__label"} -->
<p class="has-text-align-center section__label">ПРОДУКТИ И УСЛУГИ</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"textAlign":"center"} -->
<h2 class="wp-block-heading has-text-align-center">Основни групи филтри</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">Производствената гама на Успех Филтър обхваща груба и фина филтрация, високоефективни HEPA решения и филтри за газове, миризми и специални процеси.</p>
<!-- /wp:paragraph -->

<!-- wp:spacer {"height":"2rem"} -->
<div style="height:2rem" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->

<!-- wp:columns {"align":"wide","className":"uspeh-cards"} -->
<div class="wp-block-columns alignwide uspeh-cards"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Предфилтри</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Панелни, таванни и джобни филтри за първа степен на очистване. Класове G2–G4 по ISO 16890.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><a href="/vazdushni-filtri/predfitri/">+ Детайли</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Фина филтрация</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Втора степен за климатични камери — джобни, Mini Pleat и компактни филтри от M5 до F9.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><a href="/vazdushni-filtri/fini-filtri/">+ Детайли</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">EPA, HEPA, ULPA</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Крайна степен за болници, фармация и чисти помещения. Класове E10–U17 по EN 1822.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><a href="/hepa-filtri/">+ Детайли</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Карбонови и специални</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Активен въглен за миризми и газове, филтри за прахови камери, сушилни и боядисване.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><a href="/vazdushni-filtri/karbonovi/">+ Детайли</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"4rem","bottom":"4rem"}}},"backgroundColor":"base-alt","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-base-alt-background-color has-background" style="padding-top:4rem;padding-bottom:4rem"><!-- wp:columns {"verticalAlignment":"center","align":"wide"} -->
<div class="wp-block-columns alignwide are-vertically-aligned-center"><!-- wp:column {"verticalAlignment":"center"} -->
<div class="wp-block-column is-vertically-aligned-center"><!-- wp:paragraph {"className":"section__label"} -->
<p class="section__label">ЗА НАС</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Собствено производство в София</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Успех Филтър ССБ поддържа собствен производствен процес за въздушни, HEPA, карбонови и двигателни филтри — от филтърната материя до готовия продукт. Изпълняваме стандартни серии и нестандартни размери по задание.</p>
<!-- /wp:paragraph -->

<!-- wp:list -->
<ul class="wp-block-list"><!-- wp:list-item -->
<li>Плисиране, сглобяване и контрол в собствена база</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Изработка по размер, касета, рамка и клас на филтрация</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Подходящо за болници, фармация, промишленост и специализирани производства</li>
<!-- /wp:list-item --></ul>
<!-- /wp:list -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="/proizvodstvo/">Виж производството</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center"} -->
<div class="wp-block-column is-vertically-aligned-center"><!-- wp:image {"sizeSlug":"large"} -->
<figure class="wp-block-image size-large"><img alt="Производствена база в София"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:spacer {"height":"2.5rem"} -->
<div style="height:2.5rem" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->

<!-- wp:columns {"align":"wide"} -->
<div class="wp-block-columns alignwide"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":3,"style":{"color":{"text":"#E85D2C"}}} -->
<h3 class="wp-block-heading has-text-color" style="color:#E85D2C">40+</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"fontSize":"small"} -->
<p class="has-small-font-size">години опит във филтрацията</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":3,"style":{"color":{"text":"#E85D2C"}}} -->
<h3 class="wp-block-heading has-text-color" style="color:#E85D2C">София</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"fontSize":"small"} -->
<p class="has-small-font-size">собствена производствена база</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":3,"style":{"color":{"text":"#E85D2C"}}} -->
<h3 class="wp-block-heading has-text-color" style="color:#E85D2C">ISO 9001</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"fontSize":"small"} -->
<p class="has-small-font-size">сертифицирана система за качество</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->

<!-- wp:group {"style":{"spacing":{"padding":{"top":"4rem","bottom":"4rem"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="padding-top:4rem;padding-bottom:4rem"><!-- wp:paragraph {"className":"section__label"} -->
<p class="section__label">ФИЛТРАЦИЯ</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">EPA, HEPA и ULPA за обекти с високи изисквания</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Филтри за крайна степен на очистване на въздуха в болници, фармация, лаборатории, чисти помещения и технологични производства — с индивидуален сертификат за всеки продукт.</p>
<!-- /wp:paragraph -->

<!-- wp:columns {"align":"wide"} -->
<div class="wp-block-columns alignwide"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:list -->
<ul class="wp-block-list"><!-- wp:list-item -->
<li>HEPA сепараторни филтри</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>HEPA mini-pleat филтри</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>HEPA високодебитни H14</li>
<!-- /wp:list-item --></ul>
<!-- /wp:list --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:list -->
<ul class="wp-block-list"><!-- wp:list-item -->
<li>EPA E10 – E12 и HEPA H13 – H14</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>ULPA U15 – U17</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>100% контрол — всеки филтър преминава изпитване</li>
<!-- /wp:list-item --></ul>
<!-- /wp:list --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"textColor":"base","backgroundColor":"accent"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-base-color has-accent-background-color has-text-color has-background wp-element-button" href="/hepa-filtri/">Виж HEPA решенията</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"4rem","bottom":"4rem"}}},"backgroundColor":"contrast","textColor":"base","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-base-color has-contrast-background-color has-text-color has-background" style="padding-top:4rem;padding-bottom:4rem"><!-- wp:paragraph {"align":"center","className":"section__label"} -->
<p class="has-text-align-center section__label">КОНТАКТ</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"textAlign":"center"} -->
<h2 class="wp-block-heading has-text-align-center">Търсите конкретен филтър или решение по задание?</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">Изпратете размери, снимка, каталожен номер или техническа спецификация. Търговският ни екип ще предложи подходяща филтрация за Вашия обект, машина или производство.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons"><!-- wp:button {"textColor":"base","backgroundColor":"accent"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-base-color has-accent-background-color has-text-color has-background wp-element-button" href="/poiskaj-oferta/">Изпрати запитване</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->

<!-- wp:paragraph {"align":"center","fontSize":"small"} -->
<p class="has-text-align-center has-small-font-size">Или се обадете: <a href="tel:+35929268833">+359 2 926 88 33</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->',
    ]);
}
