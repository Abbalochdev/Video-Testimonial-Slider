(function ($) {
    'use strict';

    class VideoSlider {
        constructor(element) {
            this.slider = element;
            this.track = element.querySelector('.ab-video-track');
            this.videos = Array.from(this.slider.querySelectorAll('.lazy-video'));
            this.init();
        }

        init() {
            this.setupIntersectionObservers();
            // Setup interactions and add play overlays to each video wrapper.
            this.videos.forEach(video => {
                this.setupVideoInteractions(video);
                this.addPlayOverlay(video.parentElement);
            });
        }

        /**
         * Observes each video element so that when it becomes visible,
         * its source is loaded and it auto-plays for 2 seconds.
         */
        setupIntersectionObservers() {
            if ('IntersectionObserver' in window) {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        const video = entry.target;
                        if (entry.isIntersecting && !video.dataset.previewPlayed) {
                            // Load the video if not already done.
                            if (!video.src) {
                                video.src = video.dataset.src;
                            }
                            // Start auto-preview for 2 seconds.
                            this.autoPreview(video);
                            video.dataset.previewPlayed = "true";
                        }
                    });
                }, { threshold: 0.5 });

                this.videos.forEach(video => observer.observe(video));
            } else {
                // Fallback if IntersectionObserver is not supported.
                this.videos.forEach(video => {
                    if (!video.dataset.previewPlayed) {
                        if (!video.src) video.src = video.dataset.src;
                        this.autoPreview(video);
                        video.dataset.previewPlayed = "true";
                    }
                });
            }
        }

        /**
         * Plays the video automatically for 2 seconds and then pauses.
         * After preview, the play overlay is shown.
         */
        autoPreview(video) {
            video.currentTime = 0;
            video.play().then(() => {
                setTimeout(() => {
                    video.pause();
                    this.showPlayOverlay(video.parentElement);
                }, 2000);
            }).catch(err => console.error("Auto preview play failed:", err));
        }

        /**
         * Sets up user interactions.
         * When the user hovers or clicks on the video wrapper, the overlay is removed
         * and the video plays.
         */
        setupVideoInteractions(video) {
            const wrapper = video.parentElement;

            // On mouse enter, remove play overlay and play the video.
            wrapper.addEventListener('mouseenter', () => {
                this.removePlayOverlay(wrapper);
                if (video.paused) {
                    video.play().catch(err => console.warn("Hover play failed:", err));
                }
            });

            // On click, toggle play/pause and update overlay accordingly.
            wrapper.addEventListener('click', () => {
                // Always remove the overlay on click.
                this.removePlayOverlay(wrapper);
                if (video.paused) {
                    video.play().catch(err => console.warn("Click play failed:", err));
                } else {
                    video.pause();
                    this.showPlayOverlay(wrapper);
                }
            });

            // For touch devices: play on tap.
            wrapper.addEventListener('touchstart', () => {
                this.removePlayOverlay(wrapper);
                if (video.paused) {
                    video.play().catch(err => console.warn("Touch play failed:", err));
                }
            });
        }

        /**
         * Adds a play icon overlay to the video wrapper.
         */
        addPlayOverlay(wrapper) {
            if (!wrapper.querySelector('.play-icon')) {
                let icon = document.createElement('div');
                icon.className = "play-icon";
                // The icon styling (background image, size, positioning) should be handled in CSS.
                wrapper.appendChild(icon);
            }
        }

        /**
         * Removes/hides the play icon overlay.
         */
        removePlayOverlay(wrapper) {
            let icon = wrapper.querySelector('.play-icon');
            if (icon) {
                icon.style.display = 'none';
            }
        }

        /**
         * Shows the play icon overlay.
         */
        showPlayOverlay(wrapper) {
            let icon = wrapper.querySelector('.play-icon');
            if (icon) {
                icon.style.display = 'block';
            }
        }
    }

    $(document).ready(() => {
        document.querySelectorAll('.ab-video-slider').forEach((slider) => {
            new VideoSlider(slider);
        });
    });
})(jQuery);