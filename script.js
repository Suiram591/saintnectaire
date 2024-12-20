document.querySelectorAll('.section-box').forEach((box) => {
        box.addEventListener('click', () => {
            // Réinitialiser toutes les autres boîtes
            document.querySelectorAll('.section-box').forEach((otherBox) => {
                if (otherBox !== box) {
                    otherBox.classList.remove('expanded');
                }
            });

            // Basculer la classe 'expanded' sur la boîte cliquée
            box.classList.toggle('expanded');
        });
    });



