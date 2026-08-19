<?php
declare(strict_types=1);

function uspeh_register_block_patterns(): void {
    register_block_pattern_category('uspeh-pages', [
        'label' => __('Успех Филтър — Страници', 'uspeh-filter'),
    ]);

    register_block_pattern('uspeh/hero-section', [
        'title'       => __('Hero секция', 'uspeh-filter'),
        'description' => __('Пълноширинна hero секция с фон, заглавие и CTA бутони', 'uspeh-filter'),
        'categories'  => ['uspeh-pages'],
        'content'     => '<!-- wp:cover {"dimRatio":60,"minHeight":500,"align":"full"} -->
<div class="wp-block-cover alignfull" style="min-height:500px">
<span aria-hidden="true" class="wp-block-cover__background has-background-dim-60 has-background-dim"></span>
<div class="wp-block-cover__inner-container">
<!-- wp:heading {"level":1,"textAlign":"center"} -->
<h1 class="wp-block-heading has-text-align-center">Заглавие на секцията</h1>
<!-- /wp:heading -->
<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">Описание на секцията. Редактирайте този текст.</p>
<!-- /wp:paragraph -->
<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons">
<!-- wp:button {"className":"btn btn--accent btn--large"} -->
<div class="wp-block-button btn btn--accent btn--large"><a class="wp-block-button__link wp-element-button">Поискай оферта</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</div>
</div>
<!-- /wp:cover -->',
    ]);

    register_block_pattern('uspeh/two-columns-text-image', [
        'title'       => __('Две колони — текст и изображение', 'uspeh-filter'),
        'description' => __('Секция с текст в лявата колона и изображение в дясната', 'uspeh-filter'),
        'categories'  => ['uspeh-pages'],
        'content'     => '<!-- wp:columns -->
<div class="wp-block-columns">
<!-- wp:column {"width":"50%"} -->
<div class="wp-block-column" style="flex-basis:50%">
<!-- wp:heading -->
<h2 class="wp-block-heading">Заглавие</h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Описание на секцията. Редактирайте този текст според нуждите на страницата.</p>
<!-- /wp:paragraph -->
<!-- wp:list -->
<ul class="wp-block-list"><li>Точка 1</li><li>Точка 2</li><li>Точка 3</li></ul>
<!-- /wp:list -->
</div>
<!-- /wp:column -->
<!-- wp:column {"width":"50%"} -->
<div class="wp-block-column" style="flex-basis:50%">
<!-- wp:image -->
<figure class="wp-block-image"><img alt="Описание"/></figure>
<!-- /wp:image -->
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->',
    ]);

    register_block_pattern('uspeh/three-cards', [
        'title'       => __('Три карти', 'uspeh-filter'),
        'description' => __('Три карти в ред с икона, заглавие и описание', 'uspeh-filter'),
        'categories'  => ['uspeh-pages'],
        'content'     => '<!-- wp:columns -->
<div class="wp-block-columns">
<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Карта 1</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Описание на първата карта.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:column -->
<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Карта 2</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Описание на втората карта.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:column -->
<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Карта 3</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Описание на третата карта.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->',
    ]);

    register_block_pattern('uspeh/cta-banner', [
        'title'       => __('CTA банер', 'uspeh-filter'),
        'description' => __('Пълноширинен банер с призив за действие', 'uspeh-filter'),
        'categories'  => ['uspeh-pages'],
        'content'     => '<!-- wp:group {"align":"full","backgroundColor":"primary","textColor":"white","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-white-color has-primary-background-color has-text-color has-background">
<!-- wp:heading {"textAlign":"center"} -->
<h2 class="wp-block-heading has-text-align-center">Имате въпрос?</h2>
<!-- /wp:heading -->
<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">Свържете се с нас за консултация или оферта.</p>
<!-- /wp:paragraph -->
<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons">
<!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button">Свържете се</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</div>
<!-- /wp:group -->',
    ]);

    register_block_pattern('uspeh/faq-section', [
        'title'       => __('FAQ секция', 'uspeh-filter'),
        'description' => __('Секция с често задавани въпроси', 'uspeh-filter'),
        'categories'  => ['uspeh-pages'],
        'content'     => '<!-- wp:heading -->
<h2 class="wp-block-heading">Често задавани въпроси</h2>
<!-- /wp:heading -->
<!-- wp:details -->
<details class="wp-block-details"><summary>Въпрос 1?</summary><!-- wp:paragraph -->
<p>Отговор на въпрос 1.</p>
<!-- /wp:paragraph --></details>
<!-- /wp:details -->
<!-- wp:details -->
<details class="wp-block-details"><summary>Въпрос 2?</summary><!-- wp:paragraph -->
<p>Отговор на въпрос 2.</p>
<!-- /wp:paragraph --></details>
<!-- /wp:details -->',
    ]);
}
add_action('init', 'uspeh_register_block_patterns');
