<section class="section section--alt how-we-produce">
    <div class="container">
        <div class="section__header">
            <span class="section__label"><?php esc_html_e('ПРОЦЕС', 'uspeh-filter'); ?></span>
            <h2><?php esc_html_e('Как произвеждаме', 'uspeh-filter'); ?></h2>
        </div>
        <div class="how-we-produce__steps">
            <?php
            $steps = [
                ['num' => '01', 'title' => __('Техническо задание', 'uspeh-filter'), 'desc' => __('Анализ на изискванията на клиента', 'uspeh-filter')],
                ['num' => '02', 'title' => __('Подбор на материал', 'uspeh-filter'), 'desc' => __('Избор на подходяща филтърна материя', 'uspeh-filter')],
                ['num' => '03', 'title' => __('Производство', 'uspeh-filter'), 'desc' => __('Плисиране и формоване', 'uspeh-filter')],
                ['num' => '04', 'title' => __('Сглобяване', 'uspeh-filter'), 'desc' => __('Монтаж в рамка и уплътняване', 'uspeh-filter')],
                ['num' => '05', 'title' => __('Контрол / изпитване', 'uspeh-filter'), 'desc' => __('Проверка на всеки филтър', 'uspeh-filter')],
                ['num' => '06', 'title' => __('Опаковане', 'uspeh-filter'), 'desc' => __('Защитна опаковка', 'uspeh-filter')],
                ['num' => '07', 'title' => __('Доставка', 'uspeh-filter'), 'desc' => __('Изпращане до клиента', 'uspeh-filter')],
            ];
            foreach ($steps as $step) : ?>
                <div class="how-we-produce__step">
                    <span class="how-we-produce__num"><?php echo esc_html($step['num']); ?></span>
                    <h3><?php echo esc_html($step['title']); ?></h3>
                    <p><?php echo esc_html($step['desc']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

