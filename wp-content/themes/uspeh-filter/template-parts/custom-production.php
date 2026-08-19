<section class="section section--alt custom-production">
    <div class="container">
        <div class="section__header">
            <span class="section__label"><?php esc_html_e('ИНДИВИДУАЛНО ПРОИЗВОДСТВО', 'uspeh-filter'); ?></span>
            <h2><?php esc_html_e('Не намирате необходимия филтър?', 'uspeh-filter'); ?></h2>
            <p><?php esc_html_e('Произвеждаме филтри по размер, мостра или предоставена техническа документация.', 'uspeh-filter'); ?></p>
        </div>

        <div class="grid grid--3 custom-production__grid">
            <div class="custom-production__card">
                <div class="custom-production__icon">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--color-accent)" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="9" y1="21" x2="9" y2="9"/></svg>
                </div>
                <h3><?php esc_html_e('ПО РАЗМЕР', 'uspeh-filter'); ?></h3>
                <p><?php esc_html_e('Изпратете ширина × височина × дебелина и необходимия клас на филтрация.', 'uspeh-filter'); ?></p>
            </div>

            <div class="custom-production__card">
                <div class="custom-production__icon">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--color-accent)" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
                </div>
                <h3><?php esc_html_e('ПО МОСТРА', 'uspeh-filter'); ?></h3>
                <p><?php esc_html_e('Изпратете снимки или предоставете съществуващ филтър за анализ.', 'uspeh-filter'); ?></p>
            </div>

            <div class="custom-production__card">
                <div class="custom-production__icon">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--color-accent)" stroke-width="1.5"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14,2 14,8 20,8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                </div>
                <h3><?php esc_html_e('ПО ТЕХНИЧЕСКА ДОКУМЕНТАЦИЯ', 'uspeh-filter'); ?></h3>
                <p><?php esc_html_e('Качете чертеж, спецификация или PDF с техническо задание.', 'uspeh-filter'); ?></p>
            </div>
        </div>

        <div class="text-center custom-production__actions">
            <a href="<?php echo esc_url(home_url('/individualno-proizvodstvo/')); ?>" class="btn btn--accent btn--large"><?php esc_html_e('ИЗПРАТИ ЗАПИТВАНЕ', 'uspeh-filter'); ?></a>
        </div>
    </div>
</section>

