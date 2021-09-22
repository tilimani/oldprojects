import {
    Swappable,
    Plugins
} from '@shopify/draggable';

export default function GridLayout() {
    const containerSelector = '.editGallery';
    const containers = document.getElementsByName("gallery");

    if (containers.length === 0) {
        return false;
    }

    const swappable = new Swappable(containers, {
        draggable: '.swappable',
        placedTimeout: 800,
        mirror: {
            appendTo: containerSelector,
            constrainDimensions: true,
        },
        plugins: [Plugins.ResizeMirror],
    });

    swappable.on('swappable:start', (event) => {
        let contSwappables = document.getElementsByName("gallery");
        const EraseCheckbox = document.getElementById('deletePic');

        if (EraseCheckbox.classList.contains('deleteConfirm')) {
            event.cancel();
        } else {
            contSwappables.forEach(value => {
                value.classList.add("elementToSwap");
                if (value.id == event.data.dragEvent.data.originalSource.id) {
                    value.classList.remove("elementToSwap");
                }
            });
        }

    });

    swappable.on('swappable:stop', () => {
        const EraseCheckbox = document.getElementById('deletePic');
        if (EraseCheckbox.classList.contains('deleteConfirm')) {
            event.cancel();
        } else {
            containers.forEach(value => {
                value.classList.remove("elementToSwap");
            });
        }
    });

    return swappable;
}
GridLayout();
