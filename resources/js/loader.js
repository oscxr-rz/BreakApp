import lottie from 'lottie-web';

let animation = null;

export function initLoader() {
    const loaderHTML = `
        <div id="pageLoader" style="display: flex !important; align-items: center !important; justify-content: center !important;" class="fixed inset-0 bg-gray-900/20 backdrop-blur-[2px] z-50">
            <div id="lottie-animation" style="display: flex; align-items: center; justify-content: center;" class="w-[280px] h-[280px] sm:w-[350px] sm:h-[350px] md:w-[450px] md:h-[450px]"></div>
        </div>
    `;

    document.body.insertAdjacentHTML('afterbegin', loaderHTML);

    const container = document.getElementById('lottie-animation');

    animation = lottie.loadAnimation({
        container: container,
        renderer: 'svg',
        loop: true,
        autoplay: true,
        path: '/storage/animations/coffee-loader.json'
    });

    animation.addEventListener('DOMLoaded', function () {
        const svgElement = container.querySelector('svg');
        if (svgElement) {
            // Centrar el SVG completamente
            svgElement.style.display = 'block';
            svgElement.style.margin = '0 auto';
            svgElement.style.position = 'relative';
            svgElement.style.left = '0';
            svgElement.style.right = '0';

            const paths = svgElement.querySelectorAll('path, circle, rect, ellipse, line, polyline, polygon');
            paths.forEach(path => {
                const currentStroke = path.getAttribute('stroke-width');
                if (currentStroke) {
                    path.setAttribute('stroke-width', parseFloat(currentStroke) * 4);
                }

                const stroke = path.getAttribute('stroke');
                if (stroke && stroke !== 'none') {
                    path.setAttribute('stroke', '#8B4513');
                }

                const fill = path.getAttribute('fill');
                if (fill && fill !== 'none' && fill !== 'transparent') {
                    if (fill.includes('rgb') || fill.includes('#')) {
                        path.setAttribute('fill', '#8B4513');
                    }
                }
            });

            const stops = svgElement.querySelectorAll('stop');
            stops.forEach(stop => {
                stop.setAttribute('stop-color', '#8B4513');
            });
        }
    });

    window.addEventListener('load', function () {
        setTimeout(() => {
            hideLoader();
        }, 1500);
    });

    return animation;
}

export function hideLoader() {
    const loader = document.getElementById('pageLoader');
    if (loader) {
        loader.style.transition = 'opacity 0.5s ease-out';
        loader.style.opacity = '0';
        setTimeout(() => {
            if (animation) {
                animation.destroy();
                animation = null;
            }
            loader.remove();
        }, 500);
    }
}

export function showLoader() {
    const existingLoader = document.getElementById('pageLoader');
    if (!existingLoader) {
        initLoader();
    } else {
        existingLoader.style.display = 'flex';
        existingLoader.style.opacity = '1';
    }
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initLoader);
} else {
    initLoader();
}