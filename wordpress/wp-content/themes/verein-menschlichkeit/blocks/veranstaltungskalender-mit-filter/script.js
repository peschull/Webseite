(function($) {
    'use strict';

    class VeranstaltungskalenderMitFilter {
        constructor() {
            this.container = $('.veranstaltungskalender-mit-filter');
            this.eventsContainer = this.container.find('.events-container');
            this.loadMoreButton = this.container.find('.load-more-button');
            this.filterButtons = this.container.find('.filter-button');
            this.ansichtButtons = this.container.find('.ansicht-button');
            
            this.page = 1;
            this.isLoading = false;
            this.activeFilter = null;
            this.activeAnsicht = this.eventsContainer.data('ansicht');

            this.initEventListeners();
            this.loadEvents();
        }

        initEventListeners() {
            // Filter Buttons
            this.filterButtons.on('click', (e) => {
                const $button = $(e.currentTarget);
                this.filterButtons.removeClass('aktiv');
                $button.addClass('aktiv');
                this.activeFilter = $button.data('kategorie');
                this.resetAndLoad();
            });

            // Ansicht Buttons
            this.ansichtButtons.on('click', (e) => {
                const $button = $(e.currentTarget);
                this.ansichtButtons.removeClass('aktiv');
                $button.addClass('aktiv');
                this.activeAnsicht = $button.data('ansicht');
                this.eventsContainer.attr('data-ansicht', this.activeAnsicht);
                this.resetAndLoad();
            });

            // Load More Button
            this.loadMoreButton.on('click', () => {
                this.loadEvents();
            });
        }

        resetAndLoad() {
            this.page = 1;
            this.eventsContainer.empty();
            this.showLoading();
            this.loadEvents();
        }

        showLoading() {
            this.isLoading = true;
            this.eventsContainer.addClass('loading');
        }

        hideLoading() {
            this.isLoading = false;
            this.eventsContainer.removeClass('loading');
        }

        loadEvents() {
            if (this.isLoading) return;
            
            this.showLoading();

            // WordPress AJAX Request
            $.ajax({
                url: wpApiSettings.root + 'wp/v2/events',
                method: 'GET',
                beforeSend: (xhr) => {
                    xhr.setRequestHeader('X-WP-Nonce', wpApiSettings.nonce);
                },
                data: {
                    page: this.page,
                    per_page: 12,
                    kategorie: this.activeFilter,
                    ansicht: this.activeAnsicht
                }
            })
            .done((response, textStatus, request) => {
                const totalPages = request.getResponseHeader('X-WP-TotalPages');
                this.renderEvents(response);
                
                if (this.page >= totalPages) {
                    this.loadMoreButton.hide();
                } else {
                    this.loadMoreButton.show();
                }

                this.page++;
            })
            .fail((jqXHR, textStatus, errorThrown) => {
                console.error('Fehler beim Laden der Events:', errorThrown);
            })
            .always(() => {
                this.hideLoading();
            });
        }

        renderEvents(events) {
            if (!events.length) {
                this.eventsContainer.append('<p class="keine-events">Keine Veranstaltungen gefunden.</p>');
                return;
            }

            const template = wp.template('event-' + this.activeAnsicht);
            events.forEach(event => {
                const html = template(event);
                this.eventsContainer.append(html);
            });
        }
    }

    // Initialize on document ready
    $(document).ready(() => {
        new VeranstaltungskalenderMitFilter();
    });

})(jQuery);
